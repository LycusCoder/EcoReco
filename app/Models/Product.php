<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'rating',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'integer',
        'rating' => 'float',
    ];

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke tabel order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke tabel ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Accessor untuk jumlah ulasan
    public function getRatingsCountAttribute()
    {
        return $this->ratings()->count();
    }

    // Relasi ke tabel recommendations
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


     // Accessor untuk image URL
     public function getImageUrlAttribute()
     {
         if (!$this->image) {
             return asset('/default_product.png');
         }

         if (Str::startsWith($this->image, 'https://example')) {
             return asset('/default_product.png');
         } elseif (Str::startsWith($this->image, ['http://', 'https://'])) {
             return $this->image;
         } else {
             return asset('storage/' . $this->image);
         }
     }


}
