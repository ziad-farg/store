@props(['type' => 'text', 'name', 'value' => ''])

<input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} accept="image/*" />

@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
