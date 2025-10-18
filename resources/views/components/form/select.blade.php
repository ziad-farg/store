@props(['name' => '', 'first_option' => '', 'value' => '', 'items' => [], 'select' => ''])

<select {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} id="{{ $name }}"
    name="{{ $name }}">
    <!-- First option as a placeholder -->
    <option value="">{{ $first_option }}</option>
    @foreach ($items as $item => $value)
        @php
            // Determine option value and label:
            // - If $value is an object with 'id' and 'name', use them.
            // - If $value is an array with 'id' and 'name', use them.
            // - Otherwise, use the value itself (for numbers or strings).
            if (is_object($value) && isset($value->id)) {
                $optionValue = $value->id;
                $optionLabel = isset($value->name) ? $value->name : $value->id;
            } elseif (is_array($value) && isset($value['id'])) {
                $optionValue = $value['id'];
                $optionLabel = $value['name'] ?? $value['id'];
            } else {
                $optionValue = $value;
                $optionLabel = $value;
            }
        @endphp
        <option value="{{ $optionValue }}" @selected(old($name, $select) == $optionValue)>
            {{ $optionLabel }}
        </option>
    @endforeach
</select>

<!-- Show validation error message if exists -->
@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
