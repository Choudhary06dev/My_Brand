<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'purchase_price',
        'size',
        'color',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get effective purchase price (from order item or fallback to product)
     */
    protected function getEffectivePurchasePrice()
    {
        if ($this->purchase_price !== null && $this->purchase_price > 0) {
            return (float) $this->purchase_price;
        }
        return (float) ($this->product?->purchase_price ?? 0);
    }

    /**
     * Calculate profit for this order item
     */
    public function getProfitAttribute()
    {
        $cost = $this->getEffectivePurchasePrice();
        return max(0, ($this->price - $cost) * $this->quantity);
    }

    /**
     * Calculate total sale amount for this item
     */
    public function getTotalSaleAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Calculate total purchase cost for this item
     */
    public function getTotalPurchaseCostAttribute()
    {
        return $this->getEffectivePurchasePrice() * $this->quantity;
    }
}
