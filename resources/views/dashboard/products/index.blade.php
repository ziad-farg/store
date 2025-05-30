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
                        <th>Compare Price</th>
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
                                <img src="{{ $product->image ? asset('storage/' . $product->image->path) : 'no image' }}"
                                    alt="" width="50px">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <div> {{ $product->category->name ?? 'Primary' }} </div>
                            </td>
                            <td>{{ $product->store->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->compare_price }}</td>
                            <td>{{ $product->rating }}</td>
                            <td>{{ $product->featured }}</td>
                            <td>{{ $product->status }}</td>
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
                            <td colspan="5" class="text-center">No products found</td>
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
