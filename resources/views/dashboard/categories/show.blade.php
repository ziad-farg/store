@extends('layouts.app')
@section('title', $category->name)

@section('banner', $category->name)


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Category</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Action Buttons Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                    <a href="{{ route('dashboard.categories.edit', $category) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('dashboard.categories.delete', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info"
                            onclick="return confirm('Are you sure you want to archive this category?')">
                            <i class="fas fa-archive"></i> Archive
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Category Info -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tag"></i> Category Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4"><strong>Name:</strong></div>
                            <div class="col-sm-8">{{ $category->name }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4"><strong>Parent Category:</strong></div>
                            <div class="col-sm-8">
                                {{ $category->parent->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4"><strong>Description:</strong></div>
                            <div class="col-sm-8">
                                {{ $category->description ?? 'No description provided' }}
                            </div>
                        </div>
                        @if ($category->products_count != 0)
                            <hr>
                            <div class="row">
                                <div class="col-sm-4"><strong>Total Products:</strong></div>
                                <div class="col-sm-8">
                                    {{ $category->products_count }}
                                </div>
                            </div>
                        @endif
                        <hr>
                        <div class="row">
                            <div class="col-sm-4"><strong>Created:</strong></div>
                            <div class="col-sm-8">{{ $category->created_at->format('F d, Y \a\t h:i A') }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4"><strong>Last Updated:</strong></div>
                            <div class="col-sm-8">{{ $category->updated_at->format('F d, Y \a\t h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Image -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-image"></i> Category Image</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($category->image)
                            @if (Str::startsWith($category->image->path, ['http://', 'https://']))
                                <img src="{{ $category->image->path }}" alt="{{ $category->name }}"
                                    class="img-fluid rounded shadow" style="max-width: 100%; max-height: 300px;">
                            @else
                                <img src="{{ asset('storage/' . $category->image->path) }}" alt="{{ $category->name }}"
                                    class="img-fluid rounded shadow" style="max-width: 100%; max-height: 300px;">
                            @endif
                        @else
                            <div class="text-muted p-5">
                                <i class="fas fa-image fa-5x mb-3"></i>
                                <h5>No Image Available</h5>
                                <p>This category doesn't have an image yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Categories Section -->
        @if ($category->children && $category->children->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sitemap"></i>
                                Sub Categories ({{ $category->children->count() }})
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($category->children as $child)
                                    <div class="col-md-4 col-lg-3 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body text-center">
                                                @if ($child->image)
                                                    @if (Str::startsWith($child->image->path, ['http://', 'https://']))
                                                        <img src="{{ $child->image->path }}" alt="{{ $child->name }}"
                                                            class="rounded-circle mb-3"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('storage/' . $child->image->path) }}"
                                                            alt="{{ $child->name }}" class="rounded-circle mb-3"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                @else
                                                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 80px;">
                                                        <i class="fas fa-tag text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                                <h6 class="card-title">{{ $child->name }}</h6>
                                                <small class="text-muted d-block mb-3">
                                                    {{ $child->products_count ?? $child->products()->count() }} products
                                                </small>
                                                <a href="{{ route('dashboard.categories.show', $child) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products in Category -->
        @if ($products && $products->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-box"></i>
                                Products ({{ $category->products_count }})
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="80">Image</th>
                                            <th>Product Name</th>
                                            <th>Store</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    @if ($product->image)
                                                        @if (Str::startsWith($product->image->path, ['http://', 'https://']))
                                                            <img src="{{ $product->image->path }}" alt=""
                                                                width="50px">
                                                        @else
                                                            <img src="{{ asset($product->image->path) }}" alt=""
                                                                width="50px">
                                                        @endif
                                                    @else
                                                        no image
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $product->name }}</strong>
                                                    <span
                                                        class="badge {{ $product->featured ? 'text-bg-danger' : 'text-bg-secondary' }} ml-1">
                                                        {{ $product->featured ? 'Featured' : 'Normal' }}
                                                    </span>
                                                </td>
                                                <td>{{ $product->store->name ?? 'N/A' }}</td>
                                                <td>
                                                    <strong>${{ number_format($product->price, 2) }}</strong>
                                                    @if ($product->compare_price)
                                                        <br><small
                                                            class="text-muted"><s>${{ number_format($product->compare_price, 2) }}</s></small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->status)
                                                        <span
                                                            class="badge text-bg-{{ $product->status_label === 'Active' ? 'success' : ($product->status_label === 'Draft' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($product->status_label) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('dashboard.products.show', $product) }}"
                                                        class="btn btn-sm btn-outline-primary" title="View Product">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="mt-3">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">No Products Yet</h4>
                            <p class="text-muted mb-4">This category doesn't contain any products.</p>
                            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add First Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ $category->products_count ?? $category->products()->count() }}</h3>
                                <p class="mb-0">Total Products</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ $category->children_count ?? $category->children()->count() }}</h3>
                                <p class="mb-0">Sub Categories</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-sitemap fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ $category->products()->where('featured', true)->count() }}</h3>
                                <p class="mb-0">Featured Products</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ $category->products()->where('status', 'active')->count() }}</h3>
                                <p class="mb-0">Active Products</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
