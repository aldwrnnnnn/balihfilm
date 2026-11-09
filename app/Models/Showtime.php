<?php

namespace App\Models;

use Database\Factories\ShowtimeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showtime extends Model
{
    /** @use HasFactory<ShowtimeFactory> */
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'studio_id',
        'show_date',
        'start_time',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'show_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get array of all booked seat identifiers for this showtime.
     *
     * @return array<int, string>
     */
    public function bookedSeats(): array
    {
        $seats = [];
        $bookings = $this->bookings()->where('payment_status', '!=', 'cancelled')->get();
        foreach ($bookings as $booking) {
            if (is_array($booking->seats)) {
                $seats = array_merge($seats, $booking->seats);
            }
        }

        return array_values(array_unique($seats));
    }
}
