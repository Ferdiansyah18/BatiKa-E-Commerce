<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'price',
        'discount_price',
        'discount_start_date',
        'discount_end_date',
        'category_id',
        'description',
        'care_instructions',
        'shipping_return',
        'specifications',
        'is_featured'
    ];

    protected $casts = [
        'specifications' => 'array',
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getCurrentPriceAttribute()
    {
        if ($this->discount_price && now()->between($this->discount_start_date, $this->discount_end_date)) {
            return $this->discount_price;
        }
        return $this->price;
    }
}
