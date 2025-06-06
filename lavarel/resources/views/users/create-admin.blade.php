@extends('layout')

@section('title', 'Dodaj użytkownika')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Dodaj nowego użytkownika
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store-admin') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user text-primary me-1"></i>
                                    Imię i nazwisko <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="Wprowadź imię i nazwisko">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope text-primary me-1"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="user@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag text-primary me-1"></i>
                                Rola <span class="text-danger">*</span>
                            </label>
                            <select name="role" 
                                    id="role" 
                                    class="form-select @error('role') is-invalid @enderror" 
                                    required>
                                <option value="">Wybierz rolę użytkownika</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                    Użytkownik (dostęp do koszyka i zamówień)
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Administrator (pełen dostęp do systemu)
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock text-primary me-1"></i>
                                    Hasło <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       required
                                       minlength="8"
                                       placeholder="Minimum 8 znaków">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Hasło musi mieć minimum 8 znaków</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock text-primary me-1"></i>
                                    Potwierdź hasło <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control" 
                                       required
                                       minlength="8"
                                       placeholder="Powtórz hasło">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="avatar" class="form-label">
                                <i class="fas fa-camera text-primary me-1"></i>
                                Zdjęcie profilowe (opcjonalne)
                            </label>
                            <input type="file" 
                                   name="avatar" 
                                   id="avatar" 
                                   class="form-control @error('avatar') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Akceptowane formaty: JPG, PNG, GIF. Maksymalny rozmiar: 2MB
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Anuluj
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Utwórz użytkownika
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Podgląd avatara
    const avatarInput = document.getElementById('avatar');
    
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Utwórz podgląd zdjęcia
                let preview = document.querySelector('.avatar-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.className = 'avatar-preview mt-2';
                    avatarInput.parentNode.appendChild(preview);
                }
                preview.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Podgląd avatara" 
                         class="rounded-circle" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="form-text">Podgląd zdjęcia profilowego</div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Walidacja hasła
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Hasła nie są identyczne');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePasswords);
    passwordConfirm.addEventListener('input', validatePasswords);
});
</script>
@endpush
@endsection