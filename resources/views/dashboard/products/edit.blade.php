@extends('layouts.app')
@section('title', 'Edit Products')

@section('banner', 'Edit Products')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Product</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
@endsection

@section('content')
    <div class="col-md m-3">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('dashboard.products._form', ['button_label' => 'Update'])

            </form>
        </div>
    </div>
@endsection
