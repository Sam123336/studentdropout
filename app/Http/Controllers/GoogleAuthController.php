<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // Step 1: Redirect user to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Google.');
        }

        // Try finding user by google_id first
        $user = User::where('google_id', $googleUser->getId())->first();

        // If not found, try finding by email (might be registered with password/register form)
        if (!$user && $googleUser->getEmail()) {
            $user = User::where('email', $googleUser->getEmail())->first();
        }

        // If still not found, create a new user with a unique name
        if (!$user) {
            $baseName = $googleUser->getName() ?: $googleUser->getNickname() ?: 'User';
            $name = $baseName;

            // Loop until we get a unique name (with a random 2-digit number if needed)
            while (User::where('name', $name)->exists()) {
                $name = $baseName . '-' . mt_rand(10, 99);
            }

            $user = User::create([
                'name' => $name,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)), // Social users can't use password login
            ]);
        } else {
            // Ensure google_id is set for future logins if missing
            if (empty($user->google_id)) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard'); // Or your home/dashboard route
    }
}
