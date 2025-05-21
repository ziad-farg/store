<div class="card-body">

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-label="Name"
            value="{{ old('name', $category->name) }}" required />
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Parent Category --}}
    <div class="mb-3">
        <label for="parent_id" class="form-label">Parent Category</label>
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
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image" />
    </div>

    @if ($category->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $category->image->path) }}" alt="Current Image" width="100px">
        </div>
    @endif

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" aria-label="Description"
            value="{{ old('description', $category->description) }}" />
    </div>

</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
