<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $files = ['menus', 'menu_role'];

        for($i=0;$i<count($files);$i++) {
            $path = public_path('files/'.$files[$i]);
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }
    }
}
