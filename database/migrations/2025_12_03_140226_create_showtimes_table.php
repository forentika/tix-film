<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            // Relasi ke Film
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            // Relasi ke Studio (Studio sudah punya Cinema_ID, jadi aman)
            $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
            
            $table->dateTime('start_time'); // Kapan film mulai
            $table->dateTime('end_time');   // Kapan film selesai (Hitung otomatis dari durasi)
            $table->integer('price');       // Harga tiket (bisa beda weekend/weekday)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};