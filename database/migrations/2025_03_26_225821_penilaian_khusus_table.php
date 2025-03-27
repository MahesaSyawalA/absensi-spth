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
        //
        Schema::create('penilaian_khusus', function (Blueprint $table) {
            $table->id();
            $table->uuid('penilai_id');
            $table->uuid('user_id');
            $table->string('nama');
            $table->string('email');
            $table->string('tujuan');
            $table->string('pelayanan');
            $table->integer('perilaku_petugas');
            $table->integer('penampilan');
            $table->integer('kecepatan_pelayanan');
            $table->integer('ketepatan_transparansi');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->timestamps();

            $table->unique(['user_id', 'bulan', 'tahun']); // Pastikan hanya satu data per bulan-tahun
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penilai_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('penilaian_khusus');
    }
};
