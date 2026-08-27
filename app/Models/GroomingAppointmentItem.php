<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroomingAppointmentItem extends Model
{
    protected $fillable = [
        'duration',
        'price',
        'grooming_appointment_id',
        'grooming_service_id',
    ];

    public function groomingService() : BelongsTo
    {
        return $this->belongsTo(GroomingService::class);
    }

    public function groomingAppointment() : BelongsTo
    {
        return $this->belongsTo(GroomingAppointment::class);
    }
}
