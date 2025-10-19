<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\StoreCartRequest;
use App\Http\Requests\Front\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\repositories\Cart\CartRepository;
use Illuminate\Http\Request;
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
        $carts = $this->cart;

        return view('front.cart.index', compact('carts'));
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

        $this->cart->update($cart->id, $validated['quantity']);

        // refresh the model to reflect new quantity / relations
        $cart->refresh();

        // calculate values
        $subtotal = ($cart->product->price ?? 0) * $cart->quantity;
        $total = $this->cart->total();
        $totalDiscount = $this->cart->totalDiscount();

        return response()->json([
            'message' => 'Cart updated successfully',
            'subtotal' => $subtotal,
            'formatted_subtotal' => Currency::format($subtotal),
            'total' => $total,
            'formatted_total' => Currency::format($total),
            'totalDiscount' => $totalDiscount,
            'formatted_totalDiscount' => Currency::format($totalDiscount),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cart $cart)
    {
        // Use repository to delete (ensure delete filters by cookie/user inside repository)
        $this->cart->delete($cart->id); // return int count

        // Recalculate totals after deletion
        $total = $this->cart->total();
        $totalDiscount = $this->cart->totalDiscount();

        return response()->json([
            'message' => 'Item removed from cart',
            'total' => $total,
            'formatted_total' => Currency::format($total),
            'totalDiscount' => $totalDiscount,
            'formatted_totalDiscount' => Currency::format($totalDiscount),
        ]);

    }
}
