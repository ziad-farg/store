<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'cookie_id',
        'user_id',
        'product_id',
        'quantity',
        'options',
    ];

    /**
     * we use the booted method to register the observer
     *
     * @return void
     */
    protected static function booted()
    {
        // when creating a cart we will generate a uuid for the id
        static::observe(CartObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(
            [
                'name' => 'Guest',
            ]
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
