<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $files = ['menus.sql', 'menu_role.sql'];
         $db_bin = '/usr/bin/mysql';
            $db = [
               'username' => env('DB_USERNAME'),
               'password' => env('DB_PASSWORD'),
               'host' => env('DB_HOST'),
               'database' => env('DB_DATABASE')
           ];
        for($i=0;$i<count($files);$i++) {
            $path = public_path('files/'.$files[$i]);
            // $sql = file_get_contents($path);
            // DB::unprepared($sql);
            
           exec("{$db_bin} --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $path");
        }
    }
}
