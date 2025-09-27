<div class="card-body">

    {{-- Product Name --}}
    <div class="mb-3">
        <x-form.label id="name">Product Name</x-form.label>
        <x-form.input name="name" :value="$product->name" />
    </div>

    {{-- Price --}}
    <div class="mb-3">
        <x-form.label id="price">Price</x-form.label>
        <x-form.input type="number" name="price" :value="$product->price" />
    </div>

    {{-- Compare Price --}}
    <div class="mb-3">
        <x-form.label id="compare_price">Compare Price</x-form.label>
        <x-form.input type="number" name="compare_price" :value="$product->compare_price" />
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <x-form.label id="category_id">Category</x-form.label>
        <x-form.select first_option="Select Category" name="category_id" :items="$categories" :select="$product->category_id" />
    </div>

    {{-- store --}}
    @if (Auth::user()->name == 'admin')
        <div class="mb-3">
            <x-form.label id="store_id">Store</x-form.label>
            <x-form.select first_option="Select Store" name="store_id" :items="$stores" :select="$product->store_id" />
        </div>
    @endif

    {{-- Product Status --}}
    <div class="mb-3">
        <x-form.label id="status">Product Status</x-form.label>
        <x-form.radio name="status" :items="ProductStatus::keyValueMap()" :checked="$product->status?->value" />
    </div>

    {{-- Featured --}}
    <div class="mb-3">
        <x-form.label id="featured">Featured</x-form.label>
        <x-form.radio name="featured" :items="['Yes' => 1, 'No' => 0]" :checked="$product->featured" />
    </div>

    {{-- Tag --}}
    <div class="mb-3">
        <x-form.label id="tags">Tag</x-form.label>
        <x-form.input name="tags" :value="$tags ?? null" />
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <x-form.label id="description">Description</x-form.label>
        <x-form.textarea name="description" :value="$product->description" />
    </div>

    {{-- image --}}
    <div class="mb-3">
        <x-form.label id="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
    </div>

    <img src="{{ $product->image_url }}" alt="" width="50px">
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">Cancel</a>
</div>


@push('styles')
    {{-- tag package --}}
    <link rel="stylesheet" href="{{ asset('css/tagify.css') }}">
@endpush

@push('scripts')
    {{-- tag package --}}
    <script src="{{ asset('js/tagify.min.js') }}"></script>
    <script src="{{ asset('js/tagify.js') }}"></script>
    <script>
        // Initialize Tagify on the input field
        var input = document.querySelector('input[name=tags]');
        new Tagify(input);
    </script>
@endpush
