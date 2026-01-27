@extends('frontend.layouts.app')

@section('content')

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">Create Account</h2>
        <p class="auth-subtitle">Register for a new account</p>
      </div>

      <form method="POST" action="{{ route('frontend.register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
          <label for="name" class="form-label">Full Name</label>
          <input 
            id="name" 
            type="text" 
            class="form-input @error('name') is-invalid @enderror" 
            name="name" 
            value="{{ old('name') }}" 
            required 
            autofocus
            placeholder="Enter your full name"
          >
          @error('name')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

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

        <!-- Confirm Password -->
        <div class="form-group">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input 
            id="password_confirmation" 
            type="password" 
            class="form-input" 
            name="password_confirmation" 
            required
            placeholder="Confirm your password"
          >
        </div>

        <!-- Submit Button -->
        <div class="form-group">
          <button type="submit" class="btn-auth btn-primary-auth">
            Register
          </button>
        </div>

        <!-- Links -->
        <div class="auth-links">
          <span>Already have an account?</span>
          <a href="{{ route('frontend.login') }}" class="auth-link">Login Here</a>
        </div>
      </form>
    </div>
  </div>
</section>

@endsection
