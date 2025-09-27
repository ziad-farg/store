<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('front.product.index');
    }

    public function show(Product $product)
    {
        if ($product->status != ProductStatus::ACTIVE) {
            abort(404);
        }
        return view('front.product.show', compact('product'));
    }
}
