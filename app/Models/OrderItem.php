<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'book_id', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function book() // 🔹 Changed 'product' to 'book'
    {
        return $this->belongsTo(Product::class, 'book_id'); // 🔹 Fixed relation
    }
}
