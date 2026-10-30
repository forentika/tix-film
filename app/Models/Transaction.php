<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code', 
        'user_id', 
        'showtime_id', 
        'seats', 
        'total_price', 
        'status'
    ];

    // Agar kolom 'seats' otomatis dibaca sebagai Array (bukan string JSON)
    protected $casts = [
        'seats' => 'array',
    ];

    // --- RELASI YANG HILANG (TAMBAHKAN INI) ---

    // Relasi: Transaksi milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi milik satu Jadwal (Showtime)
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}