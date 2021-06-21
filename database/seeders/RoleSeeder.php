<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'kode_role' => 'admin', 'label' => 'Admin'],
            ['id' => 2, 'kode_role' => 'wali', 'label' => 'Wali Kelas'],
            ['id' => 3, 'kode_role' => 'gpai', 'label' => 'Guru Agama'],
            ['id' => 4, 'kode_role' => 'gor', 'label' => 'Guru Olahraga'],
            ['id' => 5, 'kode_role' => 'gben', 'label' => 'Guru Bahasa Inggris'],
            ['id' => 6, 'kode_role' => 'ks', 'label' => 'Kepala Sekolah'],
        ];

        foreach($roles as $role) 
        {
            Role::create([
                'id' => $role['id'],
                'kode_role' => $role['kode_role'],
                'label' => $role['label']
            ]);
        }
    }
}
