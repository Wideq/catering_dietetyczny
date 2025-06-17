@extends('layout')

@section('title', 'Edytuj danie')

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
        max-width: 200px;
        border-radius: 8px;
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
    
    .image-actions {
        display: flex;
        gap: 10px;
        align-items: center;
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
    <h1 class="mb-4">Edytuj danie: {{ $menu->name }}</h1>

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" id="editMenuForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="name" class="form-label">Nazwa dania *</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $menu->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Opis *</label>
                    <textarea name="description" id="description" class="form-control" 
                              rows="4" required>{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Cena (zł) *</label>
                            <input type="number" name="price" id="price" class="form-control" 
                                   value="{{ old('price', $menu->price) }}" min="0" step="0.01" required>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategoria *</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Wybierz kategorię</option>
                                @foreach(['śniadanie', 'drugie śniadanie', 'obiad', 'podwieczorek', 'kolacja', 'przekąska'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $menu->category) == $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="image-management">
                    <h5>
                        <i class="fas fa-image me-2"></i>Zdjęcie dania
                    </h5>
                    
                    @if($menu->image)
                        <div class="current-image" id="current-image">
                            <img src="{{ asset('storage/' . $menu->image) }}" 
                                 alt="{{ $menu->name }}" 
                                 class="img-fluid">
                            <button type="button" class="remove-image-btn" 
                                    onclick="removeCurrentImage()" 
                                    title="Usuń zdjęcie">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="image-actions">
                            <button type="button" class="btn-remove-image" onclick="removeCurrentImage()">
                                <i class="fas fa-trash me-1"></i>Usuń zdjęcie
                            </button>
                        </div>
                        
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                        
                        <hr class="my-3">
                        <small class="text-muted">Lub wybierz nowe zdjęcie:</small>
                    @endif
                    
                    <div class="mt-3">
                        <label for="image" class="form-label">
                            {{ $menu->image ? 'Zmień zdjęcie' : 'Dodaj zdjęcie' }}
                        </label>
                        <input type="file" name="image" id="image" class="form-control" 
                               accept="image/*">
                        <div class="form-text">Formaty: JPG, PNG, GIF. Max 2MB</div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="new-image-preview" style="display: none;" class="mt-3">
                        <small class="text-muted">Podgląd nowego zdjęcia:</small>
                        <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; border-radius: 8px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="nutrition-section">
            <h5><i class="fas fa-chart-pie me-2"></i>Wartości odżywcze (na porcję)</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="calories" class="form-label">
                            <i class="fas fa-fire text-danger me-1"></i>Kalorie (kcal)
                        </label>
                        <input type="number" name="calories" id="calories" class="form-control" 
                               value="{{ old('calories', $menu->calories) }}" min="0" max="2000" step="1" placeholder="450">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="protein" class="form-label">
                            <i class="fas fa-drumstick-bite text-primary me-1"></i>Białko (g)
                        </label>
                        <input type="number" name="protein" id="protein" class="form-control" 
                               value="{{ old('protein', $menu->protein) }}" min="0" max="100" step="0.1" placeholder="25.5">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="carbs" class="form-label">
                            <i class="fas fa-bread-slice text-warning me-1"></i>Węglowodany (g)
                        </label>
                        <input type="number" name="carbs" id="carbs" class="form-control" 
                               value="{{ old('carbs', $menu->carbs) }}" min="0" max="200" step="0.1" placeholder="45.2">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="fat" class="form-label">
                            <i class="fas fa-tint text-success me-1"></i>Tłuszcze (g)
                        </label>
                        <input type="number" name="fat" id="fat" class="form-control" 
                               value="{{ old('fat', $menu->fat) }}" min="0" max="100" step="0.1" placeholder="15.8">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('dopasowanie') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Powrót
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save me-1"></i>Zapisz zmiany
            </button>
        </div>
    </form>
</div>

<script>
function removeCurrentImage() {
    const currentImage = document.getElementById('current-image');
    const removeInput = document.getElementById('remove_image');
    
    if (confirm('Czy na pewno chcesz usunąć to zdjęcie?')) {
        currentImage.style.display = 'none';
        removeInput.value = '1';
        
        const imageManagement = document.querySelector('.image-management');
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Zdjęcie zostanie usunięte po zapisaniu zmian.';
        imageManagement.insertBefore(alertDiv, imageManagement.firstChild);
    }
}

document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('new-image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
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

document.getElementById('editMenuForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Zapisywanie...';
    submitBtn.disabled = true;
});
</script>
@endsection