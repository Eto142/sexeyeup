<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'title',
        'badge',
        'description',
        'button_text',
        'ends_at',
        'active',
    ];

    protected $casts = [
        'ends_at' => 'datetime',
        'active'  => 'boolean',
    ];

    public static function getActive(): ?self
    {
        return static::where('active', true)
            ->where('ends_at', '>', now())
            ->latest()
            ->first();
    }
}
