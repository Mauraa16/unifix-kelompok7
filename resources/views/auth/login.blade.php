@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">{{ __('Welcome Back') }}</h2>
            <p class="auth-subtitle">{{ __('Sign in to your account') }}</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-input @error('email') form-input-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                    @error('email')
                        <span class="form-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="password-wrapper">
                        <input id="password" type="password" class="form-input @error('password') form-input-error @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="eye-icon" id="eye-icon">👁️</i>
                        </button>
                    </div>
                    @error('password')
                        <span class="form-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group form-check-group">
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-check-label">{{ __('Remember Me') }}</span>
                    </label>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <div class="auth-links">
                        <a href="{{ route('password.request') }}" class="auth-link">{{ __('Forgot Your Password?') }}</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="auth-footer">
            <p>{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}" class="auth-link">{{ __('Register here') }}</a></p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
    }
}
</script>
@endsection
