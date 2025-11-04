<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, number, etc
            $table->string('group')->default('general'); // general, document, etc
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'lurah_name',
                'value' => 'HENDRA JAYA PRAWIRA, S.ST',
                'type' => 'text',
                'group' => 'document',
                'label' => 'Nama Lurah',
                'description' => 'Nama Lurah Kelurahan Marga Sari yang akan muncul di dokumen/laporan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'kelurahan_name',
                'value' => 'KELURAHAN MARGA SARI',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Kelurahan',
                'description' => 'Nama lengkap kelurahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'kelurahan_address',
                'value' => 'Balikpapan',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Alamat Kelurahan',
                'description' => 'Alamat lengkap kelurahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
