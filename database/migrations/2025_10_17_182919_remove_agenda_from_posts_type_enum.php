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
        // First, update any existing posts with type 'agenda' to 'berita'
        DB::table('posts')->where('type', 'agenda')->update(['type' => 'berita']);
        
        // Then modify the column to remove 'agenda' from enum
        DB::statement("ALTER TABLE posts MODIFY COLUMN type ENUM('berita', 'pengumuman') NOT NULL DEFAULT 'berita'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original enum with 'agenda'
        DB::statement("ALTER TABLE posts MODIFY COLUMN type ENUM('berita', 'pengumuman', 'agenda') NOT NULL DEFAULT 'berita'");
    }
};
