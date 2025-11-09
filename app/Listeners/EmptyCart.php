<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;

class EmptyCart
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
        Cart::clear();
    }
}
