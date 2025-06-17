@extends('layout')

@section('title', 'Edytuj profil')

@push('styles')
<style>
    .image-management {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin: 20px 0;
        border: 2px dashed #dee2e6;
    }
    
    .current-image {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .current-image img {
        max-width: 150px;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .remove-image-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    
    .remove-image-btn:hover {
        background: #c82333;
        transform: scale(1.1);
    }
    
    .btn-remove-image {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-remove-image:hover {
        background: #c82333;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            <i class="fas fa-user-edit me-2 text-primary"></i>
            Edytuj swój profil
        </h1>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Powrót do dashboardu
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user me-2"></i>
                Informacje o profilu
            </h5>
        </div>
        <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i>Imię i nazwisko *
                            </label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email *
                            </label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Nowe hasło (opcjonalne)
                            </label>
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="form-text">Pozostaw puste, jeśli nie chcesz zmieniać hasła</div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i>Potwierdź nowe hasło
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="image-management text-center">
                            <h5>
                                <i class="fas fa-user-circle me-2"></i>Zdjęcie profilowe
                            </h5>
                            
                            @if(auth()->user()->avatar)
                                <div class="current-image" id="current-avatar">
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                         alt="Avatar" 
                                         class="img-fluid"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                    <button type="button" class="remove-image-btn" 
                                            onclick="removeCurrentAvatar()" 
                                            title="Usuń avatar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeCurrentAvatar()">
                                        <i class="fas fa-trash me-1"></i>Usuń avatar
                                    </button>
                                </div>
                                
                                <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                                <hr class="my-3">
                                <small class="text-muted">Lub wybierz nowe zdjęcie:</small>
                            @else
                                <div class="mb-3">
                                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white"
                                         style="width: 150px; height: 150px; font-size: 3rem;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-3">
                                <label for="avatar" class="form-label">
                                    {{ auth()->user()->avatar ? 'Zmień avatar' : 'Dodaj avatar' }}
                                </label>
                                <input type="file" name="avatar" id="avatar" class="form-control" 
                                       accept="image/*">
                                <div class="form-text">Formaty: JPG, PNG. Max 2MB</div>
                                @error('avatar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="new-avatar-preview" style="display: none;" class="mt-3">
                                <small class="text-muted">Podgląd nowego avatara:</small>
                                <img id="preview-avatar" class="img-fluid mt-2 rounded-circle" 
                                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-1"></i>Anuluj
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Zapisz zmiany
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function removeCurrentAvatar() {
    const currentAvatar = document.getElementById('current-avatar');
    const removeInput = document.getElementById('remove_avatar');
    const avatarInput = document.getElementById('avatar');
    
    if (confirm('Czy na pewno chcesz usunąć swój avatar?')) {
        if (currentAvatar) {
            currentAvatar.style.display = 'none';
        }
        
        removeInput.value = '1';
        
        if (avatarInput) {
            avatarInput.value = '';
        }
        
        const existingAlert = document.querySelector('.image-management .alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        const imageManagement = document.querySelector('.image-management');
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning mt-3';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Avatar zostanie usunięty po zapisaniu zmian.';
        imageManagement.appendChild(alertDiv);
        
        console.log('Avatar marked for removal, remove_avatar value:', removeInput.value);
    }
}

document.getElementById('avatar').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('new-avatar-preview');
    const previewImg = document.getElementById('preview-avatar');
    const removeInput = document.getElementById('remove_avatar');
    
    if (file) {
        removeInput.value = '0';
        
        const currentAvatar = document.getElementById('current-avatar');
        if (currentAvatar) {
            currentAvatar.style.display = 'block';
        }
        
        const warningAlert = document.querySelector('.image-management .alert-warning');
        if (warningAlert) {
            warningAlert.remove();
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    const removeInput = document.getElementById('remove_avatar');
    console.log('Form submitted with remove_avatar value:', removeInput.value);
    
    const formData = new FormData(this);
    console.log('FormData contents:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
});
</script>
@endsection