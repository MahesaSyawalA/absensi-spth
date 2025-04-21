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
        Schema::create('pengajuan_absen', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('nip_pegawai');
            $table->string('nama_pegawai');
            $table->enum('jenis_absen', ['Dinas','Sakit','WFH']);
            $table->text('dokumen');
            $table->enum('status', ['Diterima','Ditolak', 'Pending']);
            $table->timestamp('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_absen');
    }
};
