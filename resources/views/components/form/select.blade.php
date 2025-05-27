@props(['name' => '', 'value' => '', 'items' => [], 'select' => ''])

<select class="form-control" id="{{ $name }}" name="{{ $name }}">
    <option value="">Primary Category</option>
    @foreach ($items as $item)
        <option value="{{ $item->id }}" @selected(old($name, $select) == $item->id)>
            {{ $item->name }}
        </option>
    @endforeach
</select>
