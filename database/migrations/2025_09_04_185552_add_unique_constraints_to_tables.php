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
        // NIK harus unik
        Schema::table('nik', function (Blueprint $table) {
            $table->unique('value');
        });

        // Nama dusun (hamlet) harus unik
        Schema::table('hamlets', function (Blueprint $table) {
            $table->unique('name');
        });

        // Nama kategori infrastruktur harus unik
        Schema::table('infrastructure_categories', function (Blueprint $table) {
            $table->unique('name');
        });

        // RW: unik berdasarkan hamlet + nama RW
        Schema::table('rws', function (Blueprint $table) {
            $table->unique(['hamlet_id', 'name']);
        });

        // RT: unik berdasarkan RW + nama RT
        Schema::table('rts', function (Blueprint $table) {
            $table->unique(['rw_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nik', function (Blueprint $table) {
            $table->dropUnique(['value']);
        });

        Schema::table('hamlets', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('infrastructure_categories', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('rws', function (Blueprint $table) {
            $table->dropUnique(['hamlet_id', 'name']);
        });

        Schema::table('rts', function (Blueprint $table) {
            $table->dropUnique(['rw_id', 'name']);
        });
    }
};
