<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Pastikan semua kolom ini ada
    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration_minutes',
        'director',
        'age_rating',
        'poster',
        'trailer_url',
        'status',
    ];
}