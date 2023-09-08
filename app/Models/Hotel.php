<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotel';

    public function hotelcategory(): BelongsTo{
        return $this->belongsTo(HotelCategory::class);
    }

    public function hotelimages(): HasOne{
        return $this->hasOne(HotelImages::class,'hotelID','id');
    }
}
