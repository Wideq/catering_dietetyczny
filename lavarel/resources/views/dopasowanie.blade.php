@extends('layout')

@section('title', 'Dopasuj swoją dietę - PureMeal')

@push('styles')
<style>
    /* Styl dla paginacji */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin: 40px 0;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 16px;
        color: #495057;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-left: none;
        text-decoration: none;
        transition: all 0.3s ease;
        min-width: 44px;
        height: 44px;
        font-weight: 500;
    }

    .pagination .page-item:first-child .page-link {
        border-left: 1px solid #dee2e6;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .pagination .page-item:last-child .page-link {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #f8f9fa;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none;
    }

    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 8px 12px;
            font-size: 14px;
            min-width: 40px;
            height: 40px;
        }
        
        .pagination .page-item:not(.active):not(:first-child):not(:last-child) {
            display: none;
        }
    }

    /* Istniejące style - pozostają bez zmian */
    .filter-title {
        color: #333;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Nowy prostszy Range Slider */
    .price-range-container {
        margin: 20px 0;
    }

    .price-inputs {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 20px;
    }

    .price-input-group {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .price-input-group label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .price-input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        font-size: 1rem;
        font-weight: 600;
        color: #007bff;
        text-align: center;
        transition: all 0.3s ease;
    }

    .price-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .range-slider {
        position: relative;
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        margin: 20px 0;
    }

    .range-progress {
        position: absolute;
        height: 100%;
        background: linear-gradient(90deg, #007bff, #0056b3);
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    .range-input {
        position: absolute;
        top: -7px;
        width: 100%;
        height: 20px;
        background: none;
        pointer-events: none;
        appearance: none;
        -webkit-appearance: none;
    }

    .range-input::-webkit-slider-thumb {
        appearance: none;
        -webkit-appearance: none;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #007bff;
        cursor: pointer;
        pointer-events: auto;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,123,255,0.3);
        transition: all 0.3s ease;
    }

    .range-input::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 4px 12px rgba(0,123,255,0.4);
    }

    .range-input::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #007bff;
        cursor: pointer;
        pointer-events: auto;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,123,255,0.3);
    }

    .quick-price-buttons {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .quick-price-btn {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        min-width: fit-content;
    }

    .quick-price-btn:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .filter-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .filters-container {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .category-filters {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .category-toggle {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 60px;
        min-height: 20px;
        line-height: 20px;
    }

    .category-toggle-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .toggle-slider {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 40px;
        background-color: #ccc;
        border-radius: 20px;
        transition: 0.4s;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        top: 2px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    .category-toggle-input:checked + .toggle-slider {
        background-color: #007bff;
    }

    .category-toggle-input:checked + .toggle-slider:before {
        transform: translateX(20px);
    }

    .filter-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    .filter-reset:hover {
        background: #5a6268;
        transform: translateY(-1px);
    }

    .results-info {
        text-align: center;
        margin: 20px 0;
        padding: 15px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-radius: 25px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .results-count {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .menu-item {
        transition: all 0.3s ease;
        opacity: 1;
        transform: scale(1);
    }

    .menu-item.hidden {
        display: none !important;
    }

    .menu-item.show {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-results i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .no-results h4 {
        margin-bottom: 10px;
        color: #495057;
    }

    /* Style dla wartości odżywczych w kartach */
    .nutrition-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin: 12px 0;
        border-left: 4px solid #007bff;
    }

    .nutrition-info .row {
        margin: 0;
    }

    .nutrition-info .col-6 {
        padding: 2px 4px;
    }

    .nutrition-info small {
        font-size: 0.75rem;
        font-weight: 500;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .nutrition-info i {
        font-size: 0.8rem;
        width: 12px;
        text-align: center;
    }

    /* Style dla nieaktywnych dań */
    .menu-inactive {
        opacity: 0.7;
    }

    .menu-inactive .card {
        border: 2px solid #dc3545 !important;
        background-color: #f8f9fa;
    }

    .menu-inactive .card:hover {
        transform: none !important;
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3) !important;
    }

    .menu-inactive .btn-add-to-cart {
        display: none !important;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    .btn-add-to-cart {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add-to-cart:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        color: white;
    }

    .admin-buttons {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e9ecef;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filters-container {
            padding: 1.5rem;
        }
        
        .category-filters {
            margin-top: 1rem;
        }
        
        .price-inputs {
            flex-direction: column;
            gap: 10px;
        }

        .filter-card {
            margin-bottom: 1rem;
        }

        .quick-price-buttons {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Znajdź swoje idealne menu</h1>
    
    <!-- Filtry z range sliderem -->
    <div class="filters-container">
        <div class="row">
            <div class="col-md-6">
                <div class="filter-card">
                    <h5 class="filter-title">
                        <i class="fas fa-coins"></i>
                        Filtruj według ceny
                    </h5>
                    <div class="price-range-container">
                        <div class="price-inputs">
                            <div class="price-input-group">
                                <label>Cena minimalna</label>
                                <input type="number" id="min-price-input" class="price-input" step="0.01" placeholder="0.00">
                            </div>
                            <div class="price-input-group">
                                <label>Cena maksymalna</label>
                                <input type="number" id="max-price-input" class="price-input" step="0.01" placeholder="100.00">
                            </div>
                        </div>
                        
                        <div class="range-slider">
                            <div class="range-progress" id="range-progress"></div>
                            <input type="range" id="min-range" class="range-input" min="0" max="100" value="0" step="0.01">
                            <input type="range" id="max-range" class="range-input" min="0" max="100" value="100" step="0.01">
                        </div>
                        
                        <div class="quick-price-buttons">
                            <button type="button" class="quick-price-btn" onclick="setQuickPrice(0, 20)">0-20 zł</button>
                            <button type="button" class="quick-price-btn" onclick="setQuickPrice(20, 40)">20-40 zł</button>
                            <button type="button" class="quick-price-btn" onclick="setQuickPrice(40, 60)">40-60 zł</button>
                            <button type="button" class="quick-price-btn" onclick="resetPriceFilter()">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="filter-card">
                    <h5 class="filter-title">
                        <i class="fas fa-utensils"></i>
                        Kategorie posiłków
                    </h5>
                    <div class="category-filters">
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="śniadanie" checked>
                            <span class="toggle-slider"></span>
                            Śniadania
                        </label>
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="drugie śniadanie" checked>
                            <span class="toggle-slider"></span>
                            Drugie śniadania
                        </label>
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="obiad" checked>
                            <span class="toggle-slider"></span>
                            Obiady
                        </label>
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="podwieczorek" checked>
                            <span class="toggle-slider"></span>
                            Podwieczorki
                        </label>
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="kolacja" checked>
                            <span class="toggle-slider"></span>
                            Kolacje
                        </label>
                        <label class="category-toggle">
                            <input type="checkbox" class="category-toggle-input" value="przekąska" checked>
                            <span class="toggle-slider"></span>
                            Przekąski
                        </label>
                    </div>
                    <button type="button" class="filter-reset" onclick="resetCategoryFilter()">
                        <i class="fas fa-undo me-1"></i>Zaznacz wszystkie
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Informacja o wynikach -->
    <div class="results-info">
        <span class="results-count" id="results-count">{{ $menus->total() }}</span> 
        <span>dań spełnia wybrane kryteria</span>
    </div>
    
    <div class="row g-4" id="menu-container">
        @foreach ($menus as $menu)
        <div class="col-md-4 menu-item {{ !$menu->is_active ? 'menu-inactive' : '' }}" 
             data-category="{{ strtolower($menu->category ?? '') }}" 
             data-price="{{ $menu->price }}">
            <div class="card shadow-sm h-100 {{ !$menu->is_active ? 'border-danger' : '' }}">
                
                @if(!$menu->is_active)
                    <div class="alert alert-warning mb-0 text-center" style="border-radius: 0;">
                        <i class="fas fa-exclamation-triangle"></i> Danie nieaktywne
                    </div>
                @endif
                
                @if ($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}" 
                         class="card-img-top {{ !$menu->is_active ? 'opacity-50' : '' }}" 
                         alt="{{ $menu->name }}" 
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center {{ !$menu->is_active ? 'opacity-50' : '' }}" 
                         style="height: 200px;">
                        <i class="fas fa-utensils fa-3x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title {{ !$menu->is_active ? 'text-muted' : '' }}">
                        {{ $menu->name }}
                        @if(!$menu->is_active)
                            <span class="badge bg-danger ms-2">Nieaktywne</span>
                        @endif
                    </h5>
                    <p class="card-text text-muted small mb-2">
                        <i class="fas fa-tag me-1"></i>{{ ucfirst($menu->category ?? 'Brak kategorii') }}
                    </p>
                    <p class="card-text flex-grow-1">{{ Str::limit($menu->description, 100) }}</p>
                    
                    <!-- Wartości odżywcze -->
                    @if($menu->calories || $menu->protein || $menu->carbs || $menu->fat)
                        <div class="nutrition-info mb-3">
                            <div class="row g-1">
                                @if($menu->calories)
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-fire text-danger"></i> {{ $menu->calories }} kcal
                                        </small>
                                    </div>
                                @endif
                                @if($menu->protein)
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-drumstick-bite text-primary"></i> {{ $menu->protein }}g białka
                                        </small>
                                    </div>
                                @endif
                                @if($menu->carbs)
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-bread-slice text-warning"></i> {{ $menu->carbs }}g węgl.
                                        </small>
                                    </div>
                                @endif
                                @if($menu->fat)
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-tint text-success"></i> {{ $menu->fat }}g tłuszcze
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-primary fs-5">{{ number_format($menu->price, 2) }} zł</span>
                        </div>
                        
                        @auth
                            @if($menu->is_active)
                                <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-add-to-cart w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Dodaj do koszyka
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-danger text-center py-2 mb-0">
                                    <small><i class="fas fa-ban me-1"></i>Danie niedostępne</small>
                                </div>
                            @endif
                        @endauth

                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="admin-buttons">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>Edytuj
                                    </a>
                                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" 
                                          onsubmit="return confirm('Czy na pewno chcesz usunąć to menu?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i>Usuń
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Komunikat o braku wyników -->
    <div id="no-results" class="no-results" style="display: none;">
        <i class="fas fa-search"></i>
        <h4>Nie znaleziono menu</h4>
        <p>Nie znaleziono dań spełniających wybrane kryteria.<br>Spróbuj rozszerzyć zakres filtrów.</p>
    </div>

    <!-- PAGINACJA -->
    <div class="pagination-wrapper">
        {{ $menus->links('pagination') }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minInput = document.getElementById('min-price-input');
    const maxInput = document.getElementById('max-price-input');
    const minRange = document.getElementById('min-range');
    const maxRange = document.getElementById('max-range');
    const rangeProgress = document.getElementById('range-progress');
    const menuItems = document.querySelectorAll('.menu-item');
    const categoryToggles = document.querySelectorAll('.category-toggle-input');
    const resultsCount = document.getElementById('results-count');
    const noResultsMessage = document.getElementById('no-results');
    
    let prices = [];
    menuItems.forEach(item => {
        const price = parseFloat(item.dataset.price) || 0;
        prices.push(price);
    });
    
    let minPriceValue = 0;
    let maxPriceValue = 100;
    
    if (prices.length > 0) {
        minPriceValue = Math.min(...prices);
        maxPriceValue = Math.max(...prices);
    }
    
    minInput.value = minPriceValue.toFixed(2);
    maxInput.value = maxPriceValue.toFixed(2);
    minInput.min = minPriceValue;
    minInput.max = maxPriceValue;
    maxInput.min = minPriceValue;
    maxInput.max = maxPriceValue;
    
    minRange.min = minPriceValue;
    minRange.max = maxPriceValue;
    minRange.value = minPriceValue;
    maxRange.min = minPriceValue;
    maxRange.max = maxPriceValue;
    maxRange.value = maxPriceValue;
    
    function updateProgress() {
        const minVal = parseFloat(minRange.value);
        const maxVal = parseFloat(maxRange.value);
        const minPercent = ((minVal - minPriceValue) / (maxPriceValue - minPriceValue)) * 100;
        const maxPercent = ((maxVal - minPriceValue) / (maxPriceValue - minPriceValue)) * 100;
        
        rangeProgress.style.left = minPercent + '%';
        rangeProgress.style.width = (maxPercent - minPercent) + '%';
    }
    
    function syncInputs() {
        let minVal = parseFloat(minInput.value) || minPriceValue;
        let maxVal = parseFloat(maxInput.value) || maxPriceValue;
        
        if (minVal > maxVal) {
            const temp = minVal;
            minVal = maxVal;
            maxVal = temp;
        }
        
        minVal = Math.max(minPriceValue, Math.min(maxPriceValue, minVal));
        maxVal = Math.max(minPriceValue, Math.min(maxPriceValue, maxVal));
        
        minInput.value = minVal.toFixed(2);
        maxInput.value = maxVal.toFixed(2);
        minRange.value = minVal;
        maxRange.value = maxVal;
        
        updateProgress();
        filterMenuItems();
    }
    
    function filterMenuItems() {
        const minVal = parseFloat(minRange.value);
        const maxVal = parseFloat(maxRange.value);
        
        const selectedCategories = Array.from(categoryToggles)
            .filter(toggle => toggle.checked)
            .map(toggle => toggle.value.toLowerCase());
        
        let visibleCount = 0;
        
        menuItems.forEach(item => {
            const price = parseFloat(item.dataset.price) || 0;
            const category = item.dataset.category.toLowerCase() || '';
            
            const priceMatch = price >= minVal && price <= maxVal;
            const categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(category);
            
            if (priceMatch && categoryMatch) {
                item.classList.remove('hidden');
                item.classList.add('show');
                visibleCount++;
            } else {
                item.classList.add('hidden');
                item.classList.remove('show');
            }
        });
        
        resultsCount.textContent = visibleCount;
        
        if (visibleCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }
    
    window.setQuickPrice = function(min, max) {
        minInput.value = min.toFixed(2);
        maxInput.value = Math.min(max, maxPriceValue).toFixed(2);
        syncInputs();
    }
    
    window.resetPriceFilter = function() {
        minInput.value = minPriceValue.toFixed(2);
        maxInput.value = maxPriceValue.toFixed(2);
        syncInputs();
    }
    
    window.resetCategoryFilter = function() {
        categoryToggles.forEach(toggle => {
            toggle.checked = true;
        });
        filterMenuItems();
    }
    
    minInput.addEventListener('input', syncInputs);
    maxInput.addEventListener('input', syncInputs);
    minRange.addEventListener('input', function() {
        minInput.value = this.value;
        syncInputs();
    });
    maxRange.addEventListener('input', function() {
        maxInput.value = this.value;
        syncInputs();
    });
    
    categoryToggles.forEach(toggle => {
        toggle.addEventListener('change', filterMenuItems);
    });
    
    updateProgress();
    filterMenuItems();
});
</script>
@endsection