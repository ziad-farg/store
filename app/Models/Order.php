<?php

namespace App\Models;

use App\Enums\OrderAddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'status',
        'payment_status',
        'payment_method',
        'tax',
        'discount',
        'total',
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = static::generateOrderNumber();
        });
    }

    protected static function generateOrderNumber(): string
    {
        $year = now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1;
        }

        return $year.'0001';
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest',
        ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', OrderAddressType::BILLING);
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', OrderAddressType::SHIPPING);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->using(OrderItem::class)
            ->withPivot(['product_name', 'quantity', 'price', 'options']);
    }
}
