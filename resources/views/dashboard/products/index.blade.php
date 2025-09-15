@extends('layouts.app')
@section('title', 'Products')

@section('banner', 'Products')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Product</li>
@endsection

@section('content')

    <div class="m-3">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
            Add New Product
        </a>
        <a href="{{ route('dashboard.products.trashed') }}" class="btn btn-dark">
            Trahed Products
        </a>
    </div>

    <div class="card card-info m-3">
        <form action="{{ url()->current() }}" method="get" class="needs-validation">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <x-form.label id="name">Product Name</x-form.label>
                        <x-form.input type="text" name="name" value="{{ request('name') }}"
                            placeholder="Enter product name" />
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Store</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($product->image)
                                    @if (Str::startsWith($product->image->path, ['http://', 'https://']))
                                        <img src="{{ $product->image->path }}" alt="" width="50px">
                                    @else
                                        <img src="{{ asset($product->image->path) }}" alt="" width="50px">
                                    @endif
                                @else
                                    no image
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <div> {{ $product->category->name ?? 'Primary' }} </div>
                            </td>
                            <td>{{ $product->store->name }}</td>
                            <td>
                                <strong>${{ number_format($product->price, 2) }}</strong>
                                @if ($product->compare_price)
                                    <br><small
                                        class="text-muted text-decoration-line-through">${{ number_format($product->compare_price, 2) }}</small>
                                @endif
                            </td>
                            <td>{{ $product->rating }}</td>
                            <td>
                                <span class="badge {{ $product->featured ? 'text-bg-danger' : 'text-bg-secondary' }}">
                                    {{ $product->featured ? 'Featured' : 'Normal' }}
                                </span>
                            </td>
                            <td>
                                {{ $product->status_label }}
                            </td>
                            <td>{{ $product->description }}</td>
                            <td style="display: flex; gap: 0.5rem; align-items: center;">
                                <a href="{{ route('dashboard.products.edit', $product) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('dashboard.products.delete', $product) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-info"
                                        onclick="return confirm('Are you sure you want to archive this product?')">
                                        Archive
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

@endsection
