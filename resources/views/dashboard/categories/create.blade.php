@extends('layouts.app')
@section('title', 'Add Categories')

@section('banner', 'Add Categories')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Category</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
@endsection

@section('content')
    <div class="col-md m-3">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('dashboard.categories._form')

            </form>
        </div>
    </div>
@endsection
