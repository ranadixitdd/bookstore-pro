<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class Product extends Model
{
    protected $fillable = ['title', 'name', 'author', 'price', 'category_id',
        'description', 'category', 'image', 'stock', 'best_seller'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // Method to calculate the average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating'); // Assuming 'rating' is the column name in your reviews table
    }

    // Method to get the count of reviews
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
    // Product.php
public function approvedReviews()
{
    return $this->hasMany(Review::class)->where('status', 1);
}

}
