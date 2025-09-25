@extends('layouts.app')
@section('title', 'Add Products')

@section('banner', 'Add Products')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Product</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
@endsection

@section('content')
    <div class="col-md m-3">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('dashboard.products._form')

            </form>
        </div>
    </div>
@endsection
