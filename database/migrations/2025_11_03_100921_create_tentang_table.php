<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentang', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable(); // biar bisa kosong tanpa error
            $table->text('deskripsi')->nullable();
            $table->string('gambar_kantor')->nullable(); // beda dari 'gambar' biar lebih deskriptif
            $table->string('logo')->nullable(); // untuk simpan logo kelurahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tentang');
    }
};
