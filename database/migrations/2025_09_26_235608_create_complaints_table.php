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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('email_pelapor')->nullable();
            $table->string('telepon_pelapor');
            $table->string('alamat_pelapor');
            $table->string('judul_pengaduan');
            $table->text('deskripsi_pengaduan');
            $table->string('kategori');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->string('foto_pendukung')->nullable();
            $table->enum('status', ['baru', 'sedang_diproses', 'selesai', 'ditolak'])->default('baru');
            $table->text('tanggapan_admin')->nullable();
            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
            
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
