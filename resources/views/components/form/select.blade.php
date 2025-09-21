@props(['name' => '', 'first_option' => '', 'value' => '', 'items' => [], 'select' => ''])

<select {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} id="{{ $name }}"
    name="{{ $name }}">
    <option value="">{{ $first_option }}</option>
    @foreach ($items as $item => $value)
        <option value="{{ $value->id ?? $item }}" @selected(old($name, $select) == ($value->id ?? $item))>
            {{ $value->name ?? $value }}
        </option>
    @endforeach
</select>

@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
