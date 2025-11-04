<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'lurah_name',
                'value' => 'HENDRA JAYA PRAWIRA, S.ST',
                'label' => 'Nama Lurah',
                'description' => 'Nama Lurah yang ditampilkan pada laporan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'kelurahan_name',
                'value' => 'KELURAHAN MARGA SARI',
                'label' => 'Nama Kelurahan',
                'description' => 'Nama Kelurahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
