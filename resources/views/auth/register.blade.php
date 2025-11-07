@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">{{ __('Create Account') }}</h2>
            <p class="auth-subtitle">{{ __('Join us today') }}</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-input @error('name') form-input-error @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                    @error('name')
                        <span class="form-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-input @error('email') form-input-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                    @error('email')
                        <span class="form-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="password-wrapper">
                        <input id="password" type="password" class="form-input @error('password') form-input-error @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="eye-icon" id="eye-icon-password">👁️</i>
                        </button>
                    </div>
                    @error('password')
                        <span class="form-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <div class="password-wrapper">
                        <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirm')">
                            <i class="eye-icon" id="eye-icon-confirm">👁️</i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('Register') }}
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="auth-link">{{ __('Login here') }}</a></p>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-icon-' + (fieldId === 'password' ? 'password' : 'confirm'));
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
