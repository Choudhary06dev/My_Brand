<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'reason',
        'description',
        'images',
        'status',
        'admin_remark',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($returnRequest) {
            if ($returnRequest->status === 'refunded') {
                $returnRequest->order->update([
                    'status' => 'refunded',
                    'payment_status' => 'refunded'
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
