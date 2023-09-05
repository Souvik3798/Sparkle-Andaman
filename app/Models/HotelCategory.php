<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelCategory extends Model
{
    use HasFactory;

    protected $table = 'hotel_category';

    protected $fillable = [
        'id',
        'category'
    ];

    public function hotel(): HasMany{
        return $this->hasMany(Hotel::class,'Category_id','id');
    }
}
