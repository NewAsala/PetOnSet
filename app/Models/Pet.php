<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'type',
        'age',
        'weight',
        'notes',
        'customer_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function groomingAppointments(): HasMany
    {
        return $this->hasMany(GroomingAppointment::class);
    }
}
