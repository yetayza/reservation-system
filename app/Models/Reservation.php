<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in',
        'check_out',
        'price',
        'status',
        'booking_code',
        'source',
        'channel',
        'ota_booking_id',
        'created_by',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    protected static function booted(): void
    {
        static::creating(function ($reservation) {
            do {
                $code = (string) random_int(100000, 999999);
            } while (self::where('booking_code', $code)->exists());

            $reservation->booking_code = $code;
        });
}
}