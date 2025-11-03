<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tentang', function (Blueprint $table) {
            if (!Schema::hasColumn('tentang', 'logo')) {
                $table->string('logo')->nullable()->after('gambar');
            }

            if (Schema::hasColumn('tentang', 'gambar')) {
                $table->renameColumn('gambar', 'gambar_kantor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tentang', function (Blueprint $table) {
            if (Schema::hasColumn('tentang', 'logo')) {
                $table->dropColumn('logo');
            }

            if (Schema::hasColumn('tentang', 'gambar_kantor')) {
                $table->renameColumn('gambar_kantor', 'gambar');
            }
        });
    }
};
