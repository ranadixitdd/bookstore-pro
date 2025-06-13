<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name']; // ✅ Add fillable fields

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
