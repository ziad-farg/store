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
    </div>

    <div class="card-header">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th></th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Description</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="align-middle">
                            <td>{{ $category->id }}</td>
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
    </div>
@endsection
