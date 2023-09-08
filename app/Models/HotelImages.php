<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelImages extends Model
{
    use HasFactory;

    protected $table = 'hotel_images';

    public function hotel():BelongsTo{
        return $this->belongsTo(Hotel::class,'id','hotelID');
    }
}
