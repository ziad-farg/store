@extends('layouts.app')
@section('title', 'Edit Profile')

@section('banner', 'Edit Profile')

@section('breadcrumb')
    @parent
@endsection

@section('content')
    <div class="col-md m-3">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                @include('dashboard.profile._form', ['button_label' => 'Update'])

            </form>
        </div>
    </div>
@endsection
