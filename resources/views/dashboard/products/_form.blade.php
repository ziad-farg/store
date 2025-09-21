<div class="card-body">

    {{-- Name --}}
    <div class="mb-3">
        <x-form.label id="name">Name</x-form.label>
        <x-form.input name="name" :value="$category->name ?? old('name')" />
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Parent Category --}}
    <div class="mb-3">
        <x-form.label id="parent_id">Parent Category</x-form.label>
        <x-form.select name="parent_id" :items="$categories" :select="$category->parent_id ?? null" />
    </div>

    {{-- image --}}
    <div class="mb-3">
        <x-form.label id="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <x-form.label id="description">Description</x-form.label>
        <x-form.textarea name="description" :value="$category->description" />
    </div>

    {{-- image --}}
    <div class="mb-3">
        <x-form.label id="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
    </div>

    @if ($product->image)
        @if (Str::startsWith($product->image->path, ['http://', 'https://']))
            <img src="{{ $product->image->path }}" alt="" width="50px">
        @else
            <img src="{{ asset($product->image->path) }}" alt="" width="50px">
        @endif
    @else
        no image
    @endif
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
