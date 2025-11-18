<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you can handle the contact form submission
        // For example, send an email or save to database

        // Example: Send email (you need to configure mail settings)
        // Mail::to('admin@unifix.com')->send(new ContactMail($request->all()));

        // For now, just redirect back with success message
        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
