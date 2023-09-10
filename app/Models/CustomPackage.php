<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'cid',
        'category_id',
        'days',
        'nights',
        'name',
        'description',
        'cost',
        'image',
        'inclusions',
        'exclusions',
        'iternity',
        'rooms',
        'cruz',
        'vehicle',
        'addons',
        'voucher',
        'margin'
    ];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array',
        'iternity' => 'array',
        'rooms' => 'array',
        'cruz' => 'array',
        'vehicle' => 'array',
        'addons' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function customers() : BelongsTo {
        return $this->belongsTo(Customers::class);
    }

}
