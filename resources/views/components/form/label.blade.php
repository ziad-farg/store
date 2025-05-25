@props(['id' => ''])
<label for="{{ $id }}" {{ $attributes->class(['form-label']) }}>{{ $slot }}</label>
