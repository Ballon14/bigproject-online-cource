<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Calculation;
use Illuminate\Support\Facades\Auth;

class ResultDisplay extends Component
{
    public $calculation = null;
    public $bobot = [];
    public $results = [];

    public function mount()
    {
        $this->loadLatestCalculation();
    }

    protected function loadLatestCalculation()
    {
        $latestCalculation = Calculation::where('user_id', Auth::id())
            ->with('results.course')
            ->latest()
            ->first();

        if (!$latestCalculation) {
            session()->flash('error', 'No calculation results yet. Please calculate SAW first.');
            return $this->redirect(route('perhitungan'), navigate: true);
        }

        $this->calculation = $latestCalculation;

        // Normalisasi bobot untuk display
        $rawBobot = [
            'biaya' => $latestCalculation->biaya,
            'rating' => $latestCalculation->rating,
            'durasi' => $latestCalculation->durasi,
            'fleksibilitas' => $latestCalculation->fleksibilitas,
            'sertifikat' => $latestCalculation->sertifikat,
            'update_terakhir' => $latestCalculation->update_terakhir,
        ];

        $totalBobot = array_sum($rawBobot);
        if ($totalBobot > 0) {
            foreach ($rawBobot as $key => $value) {
                $this->bobot[$key] = ($value / $totalBobot) * 100;
            }
        }

        $this->results = $latestCalculation->results->sortBy('ranking');
    }

    public function render()
    {
        return view('livewire.result-display')->layout('components.layout', ['title' => 'Hasil Perhitungan SAW']);
    }
}

