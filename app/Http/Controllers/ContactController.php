<?php

namespace App\Http\Controllers;

use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function show()
    {

        return view('pages.contact');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $validator->validated();

        Notification::make()
            ->title('Submission Received')
            ->body('Thank you for your message. We will get back to you soon!')
            ->success()
            ->send();

        // Send email
        // TODO: Send email

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
