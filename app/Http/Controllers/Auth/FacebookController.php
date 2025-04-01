<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Log;

class FacebookController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Check if the user already exists in the system
            $existingUser = User::where('email', $facebookUser->email)->first();
            if ($existingUser) {
                // User exists, update facebook_id if not present
                if (empty($existingUser->facebook_id)) {
                    $existingUser->facebook_id = $facebookUser->id;
                    $existingUser->save();
                }

                Auth::login($existingUser);
                return redirect()->intended(route('home'));
            } else {
                // Create a unique username from email
                $baseName = explode('@', $facebookUser->email)[0];
                $username = $baseName;
                $counter = 1;

                while (User::where('username', $username)->exists()) {
                    $username = $baseName . $counter;
                    $counter++;
                }


                // Create a new user
                $newUser = User::create([
                    'username' => $username,
                    'email' => $facebookUser->email,
                    'facebook_id' => $facebookUser->id,
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                    'balance' => 0
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('home'))
                    ->with('success', 'Bạn đã đăng ký tài khoản thành công');
            }

        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            // dd($e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Đăng nhập thất bại. Vui lòng thử lại sau.');
        }
    }
}