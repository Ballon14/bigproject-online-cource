<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Calculation;
use App\Models\CalculationResult;
use Illuminate\Support\Facades\Auth;

class PerhitunganSaw extends Component
{
    // Properties untuk bobot kriteria
    public $biaya = 20;
    public $rating = 25;
    public $durasi = 15;
    public $fleksibilitas = 15;
    public $sertifikat = 15;
    public $update_terakhir = 10;

    // Properties untuk hasil
    public $results = [];
    public $bobot = [];
    public $courses = [];
    public $showResults = false;
    public $calculationId = null;

    // Loading state
    public $isCalculating = false;

    // Error messages
    public $errorMessage = '';

    public function mount()
    {
        // Load courses - keep as collection for view

        // Load last calculation if exists
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        if ($latestCalculation) {
            // Set bobot dari calculation terakhir
            $rawBobot = [
                'biaya' => $latestCalculation->biaya,
                'rating' => $latestCalculation->rating,
                'durasi' => $latestCalculation->durasi,
                'fleksibilitas' => $latestCalculation->fleksibilitas,
                'sertifikat' => $latestCalculation->sertifikat,
                'update_terakhir' => $latestCalculation->update_terakhir,
            ];

            // Normalisasi untuk display
            $totalBobot = array_sum($rawBobot);
            if ($totalBobot > 0) {
                foreach ($rawBobot as $key => $value) {
                    $this->$key = ($value / $totalBobot) * 100;
                }
            }

            // Load results
            $this->loadResults($latestCalculation);
        }
    }

    // Computed property untuk total bobot
    public function getTotalBobotProperty()
    {
        return $this->biaya + $this->rating + $this->durasi +
               $this->fleksibilitas + $this->sertifikat + $this->update_terakhir;
    }

    // Real-time preview calculation (tidak save ke database)
    public function preview()
    {
        $this->validateWeights();

        if ($this->errorMessage) {
            return;
        }

        $this->isCalculating = true;
        $this->calculateResults(false); // false = tidak save ke database
        $this->isCalculating = false;
    }

    // Calculate and save to database
    public function calculate()
    {
        $this->validateWeights();

        if ($this->errorMessage) {
            return;
        }

        $this->isCalculating = true;
        $this->errorMessage = '';

        try {
            // Simpan calculation
            $calculation = Calculation::create([
                'user_id' => Auth::id(),
                'biaya' => $this->biaya,
                'rating' => $this->rating,
                'durasi' => $this->durasi,
                'fleksibilitas' => $this->fleksibilitas,
                'sertifikat' => $this->sertifikat,
                'update_terakhir' => $this->update_terakhir,
            ]);

            $this->calculationId = $calculation->id;

            // Calculate and save results
            $this->calculateResults(true, $calculation);

            $this->showResults = true;
            session()->flash('success', 'SAW calculation saved successfully!');
        } catch (\Exception $e) {
            $this->errorMessage = 'Error calculating: ' . $e->getMessage();
        } finally {
            $this->isCalculating = false;
        }
    }

    protected function validateWeights()
    {
        $this->errorMessage = '';

        // Check if all weights are numeric
        $weights = [
            $this->biaya,
            $this->rating,
            $this->durasi,
            $this->fleksibilitas,
            $this->sertifikat,
            $this->update_terakhir,
        ];

        foreach ($weights as $weight) {
            if (!is_numeric($weight) || $weight < 0) {
                $this->errorMessage = 'All weights must be numeric and greater than or equal to 0.';
                return;
            }
        }

        // Check total weight
        $total = array_sum($weights);
        if ($total <= 0) {
            $this->errorMessage = 'Total weight must be greater than 0.';
            return;
        }
    }

    protected function calculateResults($saveToDatabase = false, $calculation = null)
    {
        // Reload courses
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->errorMessage = 'No courses available. Please add courses first.';
            return;
        }

        // Normalisasi bobot untuk perhitungan (persentase)
        $totalBobot = $this->totalBobot;
        $bobot = [
            'biaya' => ($this->biaya / $totalBobot) * 100,
            'rating' => ($this->rating / $totalBobot) * 100,
            'durasi' => ($this->durasi / $totalBobot) * 100,
            'fleksibilitas' => ($this->fleksibilitas / $totalBobot) * 100,
            'sertifikat' => ($this->sertifikat / $totalBobot) * 100,
            'update_terakhir' => ($this->update_terakhir / $totalBobot) * 100,
        ];

        $this->bobot = $bobot;

        // Menentukan max dan min untuk normalisasi
        $maxBiaya = $courses->max('biaya');
        $minBiaya = $courses->min('biaya');
        $maxRating = $courses->max('rating');
        $maxDurasi = $courses->max('durasi');
        $minDurasi = $courses->min('durasi');
        $maxFleksibilitas = 5;
        $maxSertifikat = 5;
        $maxUpdate = 5;

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
                'course' => $course,
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

        // Simpan hasil ke database jika diperlukan
        if ($saveToDatabase && $calculation) {
            // Delete old results
            CalculationResult::where('calculation_id', $calculation->id)->delete();

            // Save new results
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
        }

        $this->results = $results;
        $this->showResults = true;
    }

    protected function loadResults($calculation)
    {
        $this->calculationId = $calculation->id;
        $this->results = [];

        foreach ($calculation->results->sortByDesc('nilai_saw') as $result) {
            $this->results[] = [
                'course_id' => $result->course_id,
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

        // Normalisasi bobot untuk display
        $rawBobot = [
            'biaya' => $calculation->biaya,
            'rating' => $calculation->rating,
            'durasi' => $calculation->durasi,
            'fleksibilitas' => $calculation->fleksibilitas,
            'sertifikat' => $calculation->sertifikat,
            'update_terakhir' => $calculation->update_terakhir,
        ];

        $totalBobot = array_sum($rawBobot);
        if ($totalBobot > 0) {
            foreach ($rawBobot as $key => $value) {
                $this->bobot[$key] = ($value / $totalBobot) * 100;
            }
        }

        $this->showResults = true;
    }

    public function render()
    {
        $courses = Course::all();
        return view('livewire.perhitungan-saw', [
            'courses' => $courses,
        ])->layout('components.layout', ['title' => 'Perhitungan SAW']);
    }
}

