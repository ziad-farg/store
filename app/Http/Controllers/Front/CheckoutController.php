<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Checkout\StoreCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        $countries = Countries::getNames();

        if ($cart->all()->count() == 0) {
            return redirect()->route('home');
        }

        return view('front.checkout.create', compact('cart', 'countries'));
    }

    public function store(StoreCheckoutRequest $request, CartRepository $cart)
    {

        DB::beginTransaction();

        // get all stores id
        $items = $cart->all()->groupBy('product.store_id')->all();

        try {
            $validated = $request->validated();

            foreach ($items as $store_id => $cart_items) {

                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::user()->id ?? null,
                    'status' => 3,
                    'payment_status' => 2,
                    'payment_method' => 1,
                    'tax' => 0,
                    'discount' => $cart_items->sum(fn ($item) => ($item->product->compare_price - $item->product->price) * $item->quantity),
                    'total' => $cart_items->sum(fn ($item) => $item->quantity * $item->product->price),
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                        'options' => $item->options,
                    ]);
                }

                foreach ($validated['addr'] as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            // clear the cart via repository (this deletes DB rows)
            $cart->clear();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('home');
    }
}
