<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'masyarakat',
                'display_name' => 'Masyarakat',
                'description' => 'Warga masyarakat biasa'
            ],
            [
                'name' => 'ketua_rt',
                'display_name' => 'Ketua RT',
                'description' => 'Ketua Rukun Tetangga'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin Kelurahan',
                'description' => 'Administrator kelurahan'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
