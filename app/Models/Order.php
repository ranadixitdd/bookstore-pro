<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'shipping_address',   // ← add this
        'payment_status',     // ← if you need it
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Moved isCancellable() method here:
    public function isCancellable()
    {
        // Allow cancellation only if the order is pending and was created less than 1 hours ago.
        return $this->created_at->diffInHours(now()) < 1 && $this->status === 'pending';
    }
}
