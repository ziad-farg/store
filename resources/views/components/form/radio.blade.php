@props(['name', 'items' => [], 'checked' => ''])

<div class="col-sm-10">
    @foreach ($items as $key => $value)
        <div class="form-check form-check-inline">
            <input type="radio" id="{{ Str::lower($key) }}" name="{{ $name }}"
                {{ $attributes->class(['form-check-input']) }} value="{{ $value }}"
                @checked(old($name, $checked) == $value) />
            <label class="form-check-label" for="{{ Str::lower($key) }}">
                {{ Str::ucfirst(Str::lower($key)) }} </label>
        </div>
    @endforeach
</div>

@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
