@props(['type' => 'text', 'name', 'value' => ''])

@php
    // convert "addr[billing][first_name]" => "addr.billing.first_name"
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = trim($errorKey, '.');

    // create safe id from name (replace brackets with underscores)
    $id = preg_replace('/[^A-Za-z0-9\-_]/', '_', $name);
@endphp

<input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{ old($errorKey, $value) }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($errorKey)]) }} accept="image/*" />

@error($errorKey)
    <small class="text-danger">{{ $message }}</small>
@enderror
