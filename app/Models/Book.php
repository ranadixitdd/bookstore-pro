<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Category; // <--- Make sure to import this if not already
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'author', 'price', 'stock'];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')
                    ->where(function ($query) {
                        $query->where('status', 1)
                              ->orWhere('status', 'approved');
                    });
    }

    // 🔧 TEMP FIX to silence the missing relation error
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
