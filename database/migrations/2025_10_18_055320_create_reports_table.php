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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ketua RT yang membuat laporan
            $table->string('rt_code'); // Kode RT (misal: 001, 002)
            $table->string('month'); // Bulan laporan (format: 2025-01)
            $table->string('title'); // Judul laporan
            $table->text('description'); // Deskripsi/isi laporan
            $table->text('activities')->nullable(); // Kegiatan yang dilakukan
            $table->integer('total_residents')->nullable(); // Total warga
            $table->integer('total_households')->nullable(); // Total KK
            $table->text('issues')->nullable(); // Permasalahan yang ada
            $table->text('suggestions')->nullable(); // Saran/usulan
            $table->string('attachment')->nullable(); // File lampiran (PDF/image)
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index(['rt_code', 'month']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
