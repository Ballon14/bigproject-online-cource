<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Session;

class CourseForm extends Component
{
    public $courseId = null;
    public $nama_kursus = '';
    public $biaya = '';
    public $rating = '';
    public $durasi = '';
    public $fleksibilitas = '';
    public $sertifikat = '';
    public $update_terakhir = '';

    public $isEditing = false;
    public $showSuccessModal = false;

    protected $rules = [
        'nama_kursus' => 'required|string|max:255',
        'biaya' => 'required|numeric|min:0',
        'rating' => 'required|numeric|min:0|max:5',
        'durasi' => 'required|integer|min:0',
        'fleksibilitas' => 'required|integer|min:1|max:5',
        'sertifikat' => 'required|integer|min:1|max:5',
        'update_terakhir' => 'required|integer|min:1|max:5',
    ];

    protected $messages = [
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
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditing = true;
            $this->courseId = $id;
            $course = Course::findOrFail($id);
            $this->nama_kursus = $course->nama_kursus;
            $this->biaya = $course->biaya;
            $this->rating = $course->rating;
            $this->durasi = $course->durasi;
            $this->fleksibilitas = $course->fleksibilitas;
            $this->sertifikat = $course->sertifikat;
            $this->update_terakhir = $course->update_terakhir;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $course = Course::findOrFail($this->courseId);
            $course->update([
                'nama_kursus' => $this->nama_kursus,
                'biaya' => $this->biaya,
                'rating' => $this->rating,
                'durasi' => $this->durasi,
                'fleksibilitas' => $this->fleksibilitas,
                'sertifikat' => $this->sertifikat,
                'update_terakhir' => $this->update_terakhir,
            ]);
            $this->showSuccessModal = true;
            return; // berhenti di sini agar modal tampil, tdk redirect
        } else {
            Course::create([
                'nama_kursus' => $this->nama_kursus,
                'biaya' => $this->biaya,
                'rating' => $this->rating,
                'durasi' => $this->durasi,
                'fleksibilitas' => $this->fleksibilitas,
                'sertifikat' => $this->sertifikat,
                'update_terakhir' => $this->update_terakhir,
            ]);
            Session::flash('success', 'New course added successfully!');
            $this->resetForm();
        }
    }

    protected function resetForm()
    {
        $this->nama_kursus = '';
        $this->biaya = '';
        $this->rating = '';
        $this->durasi = '';
        $this->fleksibilitas = '';
        $this->sertifikat = '';
        $this->update_terakhir = '';
    }

    public function render()
    {
        $title = $this->isEditing ? 'Edit Courses' : 'Input Data';
        return view('livewire.course-form')->layout('components.layout', ['title' => $title]);
    }
}

