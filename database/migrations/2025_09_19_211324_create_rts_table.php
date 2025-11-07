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
        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            $table->string('rt_code', 2)->unique(); // e.g. 01..32
            $table->string('name')->nullable(); // optional display name
            $table->string('ketua_rt_name')->nullable();
            $table->string('ketua_rt_phone')->nullable();
            $table->integer('num_households')->default(0);
            $table->integer('num_population')->default(0);
            $table->integer('num_male')->default(0);
            $table->integer('num_female')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->json('boundaries')->nullable(); // GeoJSON polygon/linestring for map
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rts');
    }
};
