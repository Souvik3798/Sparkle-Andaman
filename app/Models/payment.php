<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'custom_package',
        'hotel_type',
        'total_amount',
        'amount_paid',
        'payment_date',
        'bank',
        'reference'
    ];

    protected $casts = [
        'payment_date' => 'date'
    ];

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }
}
