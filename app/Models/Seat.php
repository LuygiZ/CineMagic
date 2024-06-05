<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'theater_id',
        'row',
        'seat_number',
        'custom',
    ];

    public $timestamps = false;

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function hasValidTicket(): bool
    {
        return true;
        return $this->tickets()->where('status', true)->exists();
    }
}
