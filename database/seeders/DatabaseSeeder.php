<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ServiceSeeder::class,
            RtSeeder::class,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Admin Kelurahan',
            'email' => 'admin@margasari.id',
            'role_id' => 3, // admin role
            'is_active' => true
        ]);

        // Create ketua RT user
        User::factory()->create([
            'name' => 'Ketua RT 01',
            'email' => 'ketuart01@margasari.id',
            'role_id' => 2, // ketua_rt role
            'rt' => '01',
            'rw' => '01',
            'is_active' => true
        ]);

        // Seed sample posts
        $this->call([
            PostSeeder::class,
        ]);
    }
}
