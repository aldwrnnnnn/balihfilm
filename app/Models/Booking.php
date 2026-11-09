<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'showtime_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'seats',
        'seat_count',
        'ticket_price',
        'ticket_subtotal',
        'snack_subtotal',
        'total_amount',
        'payment_method',
        'payment_status',
        'barcode',
    ];

    protected function casts(): array
    {
        return [
            'seats' => 'array',
            'seat_count' => 'integer',
            'ticket_price' => 'decimal:2',
            'ticket_subtotal' => 'decimal:2',
            'snack_subtotal' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
}
