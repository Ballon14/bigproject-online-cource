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
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('biaya', 5, 2)->default(0);
            $table->decimal('rating', 5, 2)->default(0);
            $table->decimal('durasi', 5, 2)->default(0);
            $table->decimal('fleksibilitas', 5, 2)->default(0);
            $table->decimal('sertifikat', 5, 2)->default(0);
            $table->decimal('update_terakhir', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
