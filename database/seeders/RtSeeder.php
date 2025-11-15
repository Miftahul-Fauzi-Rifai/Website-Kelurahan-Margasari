<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rt;

class RtSeeder extends Seeder
{
    /**
     * Koordinat batas wilayah Kelurahan Margasari
     */
    private function getKelurahanBoundary(): array
    {
        return [
            [116.82265233098497, -1.240431056886834],
            [116.82234187253704, -1.2401206711876824],
            [116.82226425792862, -1.2403057088092595],
            [116.82199294163911, -1.2401064795903665],
            [116.8217272608806, -1.2397513266998175],
            [116.82139292105006, -1.2393722979325759],
            [116.82101380356221, -1.2390738500450311],
            [116.8204248624819, -1.238865153390222],
            [116.81973368880739, -1.2386936613280994],
            [116.81924431766424, -1.2386331347151298],
            [116.81847242297795, -1.2385625203312571],
            [116.81754176089697, -1.2386297752996427],
            [116.817150001985, -1.238697856149571],
            [116.81755828130315, -1.2375828021183395],
            [116.81812783057933, -1.2360086414736031],
            [116.81854744260562, -1.2348736419046702],
            [116.81868723328097, -1.23438345968097],
            [116.82007677918779, -1.2344524690934975],
            [116.82237970373365, -1.2345989046826844],
            [116.823837031734, -1.2347151453596297],
            [116.8247482746599, -1.2348486616248522],
            [116.82548395473657, -1.2354428935335733],
            [116.8263220016513, -1.2363472666382904],
            [116.82736759527216, -1.2374563389483768],
            [116.82793276982841, -1.2380985942335343],
            [116.8281246376045, -1.2406043551182648],
            [116.82616147688486, -1.240604877985632],
            [116.82432717778568, -1.2404954592413162],
            [116.82353964394099, -1.2404144561198507],
            [116.8226622784897, -1.2404383692451546],
        ];
    }

    /**
     * Cek apakah titik berada di dalam polygon menggunakan Ray Casting Algorithm
     */
    private function isPointInPolygon(float $lng, float $lat, array $polygon): bool
    {
        $inside = false;
        $count = count($polygon);
        
        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];
            
            $intersect = (($yi > $lat) != ($yj > $lat))
                && ($lng < ($xj - $xi) * ($lat - $yi) / ($yj - $yi) + $xi);
            
            if ($intersect) {
                $inside = !$inside;
            }
        }
        
        return $inside;
    }

    /**
     * Generate koordinat random dalam batas wilayah kelurahan
     */
    private function generateRandomCoordinate(array $boundary): array
    {
        // Cari batas min/max dari polygon
        $lngs = array_column($boundary, 0);
        $lats = array_column($boundary, 1);
        
        $minLng = min($lngs);
        $maxLng = max($lngs);
        $minLat = min($lats);
        $maxLat = max($lats);
        
        // Generate koordinat random sampai menemukan yang berada di dalam polygon
        $maxAttempts = 1000;
        $attempt = 0;
        
        do {
            $lng = $minLng + (mt_rand() / mt_getrandmax()) * ($maxLng - $minLng);
            $lat = $minLat + (mt_rand() / mt_getrandmax()) * ($maxLat - $minLat);
            $attempt++;
        } while (!$this->isPointInPolygon($lng, $lat, $boundary) && $attempt < $maxAttempts);
        
        return [
            'lat' => round($lat, 6),
            'lng' => round($lng, 6)
        ];
    }

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

        // Dapatkan batas wilayah kelurahan
        $boundary = $this->getKelurahanBoundary();
        
        // Generate koordinat RT yang tersebar secara random dalam wilayah kelurahan
        $coordinates = [];
        $totalRT = 32; // Total RT di Kelurahan Margasari
        
        echo "Generating koordinat random untuk {$totalRT} RT dalam batas wilayah Kelurahan Margasari...\n";
        
        for ($rtIndex = 1; $rtIndex <= $totalRT; $rtIndex++) {
            $coord = $this->generateRandomCoordinate($boundary);
            $coordinates[] = [
                'rt' => $rtIndex,
                'lat' => $coord['lat'],
                'lng' => $coord['lng']
            ];
            echo "RT " . sprintf('%02d', $rtIndex) . ": {$coord['lat']}, {$coord['lng']}\n";
        }

        echo "\nMenyimpan data RT ke database...\n";

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
                ['rt_code' => sprintf('%02d', $coord['rt'])],
                [
                    'name' => 'RT ' . sprintf('%02d', $coord['rt']),
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
        
        echo "\nSelesai! {$totalRT} RT berhasil di-generate dengan koordinat random dalam batas wilayah Kelurahan Margasari.\n";
    }
}
