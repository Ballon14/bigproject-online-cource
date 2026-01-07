<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Calculation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     */
    public function dashboard()
    {
        $totalCourses = Course::count();
        $courses = Course::all();
        $latestRanking = null;
        $chartData = null;

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

    /**
     * Menampilkan statistik detail
     */
    public function statistics()
    {
        $courses = Course::all();

        $statistics = [
            'total_courses' => $courses->count(),
            'biaya' => [
                'min' => $courses->min('biaya'),
                'max' => $courses->max('biaya'),
                'avg' => round($courses->avg('biaya'), 2),
                'sum' => $courses->sum('biaya'),
            ],
            'rating' => [
                'min' => $courses->min('rating'),
                'max' => $courses->max('rating'),
                'avg' => round($courses->avg('rating'), 2),
            ],
            'durasi' => [
                'min' => $courses->min('durasi'),
                'max' => $courses->max('durasi'),
                'avg' => round($courses->avg('durasi'), 2),
                'sum' => $courses->sum('durasi'),
            ],
            'kategori_rating' => [
                'excellent' => $courses->where('rating', '>=', 4.5)->count(),
                'good' => $courses->whereBetween('rating', [3.5, 4.5])->count(),
                'average' => $courses->whereBetween('rating', [2.5, 3.5])->count(),
                'below_average' => $courses->where('rating', '<', 2.5)->count(),
            ],
        ];

        return view('statistics', [
            'title' => 'Statistik',
            'statistics' => $statistics,
        ]);
    }

    /**
     * Menampilkan data analytics untuk grafik
     */
    public function analytics()
    {
        $courses = Course::all();

        $chartData = [
            'rating_distribution' => $courses->groupBy(function ($course) {
                return floor($course->rating);
            })->map->count(),
            'biaya_distribution' => $courses->groupBy(function ($course) {
                if ($course->biaya < 100000) return 'Murah';
                if ($course->biaya < 500000) return 'Sedang';
                return 'Mahal';
            })->map->count(),
            'durasi_distribution' => $courses->groupBy(function ($course) {
                if ($course->durasi < 10) return 'Singkat';
                if ($course->durasi < 30) return 'Sedang';
                return 'Panjang';
            })->map->count(),
            'fleksibilitas_avg' => round($courses->avg('fleksibilitas'), 2),
            'sertifikat_avg' => round($courses->avg('sertifikat'), 2),
        ];

        return view('analytics', [
            'title' => 'Analytics',
            'chartData' => $chartData,
            'courses' => $courses,
        ]);
    }

    /**
     * Export data dashboard ke format tertentu
     */
    public function export()
    {
        $courses = Course::all();
        $calculations = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->get();

        $exportData = [
            'courses' => $courses,
            'calculations' => $calculations,
            'exported_at' => now()->toDateTimeString(),
        ];

        return response()->json($exportData);
    }
}
