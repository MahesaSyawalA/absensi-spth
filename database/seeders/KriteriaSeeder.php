<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Data yang akan dimasukkan ke dalam tabel kriteria
         $kriteriaData = [
            ['name' => 'disiplin', 'bobot' => 40, 'type' => 'benefit'],
            ['name' => 'kinerja_pegawai', 'bobot' => 30, 'type' => 'benefit'],
            ['name' => 'penggunaan_layanan', 'bobot' => 20, 'type' => 'benefit'],
        ];

        // Insert multiple data
        foreach ($kriteriaData as $data) {
            Kriteria::create($data);
        }
    }
}
