<?php

namespace App\Http\Controllers;

use App\Models\Course;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     */
    public function index()
    {
        $courses = Course::all();
        $totalCourses = $courses->count();

        $stat = [
            'total_courses' => $totalCourses,
            'biaya_min' => $courses->min('biaya') ?? 0,
            'biaya_max' => $courses->max('biaya') ?? 0,
            'biaya_avg' => round($courses->avg('biaya') ?? 0, 1),
            'rating_min' => $courses->min('rating') ?? 0,
            'rating_max' => $courses->max('rating') ?? 0,
            'rating_avg' => round($courses->avg('rating') ?? 0, 2),
            'durasi_total' => $courses->sum('durasi') ?? 0,
            'durasi_avg' => round($courses->avg('durasi') ?? 0, 1),
            'kursus_populer' => $courses->where('rating', '>=', 4.5)->count(),
        ];

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalCourses' => $totalCourses,
            'courses' => $courses,
            'stat' => $stat,
        ]);
    }
}
