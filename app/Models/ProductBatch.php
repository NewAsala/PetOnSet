<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductBatch extends Model
{
    protected $fillable = [
        'batch_number',
        'expiry_date',
        'quantity',
        'purchase_price',
        'status',
        'purchase_item_id',
        'product_id',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function purchaseItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function saleItemBatches(): HasMany
    {
        return $this->hasMany(SaleItemBatch::class);
    }

    public function reversionItems(): HasMany
    {
        return $this->hasMany(ReversionItem::class);
    }
    
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
