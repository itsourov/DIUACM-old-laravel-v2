<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Filament\Notifications\Notification;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', Rule::in(Gender::toArray())],
            'department' => ['nullable', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:20'],
            'starting_semester' => ['nullable', 'string', 'max:255'],
            'codeforces_handle' => ['nullable', 'string', 'max:255'],
            'atcoder_handle' => ['nullable', 'string', 'max:255'],
            'vjudge_handle' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:5120'], // 5MB max
        ]);
        
        // Remove avatar from validated data if it exists to handle it separately
        $avatar = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            unset($validated['avatar']);
        }
        
        $user->update($validated);
        
        // Handle avatar upload if provided
        if ($avatar) {
            // Clear previous avatars
            $user->clearMediaCollection('avatar');
            
            // Upload new avatar
            $user->addMedia($avatar)
                ->toMediaCollection('avatar', 'avatar');
        }
        
        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
            
        return back();
    }
}
