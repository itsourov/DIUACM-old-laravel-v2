<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function googleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->user();

            // Validate that the email domain is either diu.edu.bd or s.diu.edu.bd
            $email = $googleUser->getEmail();
            $allowedDomains = ['diu.edu.bd', 's.diu.edu.bd'];
            $domain = Str::after($email, '@');
            
            if (!in_array($domain, $allowedDomains)) {
                Notification::make()
                    ->title('Login Failed')
                    ->body('You must use a DIU email address (@diu.edu.bd or @s.diu.edu.bd) to log in.')
                    ->danger()
                    ->send();
                    
                return redirect()->route('home');
            }

            $user = User::where('email', $email)->first();
            if (! $user) {
                $username = Str::before($email, '@');
                $password = Str::random(10);
                $new_user = User::create([
                    'name' => $googleUser->getName(),
                    'username' => $username,
                    'email' => $email,
                    'password' => bcrypt($password),
                ]);

                Auth::login($new_user);
                Notification::make()
                    ->title('You are now logged in!')
                    ->success()
                    ->send();
                if ($googleUser['verified_email']) {
                    $new_user->markEmailAsVerified();
                }
                $new_user->addMediaFromUrl(str_replace('=s96-c', '', $googleUser->avatar))
                    ->usingFileName($googleUser->name.'.png')
                    ->toMediaCollection('avatar', 'avatar');

                return redirect()->route('my-account.profile.edit');
            } else {
                Auth::login($user);
                if ($googleUser['verified_email']) {
                    $user->markEmailAsVerified();
                }
                Notification::make()
                    ->title('You are now logged in!')
                    ->success()
                    ->send();

                return redirect()->intended(route('home'));
            }
        } catch (\Throwable $th) {
            Notification::make()
                ->title('There was an error while logging in.')
                ->body($th->getMessage())
                ->danger()
                ->send();

            return redirect()->intended(route('home'));

        }
    }
}
