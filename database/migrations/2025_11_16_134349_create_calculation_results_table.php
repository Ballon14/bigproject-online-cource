<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calculation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_id')->constrained('calculations')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('norm_biaya', 8, 4)->default(0);
            $table->decimal('norm_rating', 8, 4)->default(0);
            $table->decimal('norm_durasi', 8, 4)->default(0);
            $table->decimal('norm_fleksibilitas', 8, 4)->default(0);
            $table->decimal('norm_sertifikat', 8, 4)->default(0);
            $table->decimal('norm_update', 8, 4)->default(0);
            $table->decimal('nilai_saw', 8, 4)->default(0);
            $table->integer('ranking')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_results');
    }
};
