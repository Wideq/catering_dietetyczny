@extends('layout')

@section('title', 'Plany diet - PureMeal')

@push('styles')
<style>
    .diet-plan-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .diet-plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
    }
    
    .diet-plan-icon {
        font-size: 2rem;
        color: var(--accent);
        margin-bottom: 10px;
    }
    
    .diet-plan-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .diet-plan-price {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .diet-plan-actions {
        margin-top: 15px;
    }
    
    .diet-plan-actions .btn {
        margin-right: 5px;
    }
    
    .btn-add-diet {
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Plany diet</h1>
        <a href="{{ route('diet-plans.create') }}" class="btn btn-primary btn-add-diet">
            <i class="fas fa-plus"></i> Dodaj nową dietę
        </a>
    </div>
    
    <div class="row">
        @forelse ($dietPlans as $dietPlan)
            <div class="col-md-4">
                <div class="diet-plan-card card p-4">
                    <div class="text-center">
                        <i class="fas {{ $dietPlan->icon ?? 'fa-utensils' }} diet-plan-icon"></i>
                        <h3 class="diet-plan-title">{{ $dietPlan->name }}</h3>
                        <div class="diet-plan-price">
                            {{ number_format($dietPlan->price_per_day, 2) }} zł / dzień
                        </div>
                        <p class="text-muted">{{ Str::limit($dietPlan->description, 100) }}</p>
                        <div class="diet-plan-actions">
                            <a href="{{ route('diet-plans.edit', $dietPlan->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edytuj
                            </a>
                            <a href="{{ route('diet-plans.manage-menu', $dietPlan->id) }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-utensils"></i> Menu
                            </a>
                            <form action="{{ route('diet-plans.destroy', $dietPlan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Czy na pewno chcesz usunąć tę dietę?')">
                                    <i class="fas fa-trash"></i> Usuń
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Nie znaleziono żadnych planów diet. Kliknij przycisk "Dodaj nową dietę", aby utworzyć pierwszy plan.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection