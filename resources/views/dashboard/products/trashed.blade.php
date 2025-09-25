@extends('layouts.app')
@section('title', 'Trashed Products')

@section('banner', 'Trashed Products')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Product</a></li>
    <li class="breadcrumb-item active" aria-current="page">Trashed Product</li>
@endsection

@section('content')

    <div class="m-3">
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-info">
            Back
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
                                    <img src="{{ Str::startsWith($product->image->path, ['http://', 'https://']) ? $product->image->path : asset($product->image->path) }}"
                                        alt="" class="img-thumbnail" style="width: 50px; height: 50px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Primary' }}</td>
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
                                    {{ $product->featured_label }}
                                </span>
                            </td>
                            <td>{{ $product->status_label }}</td>
                            <td>{{ $product->description }}</td>
                            <td class="d-flex gap-2">
                                <form action="{{ route('dashboard.products.restore', $product) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Are you sure you want to restore this product?')">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.products.forceDelete', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No trashed products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

@endsection
