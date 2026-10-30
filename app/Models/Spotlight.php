<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spotlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'banner',
        'is_active',
    ];
}