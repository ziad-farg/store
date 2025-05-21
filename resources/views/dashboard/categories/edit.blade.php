@extends('layouts.app')
@section('title', 'Edit Categories')

@section('banner', 'Edit Categories')


@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Category</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
@endsection

@section('content')
    <div class="col-md m-3">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('dashboard.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('dashboard.categories._form', ['button_label' => 'Update'])

            </form>
        </div>
    </div>
@endsection
