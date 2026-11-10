<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TutorProfileController extends Controller
{
    public function edit()
    {
        $profile = TutorProfile::firstOrNew([
            'user_id' => Auth::id(),
        ]);

        return view('tutor.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'education_level' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'subjects' => ['nullable', 'string', 'max:5000'],
            'skills' => ['nullable', 'string', 'max:5000'],
            'experience' => ['nullable', 'string', 'max:5000'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0', 'max:999999'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $profile = TutorProfile::firstOrNew(['user_id' => Auth::id(),]);

            if ($request->hasFile('profile_photo')) {
                if ($profile->profile_photo) {
                    Storage::disk('public')->delete($profile->profile_photo);
                }

                $validated['profile_photo'] = $request->file('profile_photo')
                    ->store('tutor-photos', 'public');
            }

        $profile->fill($validated);
        $profile->user_id = Auth::id();
        $profile->save();

        

            
        

        return redirect()
            ->route('tutor.profile.edit')
            ->with('success', 'Your tutor profile has been saved!');
    }
}
