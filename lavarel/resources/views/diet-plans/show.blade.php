@extends('layout')

@section('title', $dietPlan->name . ' - PureMeal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .diet-header {
        position: relative;
        padding: 80px 0;
        background-color: var(--primary-color);
        color: white;
        text-align: center;
        margin-bottom: 50px;
    }
    
    .diet-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .diet-subtitle {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 30px;
        color: rgba(255,255,255,0.8);
    }
    
    .diet-price {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .diet-price span {
        font-size: 1rem;
        font-weight: 400;
    }
    
    .diet-container {
        max-width: 1000px;
        margin: 0 auto 80px;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2rem;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 60px;
        height: 3px;
        background-color: var(--accent);
        transform: translateX(-50%);
    }
    
    .day-selector {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .day-btn {
        padding: 10px 20px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .day-btn.active {
        background-color: var(--accent);
        color: white;
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .day-btn:hover:not(.active) {
        background-color: #f5f5f5;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .meal-type-section {
        margin-bottom: 40px;
    }
    
    .meal-type-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--primary-color);
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .meal-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }
    
    .meal-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }
    
    .meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    
    .meal-img {
        height: 180px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .meal-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .meal-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--accent);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .meal-icon {
        font-size: 3rem;
        color: var(--accent);
    }
    
    .meal-content {
        padding: 20px;
    }
    
    .meal-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
    
    .meal-description {
        color: var(--gray-medium);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .meal-macros {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 5px;
        margin-top: 15px;
        text-align: center;
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
    }
    
    .macro-item {
        display: flex;
        flex-direction: column;
    }
    
    .macro-value {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    .macro-label {
        font-size: 0.75rem;
        color: var(--gray-medium);
    }
    
    .order-form {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 50px;
    }
    
    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(136, 136, 136, 0.2);
    }
    
    .btn-order {
        background-color: var(--accent);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        font-size: 1.1rem;
        transition: all 0.3s;
        margin-top: 10px;
        display: block;
        text-align: center;
        text-decoration: none;
    }
    
    .btn-order:hover {
        background-color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        color: white;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        margin-bottom: 30px;
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .diet-features {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .feature-card {
        background-color: white;
        padding: 30px 20px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    
    .feature-icon {
        font-size: 2.5rem;
        color: var(--accent);
        margin-bottom: 15px;
    }
    
    .feature-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
    
    .feature-text {
        color: var(--gray-medium);
        font-size: 0.9rem;
    }
    
    .day-content {
        display: none;
    }
    
    .day-content.active {
        display: block;
        animation: fadeIn 0.5s ease forwards;
    }
    
    .no-meals-info {
        text-align: center;
        padding: 30px;
        background-color: #f8f9fa;
        border-radius: 10px;
        color: var(--gray-medium);
        font-style: italic;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .meal-cards {
            grid-template-columns: 1fr;
        }
        
        .diet-features {
            grid-template-columns: 1fr;
        }
        
        .diet-title {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="diet-header">
    <div class="container">
        <h1 class="diet-title">{{ $dietPlan->name }}</h1>
        <p class="diet-subtitle">{{ $dietPlan->description }}</p>
        <div class="diet-price">{{ number_format($dietPlan->price_per_day, 2) }} zł <span>/ dzień</span></div>
    </div>
</div>

<div class="container diet-container">
    <a href="{{ route('diet-plans.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Powrót do listy diet
    </a>
    
    <div class="diet-features">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <h3 class="feature-title">Świeże składniki</h3>
            <p class="feature-text">Używamy tylko najświeższych i najwyższej jakości składników, aby zapewnić Ci najlepsze doznania kulinarne.</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-apple-alt"></i>
            </div>
            <h3 class="feature-title">Zbilansowane posiłki</h3>
            <p class="feature-text">Każdy posiłek jest opracowany przez dietetyka, aby zapewnić optymalne wartości odżywcze.</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-truck"></i>
            </div>
            <h3 class="feature-title">Dostawa pod drzwi</h3>
            <p class="feature-text">Codziennie rano dostarczamy świeże posiłki prosto pod Twoje drzwi, abyś mógł cieszyć się dniem.</p>
        </div>
    </div>

    <h2 class="section-title">Menu diety</h2>
    
    <div class="day-selector">
        @for ($day = 1; $day <= 7; $day++)
            <button class="day-btn {{ $day === 1 ? 'active' : '' }}" data-day="{{ $day }}">
                Dzień {{ $day }}
            </button>
        @endfor
    </div>
    
    @for ($day = 1; $day <= 7; $day++)
        <div id="day-{{ $day }}" class="day-content {{ $day === 1 ? 'active' : '' }}">
            @php
                $dayMenu = $dietPlan->getMenuForDay($day);
                $mealTypes = $dayMenu->pluck('pivot.meal_type')->unique();
            @endphp
            
            @if($dayMenu->count() > 0)
                @foreach($mealTypes as $mealType)
                    <div class="meal-type-section">
                        <h3 class="meal-type-title">
                            @switch($mealType)
                                @case('breakfast')
                                    Śniadanie
                                    @break
                                @case('second_breakfast')
                                    Drugie śniadanie
                                    @break
                                @case('lunch')
                                    Obiad
                                    @break
                                @case('snack')
                                    Podwieczorek
                                    @break
                                @case('dinner')
                                    Kolacja
                                    @break
                                @default
                                    {{ ucfirst($mealType) }}
                            @endswitch
                        </h3>
                        
                        <div class="meal-cards">
                            @foreach($dayMenu->where('pivot.meal_type', $mealType) as $meal)
                                <div class="meal-card">
                                    <div class="meal-img">
                                        @if($meal->image)
                                            <img src="{{ asset('storage/' . $meal->image) }}" alt="{{ $meal->name }}">
                                        @else
                                            <i class="fas fa-utensils meal-icon"></i>
                                        @endif
                                        <span class="meal-badge">
                                            @switch($mealType)
                                                @case('breakfast')
                                                    Śniadanie
                                                    @break
                                                @case('second_breakfast')
                                                    Drugie śniadanie
                                                    @break
                                                @case('lunch')
                                                    Obiad
                                                    @break
                                                @case('snack')
                                                    Podwieczorek
                                                    @break
                                                @case('dinner')
                                                    Kolacja
                                                    @break
                                                @default
                                                    {{ ucfirst($mealType) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="meal-content">
                                        <h4 class="meal-title">{{ $meal->name }}</h4>
                                        <p class="meal-description">{{ Str::limit($meal->description, 120) }}</p>
                                        <div class="meal-macros">
                                            <div class="macro-item">
                                                <span class="macro-value">{{ $meal->calories ?? 0 }}</span>
                                                <span class="macro-label">kcal</span>
                                            </div>
                                            <div class="macro-item">
                                                <span class="macro-value">{{ $meal->protein ?? 0 }}</span>
                                                <span class="macro-label">białko</span>
                                            </div>
                                            <div class="macro-item">
                                                <span class="macro-value">{{ $meal->carbs ?? 0 }}</span>
                                                <span class="macro-label">węgl.</span>
                                            </div>
                                            <div class="macro-item">
                                                <span class="macro-value">{{ $meal->fat ?? 0 }}</span>
                                                <span class="macro-label">tłuszcze</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-meals-info">
                    <i class="fas fa-info-circle"></i> Menu na dzień {{ $day }} nie zostało jeszcze zaplanowane.
                </div>
            @endif
        </div>
    @endfor
    
    <div class="order-form">
        <h3 class="form-title">Zamów dietę</h3>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="diet_plan_id" value="{{ $dietPlan->id }}">
            
            <div class="form-group">
                <label for="duration" class="form-label">Liczba dni</label>
                <select id="duration" name="duration" class="form-control" required>
                    <option value="5">5 dni</option>
                    <option value="7">7 dni</option>
                    <option value="14">14 dni</option>
                    <option value="28">28 dni</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="start_date" class="form-label">Data rozpoczęcia</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            
            <div class="form-group">
                <label for="notes" class="form-label">Dodatkowe uwagi (opcjonalnie)</label>
                <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
            </div>
            
            <div id="price-summary" class="price-calculation">
                <div class="price-item">
                    <div class="price-label">Cena za dzień</div>
                    <div class="price-value">{{ number_format($dietPlan->price_per_day, 2) }} zł</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Liczba dni</div>
                    <div id="days-value" class="price-value">5</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Łączna cena</div>
                    <div id="total-price" class="price-value">{{ number_format($dietPlan->price_per_day * 5, 2) }} zł</div>
                </div>
            </div>
            
            @auth
                <button type="submit" class="btn-order">Zamów teraz</button>
            @else
                <a href="{{ route('login') }}" class="btn-order">Zaloguj się, aby zamówić</a>
            @endauth
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obsługa przełączania dni
        const dayButtons = document.querySelectorAll('.day-btn');
        const dayContents = document.querySelectorAll('.day-content');
        
        dayButtons.forEach(button => {
            button.addEventListener('click', function() {
                const day = this.getAttribute('data-day');
                
                // Aktualizacja aktywnych przycisków
                dayButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Aktualizacja aktywnej zawartości
                dayContents.forEach(content => content.classList.remove('active'));
                document.getElementById(`day-${day}`).classList.add('active');
            });
        });
        
        // Obsługa kalkulacji ceny
        const durationSelect = document.getElementById('duration');
        const daysValue = document.getElementById('days-value');
        const totalPrice = document.getElementById('total-price');
        const pricePerDay = {{ json_encode($dietPlan->price_per_day) }};
        
        durationSelect.addEventListener('change', function() {
            const days = parseInt(this.value);
            const total = days * pricePerDay;
            
            daysValue.textContent = days;
            totalPrice.textContent = total.toFixed(2) + ' zł';
        });
        
        // Ustawienie minimalnej daty na jutro
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const startDateInput = document.getElementById('start_date');
        startDateInput.min = tomorrow.toISOString().split('T')[0];
    });
</script>
@endpush