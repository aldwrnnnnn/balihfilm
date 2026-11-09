<?php

namespace App\Models;

use Database\Factories\StudioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    /** @use HasFactory<StudioFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'total_rows',
        'total_cols',
        'row_labels',
        'extra_fee',
    ];

    protected function casts(): array
    {
        return [
            'total_rows' => 'integer',
            'total_cols' => 'integer',
            'extra_fee' => 'decimal:2',
        ];
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}
