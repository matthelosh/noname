<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
        	['kode_kelas' => '1', 'label' => 'Satu', 'tingkat' => 1 ],
        	['kode_kelas' => '2', 'label' => 'Dua', 'tingkat' => 2 ],
        	['kode_kelas' => '3', 'label' => 'Tiga', 'tingkat' => 3 ],
        	['kode_kelas' => '4', 'label' => 'Empat', 'tingkat' => 4 ],
        	['kode_kelas' => '5', 'label' => 'Lima', 'tingkat' => 5 ],
        	['kode_kelas' => '6', 'label' => 'Enam', 'tingkat' => 6 ],
        ];
        foreach ($kelas as $k) {
        	Kelas::create([
        		'kode_kelas' =>$k['kode_kelas'],
        		'label' => $k['label'],
        		'tingkat' => $k['tingkat']
        	]);	
        }
    }
}
