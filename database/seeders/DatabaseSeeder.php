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
        $files = ['menus.sql', 'menu_role.sql'];

        for($i=0;$i<count($files);$i++) {
            $path = public_path('files/'.$files[$i]);
            $sql = file_get_contents($path);
            // DB::unprepared($sql);
            $db = [
               'username' => env('DB_USERNAME'),
               'password' => env('DB_PASSWORD'),
               'host' => env('DB_HOST'),
               'database' => env('DB_DATABASE')
           ];
           exec("{$db_bin}\mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql");
        }
    }
}
