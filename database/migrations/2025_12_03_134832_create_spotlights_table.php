<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spotlights', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Promo
            $table->text('description')->nullable(); // Ket. singkat
            $table->string('banner'); // File Gambar (Landscape)
            $table->boolean('is_active')->default(true); // Status Aktif/Tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spotlights');
    }
};