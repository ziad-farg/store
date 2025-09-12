@props(['name' => '', 'value' => '', 'items' => [], 'select' => ''])

<select {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} id="{{ $name }}"
    name="{{ $name }}">
    <option value="">Primary Category</option>
    @foreach ($items as $item)
        <option value="{{ $item->id }}" @selected(old($name, $select) == $item->id)>
            {{ $item->name }}
        </option>
    @endforeach
</select>


@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
