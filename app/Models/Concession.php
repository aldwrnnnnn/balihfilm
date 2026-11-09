<?php

namespace App\Models;

use Database\Factories\ConcessionFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Concession extends Model
{
    /** @use HasFactory<ConcessionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'image_url',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {
                if (blank($value)) {
                    return null;
                }

                if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                    return $value;
                }

                $clean = ltrim($value, '/');
                if (! str_contains($clean, '/')) {
                    return asset('images/concessions/'.$clean);
                }

                return asset($clean);
            },
        );
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
}
