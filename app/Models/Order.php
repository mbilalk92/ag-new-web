<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'email', 'phone', 'address', 'city',
        'notes', 'payment_method', 'payment_proof', 'status',
        'subtotal', 'shipping_fee', 'total',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'AG-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));
    }
}
