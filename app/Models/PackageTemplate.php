<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'days',
        'nights',
        'name',
        'description',
        'image',
        'inclusions',
        'exclusions',
    ];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
