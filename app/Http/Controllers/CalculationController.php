<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Calculation;
use App\Models\CalculationResult;
use Illuminate\Support\Facades\Auth;

class CalculationController extends Controller
{
    /**
     * Menampilkan halaman perhitungan SAW
     */
    public function index()
    {
        $courses = Course::all();

        // Load last calculation if exists
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        // Default weights
        $bobot = [
            'biaya' => 20,
            'rating' => 25,
            'durasi' => 15,
            'fleksibilitas' => 15,
            'sertifikat' => 15,
            'update_terakhir' => 10,
        ];

        $results = [];
        $showResults = false;
        $calculationId = null;

        if ($latestCalculation) {
            // Normalize weights for display
            $rawBobot = [
                'biaya' => $latestCalculation->biaya,
                'rating' => $latestCalculation->rating,
                'durasi' => $latestCalculation->durasi,
                'fleksibilitas' => $latestCalculation->fleksibilitas,
                'sertifikat' => $latestCalculation->sertifikat,
                'update_terakhir' => $latestCalculation->update_terakhir,
            ];

            $totalBobot = array_sum($rawBobot);
            if ($totalBobot > 0) {
                foreach ($rawBobot as $key => $value) {
                    $bobot[$key] = ($value / $totalBobot) * 100;
                }
            }

            $calculationId = $latestCalculation->id;
            $results = $latestCalculation->results->sortBy('ranking');
            $showResults = true;
        }

        return view('calculation.index', [
            'title' => 'Perhitungan SAW',
            'courses' => $courses,
            'bobot' => $bobot,
            'results' => $results,
            'showResults' => $showResults,
            'calculationId' => $calculationId,
        ]);
    }

    /**
     * Proses perhitungan SAW dan simpan ke database
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'biaya' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0',
            'durasi' => 'required|numeric|min:0',
            'fleksibilitas' => 'required|numeric|min:0',
            'sertifikat' => 'required|numeric|min:0',
            'update_terakhir' => 'required|numeric|min:0',
        ]);

        $totalBobot = array_sum($validated);
        if ($totalBobot <= 0) {
            return redirect()->back()->with('error', 'Total weight must be greater than 0.');
        }

        $courses = Course::all();
        if ($courses->isEmpty()) {
            return redirect()->back()->with('error', 'No courses available. Please add courses first.');
        }

        // Simpan calculation
        $calculation = Calculation::create([
            'user_id' => Auth::id(),
            'biaya' => $validated['biaya'],
            'rating' => $validated['rating'],
            'durasi' => $validated['durasi'],
            'fleksibilitas' => $validated['fleksibilitas'],
            'sertifikat' => $validated['sertifikat'],
            'update_terakhir' => $validated['update_terakhir'],
        ]);

        // Normalize weights
        $bobot = [
            'biaya' => ($validated['biaya'] / $totalBobot) * 100,
            'rating' => ($validated['rating'] / $totalBobot) * 100,
            'durasi' => ($validated['durasi'] / $totalBobot) * 100,
            'fleksibilitas' => ($validated['fleksibilitas'] / $totalBobot) * 100,
            'sertifikat' => ($validated['sertifikat'] / $totalBobot) * 100,
            'update_terakhir' => ($validated['update_terakhir'] / $totalBobot) * 100,
        ];

        // Determine max and min for normalization
        $maxBiaya = $courses->max('biaya');
        $minBiaya = $courses->min('biaya');
        $maxRating = $courses->max('rating');
        $maxDurasi = $courses->max('durasi');
        $minDurasi = $courses->min('durasi');
        $maxFleksibilitas = 5;
        $maxSertifikat = 5;
        $maxUpdate = 5;

        // Calculate SAW for each course
        $results = [];
        foreach ($courses as $course) {
            // Cost normalization (lower is better)
            $normBiaya = ($maxBiaya - $minBiaya) > 0
                ? ($maxBiaya - $course->biaya) / ($maxBiaya - $minBiaya)
                : 1;

            // Rating normalization (higher is better)
            $normRating = $maxRating > 0 ? $course->rating / $maxRating : 0;

            // Duration normalization (lower is better)
            $normDurasi = ($maxDurasi - $minDurasi) > 0
                ? ($maxDurasi - $course->durasi) / ($maxDurasi - $minDurasi)
                : 1;

            // Benefit criteria normalization
            $normFleksibilitas = $maxFleksibilitas > 0 ? $course->fleksibilitas / $maxFleksibilitas : 0;
            $normSertifikat = $maxSertifikat > 0 ? $course->sertifikat / $maxSertifikat : 0;
            $normUpdate = $maxUpdate > 0 ? $course->update_terakhir / $maxUpdate : 0;

            // Calculate SAW value
            $nilaiSAW = (
                ($normBiaya * $bobot['biaya']) +
                ($normRating * $bobot['rating']) +
                ($normDurasi * $bobot['durasi']) +
                ($normFleksibilitas * $bobot['fleksibilitas']) +
                ($normSertifikat * $bobot['sertifikat']) +
                ($normUpdate * $bobot['update_terakhir'])
            ) / 100;

            $results[] = [
                'course_id' => $course->id,
                'norm_biaya' => round($normBiaya, 4),
                'norm_rating' => round($normRating, 4),
                'norm_durasi' => round($normDurasi, 4),
                'norm_fleksibilitas' => round($normFleksibilitas, 4),
                'norm_sertifikat' => round($normSertifikat, 4),
                'norm_update' => round($normUpdate, 4),
                'nilai_saw' => round($nilaiSAW, 4),
            ];
        }

        // Sort by SAW value (highest first)
        usort($results, function($a, $b) {
            return $b['nilai_saw'] <=> $a['nilai_saw'];
        });

        // Delete old results and save new ones
        CalculationResult::where('calculation_id', $calculation->id)->delete();

        foreach ($results as $index => $result) {
            CalculationResult::create([
                'calculation_id' => $calculation->id,
                'course_id' => $result['course_id'],
                'norm_biaya' => $result['norm_biaya'],
                'norm_rating' => $result['norm_rating'],
                'norm_durasi' => $result['norm_durasi'],
                'norm_fleksibilitas' => $result['norm_fleksibilitas'],
                'norm_sertifikat' => $result['norm_sertifikat'],
                'norm_update' => $result['norm_update'],
                'nilai_saw' => $result['nilai_saw'],
                'ranking' => $index + 1,
            ]);
        }

        return redirect()->route('result')->with('success', 'SAW calculation saved successfully!');
    }

    /**
     * Menampilkan hasil perhitungan SAW
     */
    public function result()
    {
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        if (!$latestCalculation) {
            return redirect()->route('perhitungan')->with('error', 'No calculation results yet. Please calculate SAW first.');
        }

        // Normalize weights for display
        $rawBobot = [
            'biaya' => $latestCalculation->biaya,
            'rating' => $latestCalculation->rating,
            'durasi' => $latestCalculation->durasi,
            'fleksibilitas' => $latestCalculation->fleksibilitas,
            'sertifikat' => $latestCalculation->sertifikat,
            'update_terakhir' => $latestCalculation->update_terakhir,
        ];

        $bobot = [];
        $totalBobot = array_sum($rawBobot);
        if ($totalBobot > 0) {
            foreach ($rawBobot as $key => $value) {
                $bobot[$key] = ($value / $totalBobot) * 100;
            }
        }

        $results = $latestCalculation->results->sortBy('ranking');

        return view('calculation.result', [
            'title' => 'Hasil Perhitungan SAW',
            'calculation' => $latestCalculation,
            'bobot' => $bobot,
            'results' => $results,
        ]);
    }
}
