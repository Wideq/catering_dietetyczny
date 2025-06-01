@extends('layout')

@section('title', 'Logowanie - PureMeal')

@push('styles')
<style>
    .login-container {
        background-color: var(--secondary-color);
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        padding: 40px;
        width: 100%;
        max-width: 550px;
        margin: 50px auto;
        transition: all 0.3s ease;
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
    }

    .form-control:focus {
        border-color: var(--accent-color);
        outline: none;
        box-shadow: 0 0 8px rgba(243, 156, 18, 0.3);
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

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
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
</style>
@endpush

@section('content')
<div class="login-container animate__animated animate__fadeIn">
    <h2 class="login-title">Zaloguj się</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   name="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   placeholder="Wprowadź swój email" 
                   value="{{ old('email') }}"
                   required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" 
                   name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   placeholder="Wprowadź hasło" 
                   required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-login">Zaloguj się</button>
    </form>

    <div class="login-footer">
        Nie masz konta? <a href="{{ url('/register') }}">Zarejestruj się</a>
    </div>
</div>
@endsection