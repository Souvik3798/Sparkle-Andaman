<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IternityTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'specialities',
        'locations'
    ];

    protected $casts = [
        'specialities' => 'array',
        'locations' => 'array'
    ];
}
