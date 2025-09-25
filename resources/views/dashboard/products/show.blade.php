@extends('layouts.app')
@section('title', $product->name)

@section('banner', $product->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-12 d-flex gap-2">
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('dashboard.products.edit', $product) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('dashboard.products.delete', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-info"
                        onclick="return confirm('Are you sure you want to archive this product?')">
                        <i class="fas fa-archive"></i> Archive
                    </button>
                </form>
            </div>
        </div>
        {{--
        'options',
        'rating',
         --}}
        <!-- Product Details -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Product Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Name:</div>
                            <div class="col-sm-8">{{ $product->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Store:</div>
                            <div class="col-sm-8">{{ $product->store->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Category:</div>
                            <div class="col-sm-8">{{ $product->category->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Category:</div>
                            <div class="col-sm-8">{{ $product->price }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Old Price:</div>
                            <div class="col-sm-8">
                                <span class="text-decoration-line-through text-muted">{{ $product->compare_price }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold ">Freatured:</div>
                            <div class="col-sm-8">
                                <span
                                    class="badge {{ $product->featured ? 'bg-danger text-white' : 'bg-secondary text-white' }} px-3 py-2">
                                    {{ $product->featured_label }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Status:</div>
                            <div class="col-sm-8">{{ $product->status_label }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Description:</div>
                            <div class="col-sm-8">{{ $product->description ?? 'No description provided' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Created At:</div>
                            <div class="col-sm-8">{{ $product->created_at->format('F d, Y \a\t h:i A') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Last Updated:</div>
                            <div class="col-sm-8">{{ $product->updated_at->format('F d, Y \a\t h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Image -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-image"></i> Product Image</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($product->image)
                            <img src="{{ Str::startsWith($product->image->path, ['http://', 'https://']) ? $product->image->path : asset('storage/' . $product->image->path) }}"
                                alt="{{ $product->name }}" class="img-fluid rounded shadow"
                                style="max-width: 100%; max-height: 300px;">
                        @else
                            <div class="text-muted p-5">
                                <i class="fas fa-image fa-5x mb-3"></i>
                                <h5>No Image Available</h5>
                                <p>This product doesn't have an image yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
