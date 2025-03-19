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
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id('uuid'); // ID utama sub_kriteria
            $table->unsignedBigInteger('id_kriteria'); // ID dari tabel kriteria
            $table->string('name');
            $table->integer('nilai');
            $table->timestamps();

            // Menjadikan id_kriteria sebagai foreign key yang merujuk ke id dari tabel kriteria
            $table->foreign('id_kriteria')->references('uuid')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('sub_kriteria');

    }
};
