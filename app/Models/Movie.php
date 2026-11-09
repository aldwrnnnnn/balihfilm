<?php

namespace App\Models;

use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'synopsis',
        'genre',
        'duration',
        'rating',
        'director',
        'cast',
        'poster_url',
        'backdrop_url',
        'trailer_url',
        'status',
        'release_date',
        'base_price',
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'release_date' => 'date',
            'base_price' => 'decimal:2',
        ];
    }

    protected function posterUrl(): Attribute
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
                    return asset('images/movies/'.$clean);
                }

                return asset($clean);
            },
        );
    }

    protected function backdropUrl(): Attribute
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
                    return asset('images/movies/'.$clean);
                }

                return asset($clean);
            },
        );
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}
