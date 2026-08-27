<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroomingService extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'status',
    ];

    public function groomingAppointmentItems(): HasMany
    {
        return $this->hasMany(GroomingAppointmentItem::class);
    }
}
