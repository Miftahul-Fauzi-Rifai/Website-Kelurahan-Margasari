<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'lurah_name',
                'value' => 'HENDRA JAYA PRAWIRA, S.ST',
                'label' => 'Nama Lurah',
                'description' => 'Nama lengkap Lurah beserta gelar',
                'group' => 'general',
            ],
            [
                'key' => 'kelurahan_name',
                'value' => 'MARGA SARI',
                'label' => 'Nama Kelurahan',
                'description' => 'Nama kelurahan',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
