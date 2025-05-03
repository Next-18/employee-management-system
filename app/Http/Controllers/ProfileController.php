<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user()->fresh(); // Fetch the latest data from the database
        return view('profile.profile', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate input data
        $validated = $request->validate([
            
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'gender' => ['required', 'string', 'in:Male,Female,NonBinary,Custom'],
            'custom_gender' => ['nullable', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        // Handle password change
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }

            if ($request->filled('new_password')) {
                $user->password = Hash::make($validated['new_password']);
            }
        }

        // Update basic profile information
        $user->name = trim($user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name);
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->contact_number = $validated['contact_number'];
        $user->gender = $validated['gender'] === 'Custom' ? 'Custom' : $validated['gender'];
        $user->custom_gender = $validated['gender'] === 'Custom' ? $validated['custom_gender'] : null;

        // Save the updated user information
        $user->save();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $this->updateProfilePicture($user, $request->file('profile_picture'));
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's profile picture.
     */
    private function updateProfilePicture(User $user, $image)
    {
        // Delete old profile picture if it exists
        if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
            Storage::delete('public/' . $user->profile_picture);
        }

        // Store the new profile picture
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/profile_pictures', $imageName);

        // Update the user's profile picture path
        $user->profile_picture = 'profile_pictures/' . $imageName;
        $user->save();
    }
}
