@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="signup-card">
        <!-- LEFT SECTION -->
        <div class="signup-left">
            <h1>Welcome!</h1>
            <p>Create your account and start your journey with us.</p>
        </div>

        <!-- RIGHT SECTION -->
        <div class="signup-right">
            <h2>Create Account</h2>

            @if(session('success'))
                <p class="success-msg">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}">
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter email" value="{{ old('email') }}">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                    
                    </select>
                    @error('role')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password">
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm password">
                </div>

                <button type="submit" class="signup-submit">Sign Up</button>
            </form>

            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
</div>
@endsection
