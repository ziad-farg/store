<div class="card-body">

    {{-- First Name --}}
    <div class="mb-3">
        <x-form.label id="first_name">First Name</x-form.label>
        <x-form.input name="first_name" :value="$user->profile->first_name" />
    </div>


    {{-- Last Name --}}
    <div class="mb-3">
        <x-form.label id="last_name">Last Name</x-form.label>
        <x-form.input name="last_name" :value="$user->profile->last_name" />
    </div>

    {{-- Birthday --}}
    <div class="mb-3">
        <x-form.label id="birthday">Birthday</x-form.label>
        <x-form.input type="date" name="birthday" :value="$user->profile->birthday" />
    </div>

    {{-- Gender --}}
    <div class="mb-3">
        <x-form.label id="gender">Gender</x-form.label>
        <x-form.radio name="gender" :items="\App\Enums\Gender::keyValueMap()" :checked="$user->profile->gender?->value" />
    </div>

    {{-- Street Address --}}
    <div class="mb-3">
        <x-form.label id="street_address">Street Address</x-form.label>
        <x-form.input name="street_address" :value="$user->profile->street_address" />
    </div>

    {{-- City --}}
    <div class="mb-3">
        <x-form.label id="city">City</x-form.label>
        <x-form.input name="city" :value="$user->profile->city" />
    </div>

    {{-- State --}}
    <div class="mb-3">
        <x-form.label id="state">State</x-form.label>
        <x-form.input name="state" :value="$user->profile->state" />
    </div>

    {{-- Postal Code --}}
    <div class="mb-3">
        <x-form.label id="postal_code">Postal Code</x-form.label>
        <x-form.input name="postal_code" :value="$user->profile->postal_code" />
    </div>

    {{-- Country --}}
    <div class="mb-3">
        <x-form.label id="country">Country</x-form.label>
        <x-form.select name="country" first_option="Select Country" :select="$user->profile->country" :items="$countries" />
    </div>

    {{-- Locale --}}
    <div class="mb-3">
        <x-form.label id="locale">Locale</x-form.label>
        <x-form.select name="locale" first_option="Select Locale" :select="$user->profile->locale" :items="$locales" />
    </div>


    {{-- image --}}
    <div class="mb-3">
        <x-form.label id="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
    </div>

    @if ($user->profile->image)
        @if (Str::startsWith($user->profile->image->path, ['http://', 'https://']))
            <img src="{{ $user->profile->image->path }}" alt="" width="50px">
        @else
            <img src="{{ asset($user->profile->image->path) }}" alt="" width="50px">
        @endif
    @else
        no image
    @endif
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('dashboard.home') }}" class="btn btn-secondary">Cancel</a>
</div>
