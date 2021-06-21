<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Angkatan;

class AngkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = 15;
        $end = $start+1;
        $datas = [];
        $id = 1;
        for($i=0; $i < 20; $i++) 
        {
        	Angkatan::create([
        		'id' => $i+1,
        		'kode' => $start+$i.($end+$i),
        		'label' => '20'.($start+$i).'/'.'20'.($end+$i),
        		'ket' => 'Angkatan '.'20'.($start+$i).'/'.'20'.($end+$i),
        	]);
        }
    }
}
