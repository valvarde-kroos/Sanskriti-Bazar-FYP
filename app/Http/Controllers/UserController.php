<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Show login form
    public function loginForm()
    {
        return view('login'); // make sure login.blade.php exists
    }

    // Process login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            
            // Check if there's an intended URL (like cart page)
            $intendedUrl = session('url.intended');
            
            if ($intendedUrl) {
                // Clear the intended URL from session
                session()->forget('url.intended');
                // Redirect to the intended URL
                return redirect($intendedUrl)->with('success', 'Welcome back! You have been successfully logged in.');
            }
            
            // Default redirect based on role if no intended URL
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isVendor()) {
                return redirect()->route('vendor.dashboard');
            } else {
                return redirect()->route('home')->with('success', 'Welcome back! You have been successfully logged in.'); // Customer goes to home page
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Show signup form
    public function signupForm()
    {
        return view('signup'); // make sure signup.blade.php exists
    }

    // Process signup
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            'phone'=>'nullable|string|max:20',
            'role'=>'required|in:admin,vendor,customer'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'phone'=>$request->phone,
            'role'=>$request->role ?? 'customer',
            'approval_status' => ($request->role === 'vendor') ? 'pending' : 'approved',
            'is_active' => true,
        ]);

        // Don't auto-login vendors who need approval
        if ($request->role === 'vendor') {
            return redirect()->route('login')->with('success', 'Your vendor account has been created! Please wait for admin approval before logging in.');
        }

        Auth::login($user);
        
        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home')->with('success', 'Welcome to Sanskriti Bazar! Your account has been created successfully.');
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Profile (assuming products relationship is defined)
    public function profile()
    {
        $user = auth()->user();
        $products = $user->products ?? collect(); // empty collection if none

        return view('profile', compact('user', 'products'));
    }

    // Show forgot password form
    public function forgotPasswordForm()
    {
        return view('forgot-password');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Find the user
        $user = User::where('email', $request->email)->first();

        // Generate a unique token
        $token = Str::random(64);

        // Delete any existing reset tokens for this email
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Insert new reset token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Create the reset URL
        $resetUrl = route('reset-password', ['token' => $token]);

        try {
            // Send the email
            Mail::send('emails.password-reset', [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'token' => $token
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Reset Your Password - Sanskriti Bazar')
                        ->from(config('mail.from.address'), 'Sanskriti Bazar');
            });

            return back()->with('success', 'Reset link sent! Check your inbox and spam folder.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Password reset email failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to send reset email. Please try again or contact support.');
        }
    }

    // Show reset password form
    public function resetPasswordForm($token)
    {
        // Check if token exists and is not expired (24 hours)
        $resetRecord = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$resetRecord) {
            return redirect()->route('forgot-password')->with('error', 'Invalid or expired reset token.');
        }

        return view('reset-password', [
            'token' => $token,
            'email' => $resetRecord->email
        ]);
    }

    // Process password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Verify token
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Invalid or expired reset token.');
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Delete the reset token
            DB::table('password_resets')->where('email', $request->email)->delete();
            
            return redirect()->route('login')->with('success', 'Password reset successful! You can now login with your new password.');
        }

        return back()->with('error', 'Something went wrong. Please try again.');
    }
}
