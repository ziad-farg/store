<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\StoreCartRequest;
use App\Http\Requests\Front\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\repositories\Cart\CartRepository;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = $this->cart->all();
        $total = $this->cart->total($carts);
        $totalDiscount = $this->cart->totalDiscount($carts);

        return view('front.cart.index', compact('carts', 'total', 'totalDiscount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);
        $quantity = $validated['quantity'] ?? 1;
        $this->cart->create($product, $quantity);

        Alert::toast('Product added successfully to cart', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('front.cart.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();
        $this->cart->update($cart->product, $validated['quantity']);

        Alert::toast('Cart updated successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('front.cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $this->cart->delete($cart->product);

        Alert::toast('Product removed successfully from cart', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('front.cart.index');
    }
}
