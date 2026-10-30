<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'city', 'address', 'cinema_image'];

    // Relasi: 1 Bioskop punya banyak Studio
    public function studios()
    {
        return $this->hasMany(Studio::class);
    }
}