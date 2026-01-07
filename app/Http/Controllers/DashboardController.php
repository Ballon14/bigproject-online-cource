<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

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

    /**
     * Export data courses ke CSV
     */
    public function exportCSV()
    {
        $courses = Course::all();
        $filename = 'courses_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($courses) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'No',
                'Nama Kursus',
                'Biaya (K)',
                'Rating',
                'Durasi (jam)',
                'Fleksibilitas',
                'Sertifikat',
                'Update Terakhir'
            ]);

            // Data rows
            foreach ($courses as $index => $course) {
                fputcsv($file, [
                    $index + 1,
                    $course->nama_kursus,
                    $course->biaya,
                    $course->rating,
                    $course->durasi,
                    $course->fleksibilitas,
                    $course->sertifikat,
                    $course->update_terakhir
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data courses ke Excel (XLSX format via CSV with Excel compatibility)
     */
    public function exportExcel()
    {
        $courses = Course::all();
        $filename = 'courses_' . date('Y-m-d_H-i-s') . '.xls';

        $html = '<table border="1">';
        $html .= '<tr style="background-color: #4F46E5; color: white; font-weight: bold;">';
        $html .= '<th>No</th>';
        $html .= '<th>Nama Kursus</th>';
        $html .= '<th>Biaya (K)</th>';
        $html .= '<th>Rating</th>';
        $html .= '<th>Durasi (jam)</th>';
        $html .= '<th>Fleksibilitas</th>';
        $html .= '<th>Sertifikat</th>';
        $html .= '<th>Update Terakhir</th>';
        $html .= '</tr>';

        foreach ($courses as $index => $course) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($course->nama_kursus) . '</td>';
            $html .= '<td>' . $course->biaya . '</td>';
            $html .= '<td>' . $course->rating . '</td>';
            $html .= '<td>' . $course->durasi . '</td>';
            $html .= '<td>' . $course->fleksibilitas . '</td>';
            $html .= '<td>' . $course->sertifikat . '</td>';
            $html .= '<td>' . $course->update_terakhir . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}
