@extends('layout')

@section('title', 'Zarządzanie posiłkami diety - PureMeal')
@if(isset($menuCount) && isset($categories))
    <div class="alert alert-info">
        <p>Znaleziono {{$menuCount}} posiłków w bazie danych.</p>
        <p>Kategorie: {{ implode(', ', array_filter($categories)) ?: 'Brak kategorii' }}</p>
    </div>
@endif
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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
    }
    
    .price-summary h3 {
        margin-bottom: 15px;
        color: var(--primary-color);
    }
    
    .price-calculation {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .price-item {
        background-color: white;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .price-label {
        font-size: 0.9rem;
        color: var(--gray-medium);
        margin-bottom: 5px;
    }
    
    .price-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .total-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent);
        margin-top: 15px;
    }
    
    .meal-category {
        margin: 30px 0 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-size: 1.3rem;
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .form-check {
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid #eee;
        transition: all 0.3s;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .form-check:hover {
        background-color: #f9f9fa;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }
    
    .form-check-input {
        margin-right: 15px;
        width: 20px !important;
        height: 20px !important;
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
    
    .menu-item-details {
        flex-grow: 1;
    }
    
    .menu-item-name {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1.1rem;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .menu-item-price {
        color: var(--accent);
        font-weight: 600;
    }
    
    .menu-item-description {
        color: var(--gray-medium);
        font-size: 0.9rem;
    }
    
    .menu-item-macros {
        display: flex;
        gap: 15px;
        margin-top: 8px;
        font-size: 0.8rem;
    }
    
    .macro {
        color: var(--gray-medium);
    }
    
    .macro-value {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .menu-search {
        margin-bottom: 25px;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 20px;
        border-radius: 25px;
        border: 1px solid #ddd;
        transition: all 0.3s;
        font-size: 1rem;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(136, 136, 136, 0.2);
    }
    
    .menu-filter {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .filter-btn {
        padding: 8px 16px;
        border-radius: 20px;
        background-color: white;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--gray-medium);
    }
    
    .filter-btn.active {
        background-color: var(--accent);
        color: white;
        border-color: var(--accent);
    }
    
    .filter-btn:hover:not(.active) {
        background-color: #f5f5f5;
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
    
    .menu-submit {
        margin-top: 30px;
        text-align: center;
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
        
        <form action="{{ route('diet-plans.update-menu', $dietPlan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="price_per_day" id="final_price" value="{{ $dietPlan->price_per_day }}">
            
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
                <a href="{{ route('diet-plans.index') }}" class="btn-back">Powrót</a>
                <button type="submit" class="btn-submit">Zapisz menu i cenę</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const menuItems = document.querySelectorAll('.menu-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (filter === 'all') {
                    menuItems.forEach(item => {
                        item.style.display = 'flex';
                    });
                } else {
                    menuItems.forEach(item => {
                        if (item.getAttribute('data-category').toLowerCase() === filter.toLowerCase()) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }
            });
        });
        
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            if (searchTerm !== '') {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                filterButtons[0].classList.add('active');
            }
            
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
        
        const checkboxes = document.querySelectorAll('.menu-checkbox');
        const mealsPriceElement = document.getElementById('meals-price');
        const discountPriceElement = document.getElementById('discount-price');
        const basePriceElement = document.getElementById('base-price');
        const mealsCountElement = document.getElementById('meals-count');
        const totalPriceElement = document.getElementById('total-price');
        const finalPriceInput = document.getElementById('final_price');
        
        const basePrice = parseFloat('{{ $dietPlan->price_per_day }}');
        
        function calculatePrice() {
            let totalMealsPrice = 0;
            let selectedCount = 0;
            
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCount++;
                    const menuItem = checkbox.closest('.menu-item');
                    const price = parseFloat(menuItem.getAttribute('data-price'));
                    totalMealsPrice += price;
                }
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
        }
        
        calculatePrice();
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculatePrice);
        });
    });
</script>
@endpush