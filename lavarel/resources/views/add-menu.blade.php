@extends('layout')

@section('title', 'Dodaj danie do menu')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Dodaj danie do menu</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data" id="add-menu-form">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nazwa dania *</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name') }}" placeholder="Np. Sałatka Cezar" required>
                            <div class="form-text">Minimum 3 znaki</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Opis *</label>
                            <textarea name="description" id="description" class="form-control" rows="4" 
                                      placeholder="Opisz składniki i sposób przygotowania..." required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 10 znaków</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label fw-semibold">Cena (zł) *</label>
                                    <input type="number" name="price" id="price" class="form-control" 
                                           step="0.01" min="0" max="1000" value="{{ old('price') }}" 
                                           placeholder="0.00" required>
                                    <div class="form-text">Maksymalnie 1000 zł</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Kategoria</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Wybierz kategorię</option>
                                        <option value="śniadanie" {{ old('category') == 'śniadanie' ? 'selected' : '' }}>Śniadanie</option>
                                        <option value="drugie śniadanie" {{ old('category') == 'drugie śniadanie' ? 'selected' : '' }}>Drugie śniadanie</option>
                                        <option value="obiad" {{ old('category') == 'obiad' ? 'selected' : '' }}>Obiad</option>
                                        <option value="podwieczorek" {{ old('category') == 'podwieczorek' ? 'selected' : '' }}>Podwieczorek</option>
                                        <option value="kolacja" {{ old('category') == 'kolacja' ? 'selected' : '' }}>Kolacja</option>
                                        <option value="przekąska" {{ old('category') == 'przekąska' ? 'selected' : '' }}>Przekąska</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DODANO: Sekcja wartości odżywczych -->
                        <div class="nutrition-section mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-chart-pie me-2"></i>Wartości odżywcze (na porcję)
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="calories" class="form-label">
                                            <i class="fas fa-fire text-danger me-1"></i>Kalorie (kcal)
                                        </label>
                                        <input type="number" name="calories" id="calories" class="form-control" 
                                               value="{{ old('calories') }}" min="0" max="2000" placeholder="350">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="protein" class="form-label">
                                            <i class="fas fa-drumstick-bite text-primary me-1"></i>Białko (g)
                                        </label>
                                        <input type="number" name="protein" id="protein" class="form-control" 
                                               value="{{ old('protein') }}" min="0" max="100" step="0.1" placeholder="25.5">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="carbs" class="form-label">
                                            <i class="fas fa-bread-slice text-warning me-1"></i>Węglowodany (g)
                                        </label>
                                        <input type="number" name="carbs" id="carbs" class="form-control" 
                                               value="{{ old('carbs') }}" min="0" max="200" step="0.1" placeholder="45.2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fat" class="form-label">
                                            <i class="fas fa-tint text-success me-1"></i>Tłuszcze (g)
                                        </label>
                                        <input type="number" name="fat" id="fat" class="form-control" 
                                               value="{{ old('fat') }}" min="0" max="100" step="0.1" placeholder="15.8">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fiber" class="form-label">
                                            <i class="fas fa-leaf text-info me-1"></i>Błonnik (g)
                                        </label>
                                        <input type="number" name="fiber" id="fiber" class="form-control" 
                                               value="{{ old('fiber') }}" min="0" max="50" step="0.1" placeholder="8.3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Zdjęcie dania *</label>
                            <input type="file" name="image" id="image" class="form-control" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif" required>
                            <div class="form-text">Wymagane. Formaty: JPG, PNG, GIF. Maksymalnie 2MB</div>
                            
                            <!-- Podgląd zdjęcia -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="" alt="Podgląd" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                <div class="mt-1">
                                    <small class="text-muted">Podgląd zdjęcia</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dopasowanie') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Anuluj
                            </a>
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <i class="fas fa-plus me-2"></i>Dodaj danie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 1.5px solid #e1e5e9;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }

    .card {
        border: none;
        border-radius: 15px;
    }

    .btn {
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* Style dla sekcji wartości odżywczych */
    .nutrition-section {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #dee2e6;
    }

    .nutrition-section h5 {
        margin-bottom: 20px;
        font-weight: 600;
    }

    .nutrition-section .form-control {
        border: 1.5px solid #ced4da;
        background: white;
    }

    .nutrition-section .form-control:focus {
        border-color: #007bff;
        background: white;
    }

    .nutrition-section .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }

    .nutrition-section .form-label i {
        font-size: 1.1rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    #image-preview {
        text-align: center;
        margin-top: 15px;
    }

    #preview-img {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuForm = document.getElementById('add-menu-form');
    const submitBtn = document.getElementById('submit-btn');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!allowedTypes.includes(file.type)) {
                showError(this, 'Dozwolone formaty: JPG, PNG, GIF');
                imagePreview.style.display = 'none';
                return;
            }
            
            if (file.size > maxSize) {
                showError(this, 'Plik nie może być większy niż 2MB');
                imagePreview.style.display = 'none';
                return;
            }
            
            clearError(this);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
    
    menuForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        const name = document.getElementById('name');
        if (name.value.trim().length < 3) {
            showError(name, 'Nazwa musi mieć co najmniej 3 znaki');
            isValid = false;
        } else {
            clearError(name);
        }
        
        const description = document.getElementById('description');
        if (description.value.trim().length < 10) {
            showError(description, 'Opis musi mieć co najmniej 10 znaków');
            isValid = false;
        } else {
            clearError(description);
        }
        
        const price = document.getElementById('price');
        const priceValue = parseFloat(price.value);
        if (isNaN(priceValue) || priceValue <= 0) {
            showError(price, 'Cena musi być liczbą większą od 0');
            isValid = false;
        } else if (priceValue > 1000) {
            showError(price, 'Cena nie może przekraczać 1000 zł');
            isValid = false;
        } else {
            clearError(price);
        }
        
        const image = document.getElementById('image');
        if (image.files.length === 0) {
            showError(image, 'Zdjęcie jest wymagane');
            isValid = false;
        } else {
            const file = image.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            const maxSize = 2 * 1024 * 1024;
            
            if (!allowedTypes.includes(file.type)) {
                showError(image, 'Dozwolone formaty: JPG, PNG, GIF');
                isValid = false;
            } else if (file.size > maxSize) {
                showError(image, 'Plik nie może być większy niż 2MB');
                isValid = false;
            } else {
                clearError(image);
            }
        }

        const calories = document.getElementById('calories');
        if (calories.value && (parseFloat(calories.value) < 0 || parseFloat(calories.value) > 2000)) {
            showError(calories, 'Kalorie muszą być między 0 a 2000 kcal');
            isValid = false;
        } else {
            clearError(calories);
        }

        const protein = document.getElementById('protein');
        if (protein.value && (parseFloat(protein.value) < 0 || parseFloat(protein.value) > 100)) {
            showError(protein, 'Białko musi być między 0 a 100g');
            isValid = false;
        } else {
            clearError(protein);
        }

        const carbs = document.getElementById('carbs');
        if (carbs.value && (parseFloat(carbs.value) < 0 || parseFloat(carbs.value) > 200)) {
            showError(carbs, 'Węglowodany muszą być między 0 a 200g');
            isValid = false;
        } else {
            clearError(carbs);
        }

        const fat = document.getElementById('fat');
        if (fat.value && (parseFloat(fat.value) < 0 || parseFloat(fat.value) > 100)) {
            showError(fat, 'Tłuszcze muszą być między 0 a 100g');
            isValid = false;
        } else {
            clearError(fat);
        }

        const fiber = document.getElementById('fiber');
        if (fiber.value && (parseFloat(fiber.value) < 0 || parseFloat(fiber.value) > 50)) {
            showError(fiber, 'Błonnik musi być między 0 a 50g');
            isValid = false;
        } else {
            clearError(fiber);
        }
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Sprawdź poprawność wypełnienia formularza', 'error');
        } else {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Dodawanie...';
            submitBtn.disabled = true;
        }
    });
    
    const price = document.getElementById('price');
    price.addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (isNaN(value) || value <= 0) {
            this.style.borderColor = '#dc3545';
        } else if (value > 1000) {
            this.style.borderColor = '#ffc107';
        } else {
            this.style.borderColor = '#28a745';
        }
    });
    
    const name = document.getElementById('name');
    name.addEventListener('input', function() {
        if (this.value.trim().length < 3) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#28a745';
        }
    });
    
    function showError(field, message) {
        field.classList.add('is-invalid');
        let errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }
    
    function clearError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container');
        container.insertBefore(notification, container.firstChild);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endsection