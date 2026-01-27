@extends('frontend.layouts.app')

@section('content')

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Login to your account</p>
      </div>

      <form method="POST" action="{{ route('frontend.login') }}" class="auth-form">
        @csrf

        <!-- Email -->
        <div class="form-group">
          <label for="email" class="form-label">Email Address</label>
          <input 
            id="email" 
            type="email" 
            class="form-input @error('email') is-invalid @enderror" 
            name="email" 
            value="{{ old('email') }}" 
            required 
            autofocus
            placeholder="Enter your email"
          >
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input 
            id="password" 
            type="password" 
            class="form-input @error('password') is-invalid @enderror" 
            name="password" 
            required
            placeholder="Enter your password"
          >
          @error('password')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group-checkbox">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Remember Me</span>
          </label>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
          <button type="submit" class="btn-auth btn-primary-auth">
            Login
          </button>
        </div>

        <!-- Links -->
        <div class="auth-links">
          <a href="{{ route('frontend.password.request') }}" class="auth-link">Forgot Password?</a>
          <span class="auth-separator">•</span>
          <a href="{{ route('frontend.register') }}" class="auth-link">Create Account</a>
        </div>
      </form>
    </div>
  </div>
</section>

@endsection
