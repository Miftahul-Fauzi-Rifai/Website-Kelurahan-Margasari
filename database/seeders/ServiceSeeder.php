<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Surat Keterangan Domisili',
                'slug' => 'surat-keterangan-domisili',
                'description' => 'Penerbitan surat keterangan domisili untuk keperluan administrasi kependudukan',
                'requirements' => "1. KTP asli dan fotokopi\n2. KK asli dan fotokopi\n3. Surat pengantar RT/RW\n4. Pas foto 3x4 sebanyak 2 lembar",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Verifikasi data oleh petugas\n5. Surat selesai dan dapat diambil",
                'icon' => 'bi-house-door',
                'contact_person' => 'Ibu Siti Nurhaliza',
                'phone' => '(0542) 123-456',
                'processing_days' => 1,
                'fee' => 0,
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'slug' => 'surat-keterangan-tidak-mampu',
                'description' => 'Penerbitan surat keterangan tidak mampu untuk berbagai keperluan bantuan sosial',
                'requirements' => "1. KTP asli dan fotokopi\n2. KK asli dan fotokopi\n3. Surat pengantar RT/RW\n4. Surat keterangan penghasilan\n5. Pas foto 3x4 sebanyak 2 lembar",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Survey lapangan oleh petugas\n5. Verifikasi dan penandatanganan\n6. Surat selesai",
                'icon' => 'bi-heart-hand',
                'contact_person' => 'Bapak Bambang Sutrisno',
                'phone' => '(0542) 123-457',
                'processing_days' => 3,
                'fee' => 0,
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Surat Izin Usaha Mikro Kecil (IUMK)',
                'slug' => 'surat-izin-usaha-mikro-kecil',
                'description' => 'Penerbitan izin usaha untuk usaha mikro dan kecil di wilayah kelurahan',
                'requirements' => "1. KTP asli dan fotokopi\n2. KK asli dan fotokopi\n3. Surat pengantar RT/RW\n4. Denah lokasi usaha\n5. Pas foto 3x4 sebanyak 2 lembar\n6. Surat pernyataan tidak keberatan dari tetangga",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Survey lokasi usaha\n5. Verifikasi berkas\n6. Penerbitan izin",
                'icon' => 'bi-shop',
                'contact_person' => 'Bapak Rudi Hartono',
                'phone' => '(0542) 123-458',
                'processing_days' => 7,
                'fee' => 50000,
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'slug' => 'surat-keterangan-kelahiran',
                'description' => 'Penerbitan surat keterangan kelahiran untuk keperluan pembuatan akta kelahiran',
                'requirements' => "1. Surat keterangan lahir dari bidan/dokter\n2. KTP kedua orang tua (asli dan fotokopi)\n3. KK asli dan fotokopi\n4. Buku nikah/akta nikah orang tua (asli dan fotokopi)\n5. Surat pengantar RT/RW",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Verifikasi data oleh petugas\n5. Surat selesai dan dapat diambil",
                'icon' => 'bi-person-plus',
                'contact_person' => 'Ibu Siti Nurhaliza',
                'phone' => '(0542) 123-456',
                'processing_days' => 1,
                'fee' => 0,
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'slug' => 'surat-keterangan-kematian',
                'description' => 'Penerbitan surat keterangan kematian untuk keperluan administrasi',
                'requirements' => "1. Surat keterangan kematian dari dokter/rumah sakit\n2. KTP almarhum/almarhumah\n3. KK asli dan fotokopi\n4. KTP pelapor (asli dan fotokopi)\n5. Surat pengantar RT/RW",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Verifikasi data oleh petugas\n5. Surat selesai dan dapat diambil",
                'icon' => 'bi-file-text',
                'contact_person' => 'Ibu Siti Nurhaliza',
                'phone' => '(0542) 123-456',
                'processing_days' => 1,
                'fee' => 0,
                'is_active' => true,
                'order' => 5
            ],
            [
                'name' => 'Surat Pengantar Nikah',
                'slug' => 'surat-pengantar-nikah',
                'description' => 'Penerbitan surat pengantar nikah untuk keperluan pernikahan di KUA',
                'requirements' => "1. KTP calon pengantin (asli dan fotokopi)\n2. KK asli dan fotokopi\n3. Akta kelahiran (asli dan fotokopi)\n4. Surat pengantar RT/RW\n5. Pas foto 3x4 masing-masing 2 lembar\n6. Surat keterangan belum menikah dari kelurahan asal (jika berbeda)",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Verifikasi data oleh petugas\n5. Surat selesai dan dapat diambil",
                'icon' => 'bi-heart',
                'contact_person' => 'Bapak Bambang Sutrisno',
                'phone' => '(0542) 123-457',
                'processing_days' => 2,
                'fee' => 0,
                'is_active' => true,
                'order' => 6
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'slug' => 'surat-keterangan-usaha',
                'description' => 'Penerbitan surat keterangan usaha untuk keperluan administrasi bisnis',
                'requirements' => "1. KTP asli dan fotokopi\n2. KK asli dan fotokopi\n3. Surat pengantar RT/RW\n4. Pas foto 3x4 sebanyak 2 lembar\n5. Denah lokasi usaha\n6. Foto tempat usaha",
                'process' => "1. Datang ke kantor kelurahan\n2. Mengisi formulir permohonan\n3. Menyerahkan berkas persyaratan\n4. Survey lokasi usaha\n5. Verifikasi dan penandatanganan\n6. Surat selesai",
                'icon' => 'bi-briefcase',
                'contact_person' => 'Bapak Rudi Hartono',
                'phone' => '(0542) 123-458',
                'processing_days' => 3,
                'fee' => 25000,
                'is_active' => true,
                'order' => 7
            ],
            [
                'name' => 'Legalisir Dokumen',
                'slug' => 'legalisir-dokumen',
                'description' => 'Layanan legalisir berbagai dokumen untuk keperluan administrasi',
                'requirements' => "1. Dokumen asli yang akan dilegalisir\n2. Fotokopi dokumen\n3. KTP pemohon (asli dan fotokopi)\n4. Surat pengantar RT/RW (jika diperlukan)",
                'process' => "1. Datang ke kantor kelurahan\n2. Menyerahkan dokumen asli dan fotokopi\n3. Petugas melakukan verifikasi\n4. Pemberian stempel dan tanda tangan\n5. Dokumen selesai dilegalisir",
                'icon' => 'bi-patch-check',
                'contact_person' => 'Ibu Siti Nurhaliza',
                'phone' => '(0542) 123-456',
                'processing_days' => 0,
                'fee' => 5000,
                'is_active' => true,
                'order' => 8
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
