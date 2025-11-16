<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculation_id',
        'course_id',
        'norm_biaya',
        'norm_rating',
        'norm_durasi',
        'norm_fleksibilitas',
        'norm_sertifikat',
        'norm_update',
        'nilai_saw',
        'ranking',
    ];

    public function calculation()
    {
        return $this->belongsTo(Calculation::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
