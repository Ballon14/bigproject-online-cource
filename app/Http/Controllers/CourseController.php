<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Calculation;
use App\Models\CalculationResult;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function dashboard() {
        $totalCourses = Course::count();
        $courses = Course::all();
        // Statistik dummy: ranking/history dan grafik, nanti diisi setelah SPK
        $latestRanking = null; // Nanti diisi array ranking hasil SPK
        $chartData = null;     // Nanti diisi data untuk grafik

        // Statistik tambahan
        $stat = [
            'total_courses'     => $totalCourses,
            'biaya_min'        => $courses->min('biaya'),
            'biaya_max'        => $courses->max('biaya'),
            'biaya_avg'        => round($courses->avg('biaya'), 1),
            'rating_min'       => $courses->min('rating'),
            'rating_max'       => $courses->max('rating'),
            'rating_avg'       => round($courses->avg('rating'), 2),
            'durasi_total'     => $courses->sum('durasi'),
            'durasi_avg'       => round($courses->avg('durasi'), 1),
            'kursus_populer'   => $courses->where('rating', '>=', 4.5)->count(),
        ];

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalCourses' => $totalCourses,
            'courses' => $courses,
            'latestRanking' => $latestRanking,
            'chartData' => $chartData,
            'stat' => $stat,
        ]);
    }

    public function inputData() {
        return view('input-data', [
            'title' => 'Input Data'
        ]);
    }

    public function storeCourse(Request $request) {
        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'durasi' => 'required|integer|min:0',
            'fleksibilitas' => 'required|integer|min:1|max:5',
            'sertifikat' => 'required|integer|min:1|max:5',
            'update_terakhir' => 'required|integer|min:1|max:5',
        ], [
            'nama_kursus.required' => 'Course name is required.',
            'biaya.required' => 'Course cost is required.',
            'rating.required' => 'Course rating is required.',
            'durasi.required' => 'Course duration is required.',
            'fleksibilitas.required' => 'Flexibility is required.',
            'sertifikat.required' => 'Certificate is required.',
            'update_terakhir.required' => 'Last update is required.',
            'rating.max' => 'Rating maximum is 5.0.',
            'fleksibilitas.max' => 'Flexibility maximum is 5.',
            'sertifikat.max' => 'Certificate maximum is 5.',
            'update_terakhir.max' => 'Last update maximum is 5.',
        ]);

        Course::create($validated);

        return redirect()->route('input-data')->with('success', 'New course added successfully!');
    }

    public function index() {
        $courses = Course::orderByDesc('id')->paginate(8);
        return view('data-kursus', [
            'title' => 'Data Courses',
            'courses' => $courses
        ]);
    }

    public function edit($id) {
        $course = Course::findOrFail($id);
        return view('edit-kursus', [
            'title' => 'Edit Courses',
            'course' => $course
        ]);
    }

    public function update(Request $request, $id) {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'durasi' => 'required|integer|min:0',
            'fleksibilitas' => 'required|integer|min:1|max:5',
            'sertifikat' => 'required|integer|min:1|max:5',
            'update_terakhir' => 'required|integer|min:1|max:5',
        ]);
        $course->update($validated);
        return redirect()->route('all-data')->with('success','Course data updated successfully!');
    }

    public function destroy($id) {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('all-data')->with('success','Course deleted successfully!');
    }

    public function perhitungan() {
        $courses = Course::all();

        // Default bobot untuk form
        $bobot = [
            'biaya' => 20,
            'rating' => 25,
            'durasi' => 15,
            'fleksibilitas' => 15,
            'sertifikat' => 15,
            'update_terakhir' => 10,
        ];

        // Ambil hasil terakhir jika ada
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

            // Normalisasi bobot untuk display
            $totalBobot = array_sum($bobot);
            if ($totalBobot > 0) {
                foreach ($bobot as $key => $value) {
                    $bobot[$key] = ($value / $totalBobot) * 100;
                }
            }

            // Format results untuk view
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

    public function storePerhitungan(Request $request) {
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

        // Check total weight must not be 0
        $totalBobot = array_sum($validated);
        if ($totalBobot <= 0) {
            return back()->withErrors(['bobot' => 'Total weight must be greater than 0.'])->withInput();
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

        // Normalisasi bobot untuk perhitungan (persentase)
        $bobot = [];
        foreach ($validated as $key => $value) {
            $bobot[$key] = ($value / $totalBobot) * 100;
        }

        // Ambil semua kursus
        $courses = Course::all();

        // Menentukan max dan min untuk normalisasi
        $maxBiaya = $courses->max('biaya');
        $minBiaya = $courses->min('biaya');
        $maxRating = $courses->max('rating');
        $maxDurasi = $courses->max('durasi');
        $minDurasi = $courses->min('durasi');
        $maxFleksibilitas = 5; // nilai maksimal
        $maxSertifikat = 5; // nilai maksimal
        $maxUpdate = 5; // nilai maksimal

        // Hitung SAW untuk setiap kursus
        $results = [];
        foreach ($courses as $course) {
            // Normalisasi Biaya (Cost - semakin kecil semakin baik)
            $normBiaya = ($maxBiaya - $minBiaya) > 0
                ? ($maxBiaya - $course->biaya) / ($maxBiaya - $minBiaya)
                : 1;

            // Normalisasi Rating (Benefit - semakin besar semakin baik)
            $normRating = $maxRating > 0 ? $course->rating / $maxRating : 0;

            // Normalisasi Durasi (Cost - semakin kecil semakin baik)
            $normDurasi = ($maxDurasi - $minDurasi) > 0
                ? ($maxDurasi - $course->durasi) / ($maxDurasi - $minDurasi)
                : 1;

            // Normalisasi Fleksibilitas (Benefit)
            $normFleksibilitas = $maxFleksibilitas > 0 ? $course->fleksibilitas / $maxFleksibilitas : 0;

            // Normalisasi Sertifikat (Benefit)
            $normSertifikat = $maxSertifikat > 0 ? $course->sertifikat / $maxSertifikat : 0;

            // Normalisasi Update (Benefit)
            $normUpdate = $maxUpdate > 0 ? $course->update_terakhir / $maxUpdate : 0;

            // Hitung nilai SAW
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

        // Sorting berdasarkan nilai SAW (tertinggi ke terendah)
        usort($results, function($a, $b) {
            return $b['nilai_saw'] <=> $a['nilai_saw'];
        });

        // Simpan hasil ke database
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

    public function result() {
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        if (!$latestCalculation) {
            return redirect()->route('perhitungan')->with('error', 'No calculation results yet. Please calculate SAW first.');
        }

        // Normalisasi bobot untuk display
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
}
