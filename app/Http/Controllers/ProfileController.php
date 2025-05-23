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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp,bmp,tiff,svg', 'max:2048'], // 2MB max, more image types
        ]);
        
        // Handle avatar upload validation
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            
            // Check file size (2MB = 2048KB)
            if ($avatar->getSize() > 2048 * 1024) {
                Notification::make()
                    ->title('Image file too large')
                    ->body('The processed image is still too large. Please try with a smaller original image or contact support.')
                    ->danger()
                    ->send();
                    
                return back()->withInput();
            }
            
            // Check if it's a valid image
            $allowedMimes = [
                'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
                'image/bmp', 'image/tiff', 'image/svg+xml'
            ];
            if (!in_array($avatar->getMimeType(), $allowedMimes)) {
                Notification::make()
                    ->title('Invalid file format')
                    ->body('Please upload a valid image file. Supported formats: JPEG, PNG, GIF, WebP, BMP, TIFF, SVG.')
                    ->danger()
                    ->send();
                    
                return back()->withInput();
            }
            
            // Remove avatar from validated data to handle it separately
            unset($validated['avatar']);
            
            // Clear previous avatars and upload new one
            $user->clearMediaCollection('avatar');
            $user->addMedia($avatar)
                ->toMediaCollection('avatar', 'avatar');
        }
        
        $user->update($validated);
        
        Notification::make()
            ->title('Profile updated successfully')
            ->body('Your profile information has been updated.')
            ->success()
            ->send();
            
        return back();
    }
}
