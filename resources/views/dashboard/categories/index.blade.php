@extends('layouts.app')
@section('title', 'Categories')

@section('banner', 'Categories')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Category</li>
@endsection

@section('content')

    <div class="m-3">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
            Add New Category
        </a>
        <a href="{{ route('dashboard.categories.trashed') }}" class="btn btn-dark">
            Trahed Categories
        </a>
    </div>

    <div class="card card-info m-3">
        <form action="{{ url()->current() }}" method="get" class="needs-validation">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <x-form.label id="name">Category Name</x-form.label>
                        <x-form.input type="text" name="name" value="{{ request('name') }}"
                            placeholder="Enter category name" />
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
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Description</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $category->image ? asset('storage/' . $category->image->path) : 'no image' }}"
                                    alt="" width="50px">
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div> {{ $category->parent->name ?? 'Primary' }} </div>
                            </td>
                            <td>{{ $category->description }}</td>
                            <td style="display: flex; gap: 0.5rem; align-items: center;">
                                <a href="{{ route('dashboard.categories.edit', $category) }}"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('dashboard.categories.delete', $category) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-info"
                                        onclick="return confirm('Are you sure you want to archive this category?')">
                                        Archive
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No categories found</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $categories->withQueryString()->links() }}
        </div>
    </div>

@endsection
