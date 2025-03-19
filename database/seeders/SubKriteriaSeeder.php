<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubKriteria;
use App\Models\Kriteria;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Data subkriteria berdasarkan kriteria yang ada
        $subKriteriaData = [
            'disiplin' => [
                ['name' => 'Sangat Disiplin', 'nilai' => 40],
                ['name' => 'Disiplin', 'nilai' => 30],
                ['name' => 'Kurang Disiplin', 'nilai' => 20],
                ['name' => 'Tidak Disiplin', 'nilai' => 10],
            ],
            'kinerja_pegawai' => [
                ['name' => 'Sangat Baik', 'nilai' => 40],
                ['name' => 'Baik', 'nilai' => 30],
                ['name' => 'Cukup', 'nilai' => 20],
                ['name' => 'Kurang', 'nilai' => 10],
            ],
            'penggunaan_layanan' => [
                ['name' => 'Sangat Memuaskan', 'nilai' => 40],
                ['name' => 'Memuaskan', 'nilai' => 30],
                ['name' => 'Cukup', 'nilai' => 20],
                ['name' => 'Kurang', 'nilai' => 10],
            ],
        ];

        // Looping setiap kriteria untuk mendapatkan UUID dan menambahkan subkriteria
        foreach ($subKriteriaData as $kriteriaName => $subKriterias) {
            $kriteria = Kriteria::where('name', $kriteriaName)->first();

            if ($kriteria) {
                foreach ($subKriterias as $subKriteria) {
                    SubKriteria::create([
                        'id_kriteria' => $kriteria->uuid,
                        'name' => $subKriteria['name'],
                        'nilai' => $subKriteria['nilai'],
                    ]);
                }
            }
        }
    }
}
