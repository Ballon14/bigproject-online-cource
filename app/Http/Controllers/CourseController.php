<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Menampilkan daftar semua courses dengan pagination dan search
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');

        $courses = Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_kursus', 'like', '%' . $search . '%');
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(8)
            ->appends(['search' => $search, 'sort' => $sortField, 'direction' => $sortDirection]);

        return view('courses.index', [
            'title' => 'Data Courses',
            'courses' => $courses,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Menampilkan form tambah course baru
     */
    public function create()
    {
        return view('courses.create', [
            'title' => 'Input Data',
        ]);
    }

    /**
     * Menyimpan course baru
     */
    public function store(Request $request)
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

        return redirect()->route('courses.create')->with('success', 'New course added successfully!');
    }

    /**
     * Menampilkan form edit course
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('courses.edit', [
            'title' => 'Edit Course',
            'course' => $course,
        ]);
    }

    /**
     * Update course
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

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

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Hapus course
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
