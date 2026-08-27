<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReversionItem extends Model
{
    protected $fillable = [
        'quantity',
        'price',
        'total',
        'reason',
        'condition',
        'reversion_id',
        'product_id',
        'sale_item_id',
        'product_batch_id',
    ];

    public function saleItem() : BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

    public function productBatch() : BelongsTo
    {
        return $this->belongsTo(ProductBatch::class);
    }

    public function reversion() : BelongsTo
    {
        return $this->belongsTo(Reversion::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
