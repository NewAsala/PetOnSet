<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroomingAppointment extends Model
{
    protected $fillable = [
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'total_price',
        'notes',
        'user_id',
        'pet_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet() : BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function groomingAppointmentItems(): HasMany
    {
        return $this->hasMany(GroomingAppointmentItem::class);
    }
}
