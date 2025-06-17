@extends('layout')

@section('title', 'Rejestracja - PureMeal')

@push('styles')
<style>
    :root {
        --primary-color: #333;
        --secondary-color: #fff;
        --accent-color: #f39c12;
        --background-color: #f5f5f5;
        --font-family: 'Roboto', sans-serif;
    }

    /* Override body styles since we're using layout */
    body {
        background-color: var(--background-color) !important;
        color: var(--primary-color);
        font-family: var(--font-family);
    }

    /* Main content area styles */
    .register-main {
        background-color: var(--background-color);
        min-height: calc(100vh - 120px); /* Adjust for header/footer */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 0;
    }

    .login-container {
        background-color: var(--secondary-color);
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        padding: 40px;
        width: 100%;
        max-width: 550px;
        transition: all 0.3s ease;
        margin: 20px;
    }

    .login-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
    }

    .login-title {
        text-align: center;
        margin-bottom: 35px;
        color: var(--primary-color);
        font-weight: 700;
        font-size: 2.5rem;
        letter-spacing: 1px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        display: block;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid #ddd;
        padding: 14px;
        font-size: 1.1rem;
        width: 100%;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        outline: none;
        box-shadow: 0 0 8px rgba(243, 156, 18, 0.3);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .btn-login {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        border: none;
        padding: 14px 30px;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-size: 1.2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-login:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .login-footer {
        margin-top: 30px;
        text-align: center;
        color: #777;
        font-size: 1.1rem;
    }

    .login-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .login-footer a:hover {
        color: var(--accent-color);
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        font-weight: 500;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }

    .alert-success {
        background-color: #d1edff;
        color: #0c5460;
        border: 1px solid #b6effb;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .register-main {
            padding: 20px 0;
            min-height: calc(100vh - 100px);
        }
        
        .login-container {
            margin: 10px;
            padding: 30px 20px;
        }
        
        .login-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<main class="register-main">
    <div class="login-container animate__animated animate__fadeIn" data-aos="fade-up" data-aos-duration="800">
        <h2 class="login-title">Zarejestruj się</h2>

        {{-- Wyświetlanie błędów walidacji --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Wyświetlanie komunikatów sukcesu --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-2"></i>Imię i nazwisko
                </label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       placeholder="Wprowadź swoje imię i nazwisko" 
                       value="{{ old('name') }}"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2"></i>Email
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       placeholder="Wprowadź swój email" 
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>Hasło
                </label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Wprowadź hasło (min. 8 znaków)" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock me-2"></i>Potwierdzenie hasła
                </label>
                <input type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Potwierdź swoje hasło" 
                       required>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-user-plus me-2"></i>Zarejestruj się
            </button>
        </form>

        <div class="login-footer">
            Masz już konto? 
            <a href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt me-1"></i>Zaloguj się
            </a>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }

    const form = document.getElementById('registerForm');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Walidacja nazwy użytkownika
        const name = document.getElementById('name');
        if (name.value.trim().length < 2) {
            showError(name, 'Imię musi mieć co najmniej 2 znaki');
            isValid = false;
        } else {
            clearError(name);
        }
        
        // Walidacja email
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            showError(email, 'Wprowadź poprawny adres email');
            isValid = false;
        } else {
            clearError(email);
        }
        
        // Walidacja hasła
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (password.value.length < 8) {
            showError(password, 'Hasło musi mieć co najmniej 8 znaków');
            isValid = false;
        } else {
            clearError(password);
        }
        
        if (password.value !== passwordConfirm.value) {
            showError(passwordConfirm, 'Hasła nie są identyczne');
            isValid = false;
        } else {
            clearError(passwordConfirm);
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    function showError(field, message) {
        field.classList.add('is-invalid');
        let errorDiv = field.parentNode.querySelector('.invalid-feedback.js-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback js-error';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }
    
    function clearError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback.js-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    // Real-time validation
    const inputs = ['name', 'email', 'password', 'password_confirmation'];
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        input.addEventListener('blur', function() {
            // Clear previous JS errors on blur
            clearError(this);
        });
    });
});
</script>
@endpush