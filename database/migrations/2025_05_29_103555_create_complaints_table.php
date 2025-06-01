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
            $table->string('hamlet'); // Simpan nama dusun langsung
            $table->string('rw');     // Simpan nama RW
            $table->string('rt');     // Simpan nama RT
            $table->string('infrastructure_category');

            $table->string('complaints_code')->unique();
            $table->string('name');         // Nama pelapor
            $table->string('phone');
            $table->string('email')->nullable(); // Email boleh kosong
            $table->text('description');
            $table->string('photo'); // Foto bisa kosong, opsional
            $table->decimal('longitude', 11, 8);
            $table->decimal('latitude', 10, 8);
            $table->dateTime('date_time');

            $table->text('response')->nullable(); // Tanggapan admin, opsional
            $table->enum('request_status', ['pending','approved', 'rejected'])->default('pending');
            $table->enum('status_complaint', ['pending','cancel', 'process', 'done'])->default('pending');
            $table->timestamps();
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
