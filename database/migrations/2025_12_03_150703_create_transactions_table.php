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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('booking_code')->unique(); // Kode Booking (misal: TIX-12345)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('showtime_id')->constrained()->onDelete('cascade');
        
        $table->json('seats'); // Menyimpan array kursi, contoh: ["A1", "A2"]
        $table->integer('total_price');
        
        $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
