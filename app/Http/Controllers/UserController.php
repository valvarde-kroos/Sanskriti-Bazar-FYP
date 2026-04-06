<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        ]);

        Auth::login($user);
        
        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
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
}
