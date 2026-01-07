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
    public function perhitungan()
    {
        $courses = Course::all();

        $bobot = [
            'biaya' => 20,
            'rating' => 25,
            'durasi' => 15,
            'fleksibilitas' => 15,
            'sertifikat' => 15,
            'update_terakhir' => 10,
        ];

        $results = [];
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        if ($latestCalculation) {
            $bobot = [
                'biaya' => $latestCalculation->biaya,
                'rating' => $latestCalculation->rating,
                'durasi' => $latestCalculation->durasi,
                'fleksibilitas' => $latestCalculation->fleksibilitas,
                'sertifikat' => $latestCalculation->sertifikat,
                'update_terakhir' => $latestCalculation->update_terakhir,
            ];

            $totalBobot = array_sum($bobot);
            if ($totalBobot > 0) {
                foreach ($bobot as $key => $value) {
                    $bobot[$key] = ($value / $totalBobot) * 100;
                }
            }

            foreach ($latestCalculation->results->sortByDesc('nilai_saw') as $index => $result) {
                $results[] = [
                    'course' => $result->course,
                    'norm_biaya' => $result->norm_biaya,
                    'norm_rating' => $result->norm_rating,
                    'norm_durasi' => $result->norm_durasi,
                    'norm_fleksibilitas' => $result->norm_fleksibilitas,
                    'norm_sertifikat' => $result->norm_sertifikat,
                    'norm_update' => $result->norm_update,
                    'nilai_saw' => $result->nilai_saw,
                ];
            }
        }

        return view('perhitungan', [
            'title' => 'Perhitungan SAW',
            'courses' => $courses,
            'bobot' => $bobot,
            'results' => $results,
        ]);
    }

    /**
     * Menyimpan dan menghitung SAW
     */
    public function storePerhitungan(Request $request)
    {
        $validated = $request->validate([
            'biaya' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0',
            'durasi' => 'required|numeric|min:0',
            'fleksibilitas' => 'required|numeric|min:0',
            'sertifikat' => 'required|numeric|min:0',
            'update_terakhir' => 'required|numeric|min:0',
        ], [
            'biaya.required' => 'Cost weight is required.',
            'rating.required' => 'Rating weight is required.',
            'durasi.required' => 'Duration weight is required.',
            'fleksibilitas.required' => 'Flexibility weight is required.',
            'sertifikat.required' => 'Certificate weight is required.',
            'update_terakhir.required' => 'Last update weight is required.',
        ]);

        $totalBobot = array_sum($validated);
        if ($totalBobot <= 0) {
            return back()->withErrors(['bobot' => 'Total weight must be greater than 0.'])->withInput();
        }

        $calculation = Calculation::create([
            'user_id' => Auth::id(),
            'biaya' => $validated['biaya'],
            'rating' => $validated['rating'],
            'durasi' => $validated['durasi'],
            'fleksibilitas' => $validated['fleksibilitas'],
            'sertifikat' => $validated['sertifikat'],
            'update_terakhir' => $validated['update_terakhir'],
        ]);

        $bobot = [];
        foreach ($validated as $key => $value) {
            $bobot[$key] = ($value / $totalBobot) * 100;
        }

        $courses = Course::all();

        $maxBiaya = $courses->max('biaya');
        $minBiaya = $courses->min('biaya');
        $maxRating = $courses->max('rating');
        $maxDurasi = $courses->max('durasi');
        $minDurasi = $courses->min('durasi');
        $maxFleksibilitas = 5;
        $maxSertifikat = 5;
        $maxUpdate = 5;

        $results = [];
        foreach ($courses as $course) {
            $normBiaya = ($maxBiaya - $minBiaya) > 0
                ? ($maxBiaya - $course->biaya) / ($maxBiaya - $minBiaya)
                : 1;
            $normRating = $maxRating > 0 ? $course->rating / $maxRating : 0;
            $normDurasi = ($maxDurasi - $minDurasi) > 0
                ? ($maxDurasi - $course->durasi) / ($maxDurasi - $minDurasi)
                : 1;
            $normFleksibilitas = $maxFleksibilitas > 0 ? $course->fleksibilitas / $maxFleksibilitas : 0;
            $normSertifikat = $maxSertifikat > 0 ? $course->sertifikat / $maxSertifikat : 0;
            $normUpdate = $maxUpdate > 0 ? $course->update_terakhir / $maxUpdate : 0;

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

        usort($results, function ($a, $b) {
            return $b['nilai_saw'] <=> $a['nilai_saw'];
        });

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

        return redirect()->route('perhitungan')->with('success', 'SAW calculation saved successfully!');
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

        $bobot = [
            'biaya' => $latestCalculation->biaya,
            'rating' => $latestCalculation->rating,
            'durasi' => $latestCalculation->durasi,
            'fleksibilitas' => $latestCalculation->fleksibilitas,
            'sertifikat' => $latestCalculation->sertifikat,
            'update_terakhir' => $latestCalculation->update_terakhir,
        ];

        $totalBobot = array_sum($bobot);
        if ($totalBobot > 0) {
            foreach ($bobot as $key => $value) {
                $bobot[$key] = ($value / $totalBobot) * 100;
            }
        }

        $results = $latestCalculation->results->sortBy('ranking');

        return view('result', [
            'title' => 'Hasil Perhitungan SAW',
            'calculation' => $latestCalculation,
            'bobot' => $bobot,
            'results' => $results,
        ]);
    }

    /**
     * Menampilkan riwayat perhitungan SAW
     */
    public function history()
    {
        $calculations = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->paginate(10);

        return view('calculation-history', [
            'title' => 'Riwayat Perhitungan',
            'calculations' => $calculations,
        ]);
    }
}
