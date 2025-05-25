<div class="card-body">

    {{-- Name --}}
    <div class="mb-3">
 feature/category-component
        <x-form.label id="name">Name</x-form.label>
        <x-form.input name="name" :value="$category->name" />
        <label for="name" class="form-label">Name</label>
        <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" name="name" aria-label="Name"
            value="{{ old('name', $category->name) }}" required />
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Parent Category --}}
    <div class="mb-3">
        <x-form.label id="parent_id">Parent Category</x-form.label>
        <select class="form-control" id="parent_id" name="parent_id" aria-label="Parent Category">
            <option value="">Primary Category</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}" @selected(old('parent_id', $category->parent_id) == $item->id)>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- image --}}
    <div class="mb-3">
        <x-form.label id="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
    </div>

    @if ($category->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $category->image->path) }}" alt="Current Image" width="100px">
        </div>
    @endif

    {{-- Description --}}
    <div class="mb-3">
        <x-form.label id="description">Description</x-form.label>
        <x-form.textarea name="description" :value="$category->description" />
    </div>

</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
