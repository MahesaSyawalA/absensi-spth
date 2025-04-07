<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekapan_nilai_akhir', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->integer('bulan'); // Bulan dari rekapan
            $table->integer('tahun'); // Tahun dari rekapan

            // Komponen nilai
            $table->decimal('nilai_absensi', 5, 2)->default(0); // 30%
            $table->decimal('nilai_masyarakat', 5, 2)->default(0); // 50%
            $table->decimal('nilai_penilai', 5, 2)->default(0); // 20%
            $table->decimal('nilai_akhir', 5, 2)->default(0); // Total nilai akhir

            $table->timestamps();

            // Unique constraint agar setiap user hanya punya 1 rekapan per bulan
            $table->unique(['user_id', 'bulan', 'tahun']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekapan_nilai_akhir');
    }
};
