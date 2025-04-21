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
        Schema::create('rekapan_absensi_bulanan', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('total_absen')->default(0);
            $table->integer('total_poin')->default(0);
            $table->decimal('avg_poin', 5, 2)->default(0);
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
        Schema::dropIfExists('rekapan_absensi_bulanan');
    }
};
