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
        Schema::create('rekapan_penilaian_bulanan', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('total_penilaian')->default(0);
            $table->decimal('avg_perilaku_petugas', 5, 2)->default(0);
            $table->decimal('avg_penampilan', 5, 2)->default(0);
            $table->decimal('avg_kecepatan_pelayanan', 5, 2)->default(0);
            $table->decimal('avg_ketepatan_transparansi', 5, 2)->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'bulan', 'tahun']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('rekapan_penilaian_bulanan');
    }
};
