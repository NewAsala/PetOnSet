<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\PetTypeEnum;
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

    protected function casts(): array
    {
        return [
            'type' => PetTypeEnum::class,
            'gender' => GenderEnum::class,
        ];
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function groomingAppointments(): HasMany
    {
        return $this->hasMany(GroomingAppointment::class);
    }
}
