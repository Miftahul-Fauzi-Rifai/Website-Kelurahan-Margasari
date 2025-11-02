<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rts', function (Blueprint $table) {
            // Profil Ketua RT
            $table->integer('ketua_rt_age')->nullable()->after('ketua_rt_phone');
            $table->string('ketua_rt_profession')->nullable()->after('ketua_rt_age');
            $table->integer('ketua_rt_tenure_years')->nullable()->after('ketua_rt_profession')->comment('Masa jabatan dalam tahun');
            
            // Data Sosial Ekonomi (JSON)
            $table->json('mata_pencaharian')->nullable()->comment('Pedagang, Karyawan, Buruh, Lainnya dalam %');
            $table->json('bantuan_sosial')->nullable()->comment('PKH, BLT, Lainnya dalam jumlah KK');
            
            // Kegiatan Sosial (JSON)
            $table->json('kegiatan_rutin')->nullable()->comment('Pengajian, Posyandu, Kerja Bakti per bulan');
            
            // Fasilitas Umum (JSON)
            $table->json('fasilitas_umum')->nullable()->comment('Masjid, Musholla, Posyandu, Bank Sampah, Pos Ronda');
            
            // Kondisi Infrastruktur (JSON)
            $table->json('kondisi_infrastruktur')->nullable()->comment('Jalan, Saluran air, Penerangan');
            
            // Masalah Lingkungan (JSON)
            $table->json('masalah_lingkungan')->nullable()->comment('Banjir, Sampah, dll');
            
            // Tingkat Pendidikan (JSON)
            $table->json('tingkat_pendidikan')->nullable()->comment('SD, SMP, SMA, Kuliah dalam %');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rts', function (Blueprint $table) {
            $table->dropColumn([
                'ketua_rt_age',
                'ketua_rt_profession',
                'ketua_rt_tenure_years',
                'mata_pencaharian',
                'bantuan_sosial',
                'kegiatan_rutin',
                'fasilitas_umum',
                'kondisi_infrastruktur',
                'masalah_lingkungan',
                'tingkat_pendidikan',
            ]);
        });
    }
};
