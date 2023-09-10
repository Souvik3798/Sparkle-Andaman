<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'cid',
        'number',
        'adults',
        'childgreaterthan5',
        'childlessthan5',
        'dateofarrival',
        'dateofdeparture'
    ];

    protected $casts = [
        'dateofarrival' => 'date',
        'dateofdeparture' => 'date'
    ];

    public function custompackage(): HasMany{
        return $this->hasMany(CustomPackage::class);
    }

    public function payment():HasMany{
        return $this->hasMany(payment::class);
    }
}
