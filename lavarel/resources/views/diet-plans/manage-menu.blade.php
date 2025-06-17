@extends('layout')

@section('title', 'Zarządzanie posiłkami diety - PureMeal')

@push('styles')
<style>
    .menu-container {
        max-width: 1000px;
        margin: 50px auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .menu-title {
        text-align: center;
        margin-bottom: 10px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .menu-subtitle {
        text-align: center;
        color: var(--accent);
        margin-bottom: 30px;
        font-weight: 500;
    }
    
    .price-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        border: 2px solid #e9ecef;
    }
    
    .price-calculation {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .price-item {
        text-align: center;
        padding: 10px;
        background: white;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .price-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .price-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }
    
    .total-price {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 700;
        color: #28a745;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 2px solid #28a745;
    }
    
    .menu-search {
        margin-bottom: 20px;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }
    
    .menu-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
        justify-content: center;
    }
    
    .filter-btn {
        padding: 8px 16px;
        border: 2px solid #dee2e6;
        background: white;
        color: #495057;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .filter-btn:hover {
        border-color: #007bff;
        color: #007bff;
    }
    
    .filter-btn.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }
    
    .meal-category {
        font-size: 1.3rem;
        font-weight: 600;
        color: #495057;
        margin: 30px 0 15px 0;
        padding: 10px 0;
        border-bottom: 2px solid #007bff;
    }
    
    .menu-items-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .menu-item {
        display: flex;
        align-items: flex-start;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .menu-item:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,123,255,0.1);
    }
    
    .menu-item.selected {
        border-color: #28a745;
        background: #f8fff9;
    }
    
    .form-check-input {
        margin-top: 5px;
        transform: scale(1.2);
    }
    
    .menu-item-details {
        margin-left: 12px;
        flex: 1;
    }
    
    .menu-item-name {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .menu-item-price {
        font-size: 0.9rem;
        color: #007bff;
        font-weight: 700;
    }
    
    .menu-item-description {
        font-size: 0.85rem;
        color: #6c757d;
        line-height: 1.4;
        margin-bottom: 8px;
    }
    
    .menu-item-macros {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .macro {
        font-size: 0.75rem;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
        color: #495057;
    }
    
    .macro-value {
        font-weight: 600;
        color: #007bff;
    }
    
    .menu-submit {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e9ecef;
    }
    
    .btn-back {
        padding: 12px 24px;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }
    
    .btn-submit {
        padding: 12px 30px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        background: #218838;
    }
    
    .btn-submit:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }
    
    /* Validation styles */
    .validation-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 10px;
        padding: 10px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
    }
    
    .validation-warning {
        color: #856404;
        font-size: 0.875rem;
        margin-top: 10px;
        padding: 10px;
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 5px;
    }
    
    @media (max-width: 768px) {
        .menu-container {
            margin: 20px;
            padding: 20px;
        }
        
        .menu-items-container {
            grid-template-columns: 1fr;
        }
        
        .price-calculation {
            grid-template-columns: 1fr;
        }
        
        .menu-submit {
            flex-direction: column;
            gap: 15px;
        }
        
        .btn-back, .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="menu-container">
        <h1 class="menu-title">Zarządzanie posiłkami diety</h1>
        <h2 class="menu-subtitle">{{ $dietPlan->name }}</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="price-summary">
            <h3>Kalkulacja ceny dziennej</h3>
            <div class="price-calculation">
                <div class="price-item">
                    <div class="price-label">Suma posiłków</div>
                    <div class="price-value" id="meals-price">{{ number_format($totalMealsPrice, 2) }} zł</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Rabat</div>
                    <div class="price-value" id="discount-price">{{ number_format($discount, 2) }} zł</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Cena bazowa</div>
                    <div class="price-value" id="base-price">{{ number_format($dietPlan->price_per_day, 2) }} zł</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Liczba posiłków</div>
                    <div class="price-value" id="meals-count">{{ count($selectedMenuItems) }}</div>
                </div>
            </div>
            <div class="total-price" id="total-price">
                Cena końcowa: {{ number_format($dietPlan->price_per_day, 2) }} zł / dzień
            </div>
        </div>
        
        <div class="menu-search">
            <input type="text" id="searchInput" class="search-input" placeholder="Szukaj posiłków...">
        </div>
        
        <div class="menu-filter">
            <button type="button" class="filter-btn active" data-filter="all">Wszystkie</button>
            <button type="button" class="filter-btn" data-filter="śniadanie">Śniadania</button>
            <button type="button" class="filter-btn" data-filter="drugie śniadanie">Drugie śniadania</button>
            <button type="button" class="filter-btn" data-filter="obiad">Obiady</button>
            <button type="button" class="filter-btn" data-filter="podwieczorek">Podwieczorki</button>
            <button type="button" class="filter-btn" data-filter="kolacja">Kolacje</button>
        </div>
        
        <form action="{{ route('diet-plans.update-menu', $dietPlan->id) }}" method="POST" id="menu-form">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="price_per_day" id="final_price" value="{{ $dietPlan->price_per_day }}">
            
            <div id="validation-messages"></div>
            
            <h3 class="meal-category">Śniadania</h3>
            <div class="menu-items-container">
                @foreach($menuItems->where('category', 'śniadanie') as $menuItem)
                    <div class="form-check menu-item" data-category="śniadanie" data-price="{{ $menuItem->price }}">
                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_items[]" id="menuItem{{ $menuItem->id }}" value="{{ $menuItem->id }}" {{ in_array($menuItem->id, $selectedMenuItems) ? 'checked' : '' }}>
                        <div class="menu-item-details">
                            <div class="menu-item-name">
                                {{ $menuItem->name }}
                                <span class="menu-item-price">{{ number_format($menuItem->price, 2) }} zł</span>
                            </div>
                            <div class="menu-item-description">{{ Str::limit($menuItem->description, 100) }}</div>
                            <div class="menu-item-macros">
                                <span class="macro">Kalorie: <span class="macro-value">{{ $menuItem->calories ?? 0 }}</span> kcal</span>
                                <span class="macro">Białko: <span class="macro-value">{{ $menuItem->protein ?? 0 }}</span> g</span>
                                <span class="macro">Węgl.: <span class="macro-value">{{ $menuItem->carbs ?? 0 }}</span> g</span>
                                <span class="macro">Tłuszcze: <span class="macro-value">{{ $menuItem->fat ?? 0 }}</span> g</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h3 class="meal-category">Drugie śniadania</h3>
            <div class="menu-items-container">
                @foreach($menuItems->where('category', 'drugie śniadanie') as $menuItem)
                    <div class="form-check menu-item" data-category="drugie śniadanie" data-price="{{ $menuItem->price }}">
                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_items[]" id="menuItem{{ $menuItem->id }}" value="{{ $menuItem->id }}" {{ in_array($menuItem->id, $selectedMenuItems) ? 'checked' : '' }}>
                        <div class="menu-item-details">
                            <div class="menu-item-name">
                                {{ $menuItem->name }}
                                <span class="menu-item-price">{{ number_format($menuItem->price, 2) }} zł</span>
                            </div>
                            <div class="menu-item-description">{{ Str::limit($menuItem->description, 100) }}</div>
                            <div class="menu-item-macros">
                                <span class="macro">Kalorie: <span class="macro-value">{{ $menuItem->calories ?? 0 }}</span> kcal</span>
                                <span class="macro">Białko: <span class="macro-value">{{ $menuItem->protein ?? 0 }}</span> g</span>
                                <span class="macro">Węgl.: <span class="macro-value">{{ $menuItem->carbs ?? 0 }}</span> g</span>
                                <span class="macro">Tłuszcze: <span class="macro-value">{{ $menuItem->fat ?? 0 }}</span> g</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h3 class="meal-category">Obiady</h3>
            <div class="menu-items-container">
                @foreach($menuItems->where('category', 'obiad') as $menuItem)
                    <div class="form-check menu-item" data-category="obiad" data-price="{{ $menuItem->price }}">
                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_items[]" id="menuItem{{ $menuItem->id }}" value="{{ $menuItem->id }}" {{ in_array($menuItem->id, $selectedMenuItems) ? 'checked' : '' }}>
                        <div class="menu-item-details">
                            <div class="menu-item-name">
                                {{ $menuItem->name }}
                                <span class="menu-item-price">{{ number_format($menuItem->price, 2) }} zł</span>
                            </div>
                            <div class="menu-item-description">{{ Str::limit($menuItem->description, 100) }}</div>
                            <div class="menu-item-macros">
                                <span class="macro">Kalorie: <span class="macro-value">{{ $menuItem->calories ?? 0 }}</span> kcal</span>
                                <span class="macro">Białko: <span class="macro-value">{{ $menuItem->protein ?? 0 }}</span> g</span>
                                <span class="macro">Węgl.: <span class="macro-value">{{ $menuItem->carbs ?? 0 }}</span> g</span>
                                <span class="macro">Tłuszcze: <span class="macro-value">{{ $menuItem->fat ?? 0 }}</span> g</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h3 class="meal-category">Podwieczorki</h3>
            <div class="menu-items-container">
                @foreach($menuItems->where('category', 'podwieczorek') as $menuItem)
                    <div class="form-check menu-item" data-category="podwieczorek" data-price="{{ $menuItem->price }}">
                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_items[]" id="menuItem{{ $menuItem->id }}" value="{{ $menuItem->id }}" {{ in_array($menuItem->id, $selectedMenuItems) ? 'checked' : '' }}>
                        <div class="menu-item-details">
                            <div class="menu-item-name">
                                {{ $menuItem->name }}
                                <span class="menu-item-price">{{ number_format($menuItem->price, 2) }} zł</span>
                            </div>
                            <div class="menu-item-description">{{ Str::limit($menuItem->description, 100) }}</div>
                            <div class="menu-item-macros">
                                <span class="macro">Kalorie: <span class="macro-value">{{ $menuItem->calories ?? 0 }}</span> kcal</span>
                                <span class="macro">Białko: <span class="macro-value">{{ $menuItem->protein ?? 0 }}</span> g</span>
                                <span class="macro">Węgl.: <span class="macro-value">{{ $menuItem->carbs ?? 0 }}</span> g</span>
                                <span class="macro">Tłuszcze: <span class="macro-value">{{ $menuItem->fat ?? 0 }}</span> g</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h3 class="meal-category">Kolacje</h3>
            <div class="menu-items-container">
                @foreach($menuItems->where('category', 'kolacja') as $menuItem)
                    <div class="form-check menu-item" data-category="kolacja" data-price="{{ $menuItem->price }}">
                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_items[]" id="menuItem{{ $menuItem->id }}" value="{{ $menuItem->id }}" {{ in_array($menuItem->id, $selectedMenuItems) ? 'checked' : '' }}>
                        <div class="menu-item-details">
                            <div class="menu-item-name">
                                {{ $menuItem->name }}
                                <span class="menu-item-price">{{ number_format($menuItem->price, 2) }} zł</span>
                            </div>
                            <div class="menu-item-description">{{ Str::limit($menuItem->description, 100) }}</div>
                            <div class="menu-item-macros">
                                <span class="macro">Kalorie: <span class="macro-value">{{ $menuItem->calories ?? 0 }}</span> kcal</span>
                                <span class="macro">Białko: <span class="macro-value">{{ $menuItem->protein ?? 0 }}</span> g</span>
                                <span class="macro">Węgl.: <span class="macro-value">{{ $menuItem->carbs ?? 0 }}</span> g</span>
                                <span class="macro">Tłuszcze: <span class="macro-value">{{ $menuItem->fat ?? 0 }}</span> g</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="menu-submit">
                <a href="{{ route('diet-plans.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Powrót
                </a>
                <button type="submit" class="btn-submit" id="submit-btn">
                    <i class="fas fa-save me-2"></i>Zapisz menu i cenę
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('menu-form');
    const checkboxes = document.querySelectorAll('.menu-checkbox');
    const submitButton = document.getElementById('submit-btn');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuItems = document.querySelectorAll('.menu-item');
    const searchInput = document.getElementById('searchInput');
    const validationContainer = document.getElementById('validation-messages');
    
    const mealsPriceElement = document.getElementById('meals-price');
    const discountPriceElement = document.getElementById('discount-price');
    const mealsCountElement = document.getElementById('meals-count');
    const totalPriceElement = document.getElementById('total-price');
    const finalPriceInput = document.getElementById('final_price');
    const basePrice = parseFloat('{{ $dietPlan->price_per_day }}') || 0;
    
    form.addEventListener('submit', function(e) {
        clearValidationMessages();
        
        const selectedItems = Array.from(checkboxes).filter(cb => cb.checked);
        let hasErrors = false;
        
        if (selectedItems.length === 0) {
            e.preventDefault();
            showValidationMessage('Musisz wybrać co najmniej jeden posiłek dla diety', 'error');
            hasErrors = true;
        }
        
        if (selectedItems.length > 0 && selectedItems.length < 3) {
            if (!confirm('Wybrałeś tylko ' + selectedItems.length + ' posiłek(ów). Czy na pewno chcesz kontynuować? Zalecamy minimum 3 posiłki dziennie.')) {
                e.preventDefault();
                return;
            }
        }
        
        const finalPrice = parseFloat(finalPriceInput.value);
        if (isNaN(finalPrice) || finalPrice <= 0) {
            e.preventDefault();
            showValidationMessage('Cena końcowa musi być większa od 0 zł', 'error');
            hasErrors = true;
        }
        
        if (finalPrice > 200) {
            if (!confirm('Cena końcowa (' + finalPrice.toFixed(2) + ' zł/dzień) jest bardzo wysoka. Czy na pewno chcesz kontynuować?')) {
                e.preventDefault();
                return;
            }
        }
        
        const categoryCounts = {};
        selectedItems.forEach(item => {
            const category = item.closest('.menu-item').dataset.category;
            categoryCounts[category] = (categoryCounts[category] || 0) + 1;
        });
        
        const missingCategories = [];
        const importantCategories = ['śniadanie', 'obiad', 'kolacja'];
        importantCategories.forEach(cat => {
            if (!categoryCounts[cat]) {
                missingCategories.push(cat);
            }
        });
        
        if (missingCategories.length > 0) {
            showValidationMessage('Brakuje posiłków z kategorii: ' + missingCategories.join(', ') + '. Zalecamy dodanie posiłków z każdej podstawowej kategorii.', 'warning');
        }
        
        if (!hasErrors) {
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Zapisywanie...';
            submitButton.disabled = true;
        }
    });
    
    function updateSubmitButton() {
        const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        
        if (selectedCount === 0) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Wybierz posiłki';
            submitButton.style.background = '#dc3545';
        } else {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Zapisz menu i cenę (' + selectedCount + ')';
            submitButton.style.background = '#28a745';
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const menuItem = this.closest('.menu-item');
            if (this.checked) {
                menuItem.classList.add('selected');
            } else {
                menuItem.classList.remove('selected');
            }
            
            calculatePrice();
            updateSubmitButton();
            clearValidationMessages();
        });
    });
    
    function calculatePrice() {
        const selectedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
        const selectedCount = selectedCheckboxes.length;
        
        let totalMealsPrice = 0;
        selectedCheckboxes.forEach(checkbox => {
            const menuItem = checkbox.closest('.menu-item');
            const price = parseFloat(menuItem.dataset.price) || 0;
            totalMealsPrice += price;
        });
        
        let discountPercentage = 0;
        if (selectedCount >= 5 && selectedCount < 10) {
            discountPercentage = 10;
        } else if (selectedCount >= 10) {
            discountPercentage = 15;
        }
        
        const discount = totalMealsPrice * (discountPercentage / 100);
        const finalPrice = basePrice + totalMealsPrice - discount;
        
        mealsPriceElement.textContent = totalMealsPrice.toFixed(2) + ' zł';
        discountPriceElement.textContent = discount.toFixed(2) + ' zł';
        mealsCountElement.textContent = selectedCount;
        totalPriceElement.textContent = 'Cena końcowa: ' + finalPrice.toFixed(2) + ' zł / dzień';
        finalPriceInput.value = finalPrice.toFixed(2);
        
        if (finalPrice > 150) {
            totalPriceElement.style.color = '#dc3545'; 
        } else if (finalPrice > 100) {
            totalPriceElement.style.color = '#ffc107'; 
        } else {
            totalPriceElement.style.color = '#28a745'; 
        }
    }
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            menuItems.forEach(item => {
                const category = item.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        menuItems.forEach(item => {
            const name = item.querySelector('.menu-item-name').textContent.toLowerCase();
            const description = item.querySelector('.menu-item-description').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || description.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    function showValidationMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `validation-${type}`;
        messageDiv.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
            ${message}
        `;
        validationContainer.appendChild(messageDiv);
    }
    
    function clearValidationMessages() {
        validationContainer.innerHTML = '';
    }
    
    calculatePrice();
    updateSubmitButton();
    
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checkbox.closest('.menu-item').classList.add('selected');
        }
    });
});
</script>
@endpush