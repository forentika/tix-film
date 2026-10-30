<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Cinemas (Bioskop)
        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Misal: CGV Grand Indonesia
            $table->string('city'); // Misal: Jakarta
            $table->text('address')->nullable();
            $table->string('cinema_image')->nullable(); // Foto gedung
            $table->timestamps();
        });

        // 2. Tabel Studios (Ruangan)
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id')->constrained('cinemas')->onDelete('cascade'); // Relasi ke Bioskop
            $table->string('name'); // Misal: Studio 1, Audi 5, Velvet
            $table->string('type'); // Regular, IMAX, Premiere, Gold Class
            $table->integer('total_seats'); // Kapasitas kursi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studios');
        Schema::dropIfExists('cinemas');
    }
};