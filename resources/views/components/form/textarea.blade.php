@props(['name', 'for' => '', 'id' => '', 'value' => ''])

<textarea name="{{ $name }}" id="{{ $name }}" cols="30" rows="10"
    {{ $attributes->class(['form-control']) }}>{{ old($name, $value) }}</textarea>
