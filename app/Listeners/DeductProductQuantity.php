<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Models\Product;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        // foreach (Cart::all() as $item) {
        // Product::where('id', $item->product->id)
        //     ->decrement('quantity', $item->quantity);
        // }

        foreach ($event->order->products as $product) {
            $product->decrement('quantity', $product->order_item->quantity);
        }
    }
}
