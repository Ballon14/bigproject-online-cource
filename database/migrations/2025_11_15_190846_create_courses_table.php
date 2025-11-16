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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kursus');
            $table->integer('biaya');    // Dalam ribuan rupiah
            $table->float('rating', 2, 1);  // Contoh: 4.7
            $table->integer('durasi');   // Dalam jam
            $table->tinyInteger('fleksibilitas');
            $table->tinyInteger('sertifikat');
            $table->tinyInteger('update_terakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
