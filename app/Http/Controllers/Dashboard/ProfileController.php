<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Locales;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;



class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $user = Auth::user();

        // Get list of countries for the dropdowns from Symfony Intl component package
        // This provides a standardized list of country codes and names
        // which is more reliable than hardcoding or using a custom list.
        // It also supports localization if needed in the future.
        $countries = Countries::getNames();

        // Get list of locales for the dropdown from Symfony Intl component package
        $locales = Locales::getNames();


        return view('dashboard.profile.edit', compact('user', 'countries', 'locales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($user, $request) {
            // Fill the profile with validated data
            $user->profile->fill($request->validated())->save();

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('uploads/profiles', 'public');

                if ($user->profile->image) {
                    if ($user->profile->image->path) {
                        Storage::disk('public')->delete($user->profile->image->path);
                    }
                    $user->profile->image->update(['path' => $path]);
                } else {
                    $user->profile->image()->create(['path' => $path]);
                }
            }
        });


        Alert::toast('Profile updated successfully.', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.profile.edit');
    }
}
