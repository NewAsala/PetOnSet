<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'type',
        'quantity',
        'reference_id',
        'reference_type',
        'notes',
        'product_id',
        'product_batch_id',
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productBatch() : BelongsTo
    {
        return $this->belongsTo(ProductBatch::class);
    }

}
