<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // ✅ Allow mass assignment of these fields
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'status'
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope to get only approved reviews
    public function scopeApproved($query) {
        return $query->where('status', 1);
    }
}
