@extends('layout')

@section('title', 'Dodaj nową dietę - PureMeal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .form-container {
        max-width: 800px;
        margin: 50px auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .form-title {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
    }
    
    .form-control {
        border-radius: 5px;
        padding: 12px;
        border: 1px solid #ddd;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.2rem rgba(136, 136, 136, 0.25);
    }
    
    textarea.form-control {
        min-height: 120px;
    }
    
    .btn-submit {
        background-color: var(--accent);
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .btn-submit:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 5px;
        margin-right: 10px;
        display: inline-block;
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .icon-preview {
        font-size: 2rem;
        margin-top: 10px;
        color: var(--accent);
    }
    
    .icon-options {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-top: 15px;
    }
    
    .icon-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        padding: 10px;
        border-radius: 5px;
        transition: all 0.2s;
    }
    
    .icon-option:hover {
        background-color: #f5f5f5;
    }
    
    .icon-option.selected {
        background-color: #e9ecef;
        border: 2px solid var(--accent);
    }
    
    .icon-option i {
        font-size: 1.5rem;
        margin-bottom: 5px;
        color: var(--primary-color);
    }
    
    .icon-option span {
        font-size: 0.8rem;
        color: var(--gray-medium);
        text-align: center;
    }
    
    .image-preview {
        width: 100%;
        height: 200px;
        border: 2px dashed #ddd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
        overflow: hidden;
    }
    
    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .image-placeholder {
        color: #aaa;
        font-size: 1rem;
    }
    
    .form-check-input:checked {
        background-color: var(--accent);
        border-color: var(--accent);
    }
    .form-check {
        display: flex;
        align-items: center;
        padding: 10px 0;
    }
    
    .form-check-input {
        width: 20px !important;
        height: 20px !important;
        margin-right: 10px !important;
        position: relative !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        cursor: pointer;
        border: 1px solid #aaa;
        border-radius: 4px;
        appearance: auto !important;
        -webkit-appearance: auto !important;
    }
    
    .form-check-input:checked {
        background-color: var(--accent) !important;
        border-color: var(--accent) !important;
    }
    
    .form-check-label {
        margin-left: 5px;
        cursor: pointer;
        user-select: none;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="form-container">
        <h1 class="form-title">Dodaj nową dietę</h1>
        
        <form action="{{ route('diet-plans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Nazwa diety</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Opis diety</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price_per_day" class="form-label">Cena za dzień (PLN)</label>
                <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" id="price_per_day" name="price_per_day" min="0" step="0.01" value="{{ old('price_per_day') }}" required>
                @error('price_per_day')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="icon" class="form-label">Ikona diety</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', 'fa-utensils') }}">
                <div class="icon-preview mt-2">
                    <i id="iconPreview" class="fas fa-utensils"></i>
                </div>
                <div class="icon-options">
                    <div class="icon-option selected" data-icon="fa-utensils">
                        <i class="fas fa-utensils"></i>
                        <span>Sztućce</span>
                    </div>
                    <div class="icon-option" data-icon="fa-carrot">
                        <i class="fas fa-carrot"></i>
                        <span>Marchew</span>
                    </div>
                    <div class="icon-option" data-icon="fa-apple-alt">
                        <i class="fas fa-apple-alt"></i>
                        <span>Jabłko</span>
                    </div>
                    <div class="icon-option" data-icon="fa-leaf">
                        <i class="fas fa-leaf"></i>
                        <span>Liść</span>
                    </div>
                    <div class="icon-option" data-icon="fa-seedling">
                        <i class="fas fa-seedling"></i>
                        <span>Roślina</span>
                    </div>
                    <div class="icon-option" data-icon="fa-dumbbell">
                        <i class="fas fa-dumbbell"></i>
                        <span>Hantle</span>
                    </div>
                    <div class="icon-option" data-icon="fa-fish">
                        <i class="fas fa-fish"></i>
                        <span>Ryba</span>
                    </div>
                    <div class="icon-option" data-icon="fa-egg">
                        <i class="fas fa-egg"></i>
                        <span>Jajko</span>
                    </div>
                    <div class="icon-option" data-icon="fa-cheese">
                        <i class="fas fa-cheese"></i>
                        <span>Ser</span>
                    </div>
                    <div class="icon-option" data-icon="fa-drumstick-bite">
                        <i class="fas fa-drumstick-bite"></i>
                        <span>Mięso</span>
                    </div>
                    <div class="icon-option" data-icon="fa-heartbeat">
                        <i class="fas fa-heartbeat"></i>
                        <span>Zdrowie</span>
                    </div>
                    <div class="icon-option" data-icon="fa-fire-alt">
                        <i class="fas fa-fire-alt"></i>
                        <span>Kalorie</span>
                    </div>
                </div>
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image" class="form-label">Zdjęcie diety (opcjonalne)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                <div class="image-preview" id="imagePreview">
                    <span class="image-placeholder">Podgląd zdjęcia będzie tutaj</span>
                </div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">
            Dieta aktywna (widoczna dla klientów)
        </label>
    </div>
</div>
            
            <div class="mt-4" style="margin-top: 30px; display: flex; gap: 10px;">
    <a href="{{ route('diet-plans.index') }}" class="btn-back" style="background-color: #6c757d; color: white; text-decoration: none; padding: 12px 25px; border-radius: 5px; display: inline-block;">Powrót</a>
    <button type="submit" class="btn-submit" style="background-color: #27ae60; color: white; border: none; padding: 12px 30px; border-radius: 5px; cursor: pointer; font-weight: 600;">Dodaj dietę</button>
</div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obsługa wyboru ikony
        const iconOptions = document.querySelectorAll('.icon-option');
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');
        
        iconOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Usuń klasę selected ze wszystkich opcji
                iconOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Dodaj klasę selected do klikniętej opcji
                this.classList.add('selected');
                
                // Pobierz wartość ikony
                const iconValue = this.getAttribute('data-icon');
                
                // Aktualizuj pole formularza
                iconInput.value = iconValue;
                
                // Aktualizuj podgląd
                iconPreview.className = 'fas ' + iconValue;
            });
        });
        
        // Obsługa podglądu obrazu
        const imageInput = document.getElementById('image');
        const imagePreviewContainer = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            while(imagePreviewContainer.firstChild) {
                imagePreviewContainer.removeChild(imagePreviewContainer.firstChild);
            }
            
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreviewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            } else {
                const placeholder = document.createElement('span');
                placeholder.className = 'image-placeholder';
                placeholder.innerText = 'Podgląd zdjęcia będzie tutaj';
                imagePreviewContainer.appendChild(placeholder);
            }
        });
    });
</script>
@endpush