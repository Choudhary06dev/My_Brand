<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'session_id',
        'order_number',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'order_notes',
        'payment_proof',
        'delivered_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    /**
     * Check if the order is eligible for return (e.g. within 7 days of delivery)
     */
    public function isReturnable()
    {
        if ($this->status !== 'completed' || !$this->delivered_at) {
            return false;
        }

        // Check if already returned or request pending
        if ($this->returnRequests()->whereNotIn('status', ['rejected'])->exists()) {
            return false;
        }

        return $this->delivered_at->addDays(7)->isFuture();
    }
}
