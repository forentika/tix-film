<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = ['cinema_id', 'name', 'type', 'total_seats'];

    // Relasi: Studio milik 1 Bioskop
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}