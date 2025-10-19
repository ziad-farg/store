<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

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
        // Add a global scope to filter by cookie_id
        static::addGlobalScope('cart_cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', self::getCookieId());
        });

        // when creating a cart we will generate a uuid for the id
        static::observe(CartObserver::class);
    }

    public static function getCookieId(): string
    {
        $cart_cookie_id = Cookie::get('cart_cookie_id');

        if (! $cart_cookie_id) {
            $cart_cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cart_cookie_id, 60 * 24 * 30);

            return $cart_cookie_id;
        }

        return $cart_cookie_id;
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
