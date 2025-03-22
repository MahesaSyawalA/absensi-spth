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
        Schema::create('penilaian_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('nama');
            $table->string('email');
            $table->string('tujuan');
            $table->string('pelayanan');
            $table->integer('perilaku_petugas');
            $table->integer('penampilan');
            $table->integer('kecepatan_pelayanan');
            $table->integer('ketepatan_transparansi');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_masyarakat');
    }
};
