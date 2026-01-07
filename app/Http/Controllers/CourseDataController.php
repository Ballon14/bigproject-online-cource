<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseDataController extends Controller
{
    public function index()
    {
        $courses = Course::orderByDesc('id')->paginate(8);
        return view('data-kursus', [
            'title' => 'Data Courses',
            'courses' => $courses
        ]);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('edit-kursus', [
            'title' => 'Edit Courses',
            'course' => $course
        ]);
    }

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
        ]);
        $course->update($validated);
        return redirect()->route('all-data')->with('success', 'Course data updated successfully!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('all-data')->with('success', 'Course deleted successfully!');
    }
}
