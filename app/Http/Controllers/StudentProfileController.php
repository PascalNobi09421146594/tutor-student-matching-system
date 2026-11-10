<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function edit()
    {
        $profile = StudentProfile::firstOrNew([
            'user_id' => Auth::id(),
        ]);

        return view('student.profile', compact('profile'));
    }

    public function update(Request $request)
{
    $validated = $request->validate([
        'education_level' => ['nullable', 'string', 'max:255'],
        'skills' => ['nullable', 'string', 'max:5000'],
        'learning_goals' => ['nullable', 'string', 'max:5000'],
        'preferred_subjects' => ['nullable', 'string', 'max:5000'],
        'profile_photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    $profile = StudentProfile::firstOrNew([
        'user_id' => Auth::id(),
    ]);

    if ($request->hasFile('profile_photo')) {
        if ($profile->profile_photo) {
            Storage::disk('public')->delete($profile->profile_photo);
        }

        $validated['profile_photo'] = $request->file('profile_photo')
            ->store('profile-photos', 'public');
    }

    $profile->fill($validated);
    $profile->user_id = Auth::id();
    $profile->save();

    return redirect()
        ->route('student.profile.edit')
        ->with('success', 'Your student profile has been saved!');
}
}
