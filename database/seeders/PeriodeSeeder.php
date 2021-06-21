<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periodes = [
            [ 'kode_periode' => '20211', 'active' => 0, 'tapel' => '2020/2021', 'semester' => '1', 'deskripsi' => 'Periode 2020/2021 Semester Ganjil'],
            [ 'kode_periode' => '20212', 'active' => 1, 'tapel' => '2020/2021', 'semester' => '2', 'deskripsi' => 'Periode 2020/2021 Semester Genap'],
            [ 'kode_periode' => '21221', 'active' => 0, 'tapel' => '2021/2022', 'semester' => '1', 'deskripsi' => 'Periode 2021/2022 Semester Ganjil'],
            [ 'kode_periode' => '21222', 'active' => 0, 'tapel' => '2021/2022', 'semester' => '2', 'deskripsi' => 'Periode 2021/2022 Semester Genap'],
        ];

        foreach($periodes as $periode) {
            Periode::create([
                'kode_periode' => $periode['kode_periode'],
                'tapel' => $periode['tapel'],
                'semester' => $periode['semester'],
                'deskripsi' => $periode['deskripsi'],
                'active' => $periode['active'],
            ]);
        }
    }
}
