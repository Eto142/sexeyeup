<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference', 'customer_phone', 'customer_phone2', 'total', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateReference(): string
    {
        return 'SEU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
