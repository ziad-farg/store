<?php

namespace App\repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    public function all(): Collection
    {
        return Cart::with('product', 'product.image', 'product.category')
            ->where('cookie_id', $this->getCookieId())
            ->get();
    }

    public function create(Product $product, int $quantity = 1)
    {
        $cart = Cart::where('product_id', $product->id)
            ->where('cookie_id', $this->getCookieId())
            ->first();

        if (! $cart) {
            return Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return $cart->increment('quantity', $quantity);
    }

    public function update(Product $product, int $quantity = 1): int
    {
        return Cart::where('product_id', $product->id)
            ->where('cookie_id', $this->getCookieId())
            ->update(['quantity' => $quantity]);
    }

    public function delete(Product $product): int
    {
        return Cart::where('product_id', $product->id)
            ->where('cookie_id', $this->getCookieId())
            ->delete();
    }

    public function clear(): int
    {
        return Cart::where('cookie_id', $this->getCookieId())
            ->delete();
    }

    public function total(Collection $carts): float
    {
        return $carts->sum(function (Cart $cart) {
            return $cart->product->price * $cart->quantity;
        });
    }

    public function totalDiscount(Collection $carts): float
    {
        return $carts->sum(function (Cart $cart) {
            return ($cart->product->compare_price - $cart->product->price) * $cart->quantity;
        });
    }

    public function getCookieId(): string
    {
        $cart_cookie_id = Cookie::get('cart_cookie_id');

        if (! $cart_cookie_id) {
            $cart_cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cart_cookie_id, 60 * 24 * 30);

            return $cart_cookie_id;
        }

        return $cart_cookie_id;
    }
}
