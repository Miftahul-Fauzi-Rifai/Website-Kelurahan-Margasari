<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rt;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data nama ketua RT yang realistis
        $ketuaNames = [
            'H. Ahmad Suryadi', 'Budi Santoso', 'Siti Nurhaliza', 'Eko Prasetyo', 
            'Dewi Sartika', 'Rudi Hartono', 'Sri Wahyuni', 'Agus Salim',
            'Rina Marlina', 'Hendi Kusuma', 'Lisa Permata', 'Joko Widodo',
            'Indah Sari', 'Bambang Surya', 'Ratna Dewi', 'Faisal Rahman',
            'Sari Melati', 'Wawan Setiawan', 'Maya Indira', 'Doni Irawan',
            'Nurul Fadilah', 'Tono Supriatna', 'Rini Astuti', 'Adi Nugroho',
            'Lina Marlina', 'Yudi Pranata', 'Diah Permatasari', 'Rizki Pratama',
            'Sinta Dewi', 'Benny Kurniawan', 'Fitri Handayani', 'M. Ridwan'
        ];

        // Area koordinat Kelurahan Margasari, Balikpapan Barat
        // Pusat: -1.2379, 116.8289
        $baseLatitude = -1.2379;
        $baseLongitude = 116.8289;
        
        // Generate koordinat RT yang tersebar secara realistis
        $coordinates = [];
        $totalRT = 32; // Total RT di Kelurahan Margasari
        
        // Generate koordinat yang tersebar dalam grid
        for ($rtIndex = 1; $rtIndex <= $totalRT; $rtIndex++) {
            $row = floor(($rtIndex - 1) / 8);
            $col = ($rtIndex - 1) % 8;
            
            // Hitung koordinat final dengan variasi random
            $lat = $baseLatitude + ($row * 0.006) + (rand(-20, 20) / 10000);
            $lng = $baseLongitude + ($col * 0.008) + (rand(-20, 20) / 10000);
            
            $coordinates[] = [
                'rt' => $rtIndex,
                'lat' => round($lat, 6),
                'lng' => round($lng, 6)
            ];
        }

        foreach ($coordinates as $index => $coord) {
            // Data populasi yang bervariasi
            $households = rand(35, 85);
            $population = $households * rand(3, 5);
            $maleRatio = rand(48, 52) / 100;
            $male = round($population * $maleRatio);
            $female = $population - $male;
            
            // Nomor telepon yang bervariasi
            $phoneNumber = '0812-' . rand(1000, 9999) . '-' . rand(1000, 9999);
            
            Rt::updateOrCreate(
                ['rt_code' => sprintf('%03d', $coord['rt'])],
                [
                    'name' => 'RT ' . sprintf('%03d', $coord['rt']),
                    'ketua_rt_name' => $ketuaNames[$index],
                    'ketua_rt_phone' => $phoneNumber,
                    'num_households' => $households,
                    'num_population' => $population,
                    'num_male' => $male,
                    'num_female' => $female,
                    'latitude' => $coord['lat'],
                    'longitude' => $coord['lng'],
                ]
            );
        }
    }
}
