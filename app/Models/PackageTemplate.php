<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'inclusions',
        'exclusions'
    ];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array'
    ];

}
