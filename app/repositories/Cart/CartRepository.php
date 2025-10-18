<?php

namespace App\repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function all(): Collection;

    public function create(Product $product, int $quantity = 1);

    public function update(Product $product, int $quantity = 1): int;

    public function delete(Product $product): int;

    public function clear(): int;

    public function total(Collection $carts): float;

    public function totalDiscount(Collection $carts): float;
}
