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
        
        // Distribusi RT dalam 8 RW (4 RT per RW)
        $coordinates = [];
        $rtIndex = 1;
        
        // Generate koordinat yang tersebar secara realistis
        for ($rw = 1; $rw <= 8; $rw++) {
            for ($rt = 1; $rt <= 4; $rt++) {
                // Offset per RW dalam grid 2x4
                $rwRow = floor(($rw - 1) / 4);
                $rwCol = ($rw - 1) % 4;
                
                // Offset per RT dalam setiap RW
                $rtRow = floor(($rt - 1) / 2);
                $rtCol = ($rt - 1) % 2;
                
                // Hitung koordinat final dengan variasi random
                $lat = $baseLatitude + ($rwRow * 0.008) + ($rtRow * 0.004) + (rand(-20, 20) / 10000);
                $lng = $baseLongitude + ($rwCol * 0.012) + ($rtCol * 0.006) + (rand(-20, 20) / 10000);
                
                $coordinates[] = [
                    'rt' => $rtIndex,
                    'rw' => sprintf('%03d', $rw),
                    'lat' => round($lat, 6),
                    'lng' => round($lng, 6)
                ];
                
                $rtIndex++;
            }
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
                    'rw_code' => $coord['rw'],
                    'name' => 'RT ' . sprintf('%03d', $coord['rt']) . ' / RW ' . $coord['rw'],
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
