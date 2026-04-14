<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // For now, we'll just log the message and show success
            // In a real application, you would send an email here
            Log::info('Contact form submission:', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Not provided',
                'message' => $validated['message'],
                'timestamp' => now(),
            ]);

            // You can uncomment and configure this when you set up email
            /*
            Mail::send('emails.contact', $validated, function ($message) use ($validated) {
                $message->to('sanskriti@bazar.com')
                        ->subject('New Contact Form Message from ' . $validated['name']);
                $message->replyTo($validated['email'], $validated['name']);
            });
            */

            return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return redirect()->route('contact')->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}