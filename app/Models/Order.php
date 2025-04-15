<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'shipping_address',
        'payment_method'
    ];

    protected $casts = [
        'total_price' => 'float',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke tabel products melalui order_items (many-to-many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'price');
    }

    // Scope untuk filter pesanan yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
