<?php

namespace App\repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartModelRepository implements CartRepository
{
    public $carts;

    public function __construct()
    {
        $this->carts = collect();
    }

    public function all(): Collection
    {
        if (! $this->carts->count()) {
            $this->carts = Cart::with('product', 'product.image', 'product.category')
                ->get();
        }

        return $this->carts;
    }

    public function create(Product $product, int $quantity = 1)
    {
        $cart = Cart::where('product_id', $product->id)
            ->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            return $this->all()->push($cart);
        }

        return $cart->increment('quantity', $quantity);
    }

    public function update($id, int $quantity = 1): int
    {
        return Cart::where('id', $id)
            ->update(['quantity' => $quantity]);
    }

    public function delete($id): int
    {
        return Cart::where('id', $id)->delete();
    }

    public function clear(): int
    {
        return Cart::query()->delete();
    }

    public function total(): float
    {
        return $this->all()->sum(function (Cart $cart) {
            return $cart->product->price * $cart->quantity;
        });
    }

    public function totalDiscount(): float
    {
        return $this->all()->sum(function (Cart $cart) {
            return ($cart->product->compare_price - $cart->product->price) * $cart->quantity;
        });
    }
}
