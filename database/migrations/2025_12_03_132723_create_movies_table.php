<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description'); // Sinopsis
            $table->string('genre'); // Drama, Action, dll
            $table->integer('duration_minutes'); // Simpan dalam menit (misal 116), nanti dikonversi ke Jam Menit di view
            $table->string('director');
            $table->string('age_rating'); // P13+, D17+, SU
            $table->string('poster')->nullable(); // Path gambar
            $table->string('trailer_url')->nullable(); // Link YouTube
            $table->enum('status', ['now_showing', 'coming_soon', 'presale'])->default('now_showing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};