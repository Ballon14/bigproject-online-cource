<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseInputController extends Controller
{
    /**
     * Menampilkan form input data kursus
     */
    public function inputData()
    {
        return view('input-data', [
            'title' => 'Input Data'
        ]);
    }

    /**
     * Menyimpan data kursus baru
     */
    public function storeCourse(Request $request)
    {
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

    /**
     * Import data kursus secara bulk dari file
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $data = [];

        // Baca file CSV
        if (($handle = fopen($file->getPathname(), 'r')) !== false) {
            $header = fgetcsv($handle); // Skip header row
            
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) >= 7) {
                    $data[] = [
                        'nama_kursus' => $row[0],
                        'biaya' => (float) $row[1],
                        'rating' => (float) $row[2],
                        'durasi' => (int) $row[3],
                        'fleksibilitas' => (int) $row[4],
                        'sertifikat' => (int) $row[5],
                        'update_terakhir' => (int) $row[6],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            fclose($handle);
        }

        if (!empty($data)) {
            Course::insert($data);
            return redirect()->route('input-data')
                ->with('success', count($data) . ' courses imported successfully!');
        }

        return redirect()->route('input-data')
            ->with('error', 'No valid data found in file.');
    }

    /**
     * Preview data kursus sebelum disimpan
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'rating' => 'required|numeric|min:0|max:5',
            'durasi' => 'required|integer|min:0',
            'fleksibilitas' => 'required|integer|min:1|max:5',
            'sertifikat' => 'required|integer|min:1|max:5',
            'update_terakhir' => 'required|integer|min:1|max:5',
        ]);

        // Hitung preview score berdasarkan default bobot
        $bobot = [
            'biaya' => 0.20,
            'rating' => 0.25,
            'durasi' => 0.15,
            'fleksibilitas' => 0.15,
            'sertifikat' => 0.15,
            'update_terakhir' => 0.10,
        ];

        $previewScore = (
            (1 - ($validated['biaya'] / 1000000)) * $bobot['biaya'] +
            ($validated['rating'] / 5) * $bobot['rating'] +
            (1 - ($validated['durasi'] / 100)) * $bobot['durasi'] +
            ($validated['fleksibilitas'] / 5) * $bobot['fleksibilitas'] +
            ($validated['sertifikat'] / 5) * $bobot['sertifikat'] +
            ($validated['update_terakhir'] / 5) * $bobot['update_terakhir']
        );

        return response()->json([
            'data' => $validated,
            'preview_score' => round($previewScore, 4),
            'message' => 'Preview generated successfully',
        ]);
    }
}
