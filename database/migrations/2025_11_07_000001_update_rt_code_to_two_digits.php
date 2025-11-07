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
        // Update existing RT codes from 3 digits (001, 002) to 2 digits (01, 02)
        DB::statement("UPDATE rts SET rt_code = LPAD(CAST(rt_code AS UNSIGNED), 2, '0')");
        
        // Update existing RT names if they use the old format
        DB::statement("UPDATE rts SET name = CONCAT('RT ', rt_code) WHERE name LIKE 'RT 0%'");
        
        // Update rt_code column length from 3 to 2 and drop rw_code
        Schema::table('rts', function (Blueprint $table) {
            $table->string('rt_code', 2)->change();
            
            // Drop rw_code column if exists
            if (Schema::hasColumn('rts', 'rw_code')) {
                $table->dropColumn('rw_code');
            }
        });
        
        // Update users table if there are any RT codes stored
        if (Schema::hasColumn('users', 'rt')) {
            DB::statement("UPDATE users SET rt = LPAD(CAST(rt AS UNSIGNED), 2, '0') WHERE rt IS NOT NULL AND rt != ''");
        }
        
        // Update reports table RT codes
        if (Schema::hasTable('reports')) {
            DB::statement("UPDATE reports SET rt_code = LPAD(CAST(rt_code AS UNSIGNED), 2, '0')");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert RT codes from 2 digits back to 3 digits
        DB::statement("UPDATE rts SET rt_code = LPAD(CAST(rt_code AS UNSIGNED), 3, '0')");
        
        // Revert RT names
        DB::statement("UPDATE rts SET name = CONCAT('RT ', rt_code) WHERE name LIKE 'RT 0%'");
        
        // Revert column length and restore rw_code
        Schema::table('rts', function (Blueprint $table) {
            $table->string('rt_code', 3)->change();
            
            // Restore rw_code column
            if (!Schema::hasColumn('rts', 'rw_code')) {
                $table->string('rw_code', 3)->default('001');
            }
        });
        
        // Revert users table
        if (Schema::hasColumn('users', 'rt')) {
            DB::statement("UPDATE users SET rt = LPAD(CAST(rt AS UNSIGNED), 3, '0') WHERE rt IS NOT NULL AND rt != ''");
        }
        
        // Revert reports table
        if (Schema::hasTable('reports')) {
            DB::statement("UPDATE reports SET rt_code = LPAD(CAST(rt_code AS UNSIGNED), 3, '0')");
        }
    }
};

