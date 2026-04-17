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
            // Send simple text email to admin
            $adminMessage = "New Contact Form Message from Sanskriti Bazar\n\n";
            $adminMessage .= "Name: " . $validated['name'] . "\n";
            $adminMessage .= "Email: " . $validated['email'] . "\n";
            $adminMessage .= "Phone: " . ($validated['phone'] ?? 'Not provided') . "\n";
            $adminMessage .= "Message: " . $validated['message'] . "\n";
            $adminMessage .= "Submitted: " . now()->format('F j, Y \a\t g:i A') . "\n";

            Mail::raw($adminMessage, function ($message) use ($validated) {
                $message->to('grgprabesh888@gmail.com')
                        ->subject('New Contact Form Message from ' . $validated['name'])
                        ->replyTo($validated['email'], $validated['name']);
            });

            // Send simple confirmation email to customer
            $customerMessage = "Dear " . $validated['name'] . ",\n\n";
            $customerMessage .= "Thank you for contacting Sanskriti Bazar!\n\n";
            $customerMessage .= "We have received your message and will get back to you within 24 hours.\n\n";
            $customerMessage .= "Your message:\n" . $validated['message'] . "\n\n";
            $customerMessage .= "For immediate assistance:\n";
            $customerMessage .= "Phone/WhatsApp: +977 9816618275\n";
            $customerMessage .= "Email: grgprabesh888@gmail.com\n";
            $customerMessage .= "Location: Thamel, Kathmandu\n\n";
            $customerMessage .= "Best regards,\n";
            $customerMessage .= "Sanskriti Bazar Team\n";
            $customerMessage .= "Traditional Musical Instruments of Nepal";

            Mail::raw($customerMessage, function ($message) use ($validated) {
                $message->to($validated['email'], $validated['name'])
                        ->subject('Thank you for contacting Sanskriti Bazar');
            });

            // Log the successful submission
            Log::info('Contact form submission sent successfully:', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Not provided',
                'timestamp' => now(),
            ]);

            return redirect()->route('contact')->with('success', 'Thank you for your message! We have received your inquiry and will get back to you within 24 hours. You should also receive a confirmation email shortly.');

        } catch (\Exception $e) {
            Log::error('Contact form email error: ' . $e->getMessage());
            Log::error('Contact form error details: ' . $e->getTraceAsString());
            
            // Still log the message even if email fails
            Log::info('Contact form submission (email failed):', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Not provided',
                'message' => $validated['message'],
                'timestamp' => now(),
            ]);

            return redirect()->route('contact')->with('error', 'Sorry, there was an error sending your message. Please try again or contact us directly at grgprabesh888@gmail.com or call +977 9816618275.');
        }
    }
}