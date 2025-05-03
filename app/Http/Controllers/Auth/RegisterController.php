<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number'  => ['required', 'string', 'max:20'],
            'gender'          => ['required', 'string', 'in:Male,Female,NonBinary,Custom'],
            'custom_gender'    => ['required_if:gender,Custom', 'nullable', 'string', 'max:255'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Handle gender selection
        $gender = $this->determineGender($data);

        // Handle profile picture upload
        $profilePicturePath = $this->handleProfilePicture($data);

        return User::create([
            'name'            => trim("{$data['first_name']} {$data['last_name']}"),
            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'],
            'email'           => $data['email'],
            'contact_number'  => $data['contact_number'],
            'gender'          => $gender,
            'password'        => Hash::make($data['password']),
            'profile_picture' => $profilePicturePath,
        ]);
    }

    /**
     * Determine the gender value based on user selection
     */
    protected function determineGender(array $data): string
    {
        return $data['gender'] === 'Custom' 
            ? $data['custom_gender'] 
            : $data['gender'];
    }

    /**
     * Handle profile picture upload if provided
     */
    protected function handleProfilePicture(array $data): ?string
    {
        if (!isset($data['profile_picture'])) {
            return null;
        }

        return $data['profile_picture']->store('profile_pictures', 'public');
    }
}