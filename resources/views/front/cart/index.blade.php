<x-front-layout title="cart">

    <!-- Start breadcrumbs -->
    <x-slot:breadcrumbs>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li>
                                <a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}"><i class="lni lni-home"></i> Shop</a>
                            </li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumbs>
    <!-- End breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->
                @foreach ($carts as $cart)
                    <!-- Cart Single List list -->
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ $cart->product->image_url }}">
                                    <img src="{{ $cart->product->image_url }}" alt="#">
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name">
                                    <a href="{{ route('products.show', $cart->product) }}">
                                        {{ $cart->product->name }}
                                    </a>
                                </h5>
                                <p class="product-des">
                                    <span><em>Type:</em> {{ $cart->product->category->name }}</span>
                                    <span><em>Color:</em> Black</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <x-form.select name="quantity" :select="old('quantity', $cart->quantity)" :items="range(1, 5)" />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ Currency::format($cart->product->price * $cart->quantity) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ Currency::format(($cart->product->compare_price - $cart->product->price) * $cart->quantity) }}
                                </p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <form action="{{ route('front.cart.destroy', $cart->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item">
                                        <i class="lni lni-close"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Single List list -->
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>{{ Currency::format($totalDiscount) }}</span></li>
                                        <li>Cart Subtotal<span>{{ Currency::format($total) }}</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="checkout.html" class="btn">Checkout</a>
                                        <a href="product-grids.html" class="btn btn-alt">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

</x-front-layout>
