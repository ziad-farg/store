<?php

namespace App\repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function all(): Collection;

    public function create(Product $product, int $quantity = 1);

    public function update($id, int $quantity = 1): int;

    public function delete($id): int;

    public function clear(): int;

    public function total(): float;

    public function totalDiscount(): float;
}
