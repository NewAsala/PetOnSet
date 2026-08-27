<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reversion extends Model
{
    protected $fillable = [
        'return_number',
        'return_date',
        'reason',
        'total',
        'status',
        'sale_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function reversionItems(): HasMany
    {
        return $this->hasMany(ReversionItem::class);
    }
}
