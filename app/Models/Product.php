<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'strain', 'category', 'emoji', 'thc',
        'price_gram', 'price_ounce', 'rating', 'reviews',
        'is_new', 'featured', 'active', 'image', 'cloudinary_public_id', 'description',
    ];

    protected $casts = [
        'is_new'      => 'boolean',
        'featured'    => 'boolean',
        'active'      => 'boolean',
        'price_gram'  => 'float',
        'price_ounce' => 'float',
        'rating'      => 'float',
    ];

    /**
     * Return the product as a JS-friendly array for the frontend.
     */
    public function toJsArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'strain'     => $this->strain,
            'category'   => $this->category,
            'emoji'      => $this->emoji ?: '🌿',
            'thc'        => $this->thc ?? '',
            'priceGram'  => (float) $this->price_gram,
            'priceOunce' => (float) $this->price_ounce,
            'rating'     => (float) $this->rating,
            'reviews'    => (int) $this->reviews,
            'isNew'      => (bool) $this->is_new,
            'featured'   => (bool) $this->featured,
            'image'      => $this->image ?: null,
        ];
    }
}
