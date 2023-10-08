<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IternityTemplate extends Model
{
    use HasFactory;

    protected $table = 'mst_template';

    protected $fillable = [
                'Title',
                'Description',
                'Specialties',
                'locationCovered'
    ];

    protected $casts = [
        'Specialties'=>'array',
        'locationCovered'=>'array'
    ];

}
