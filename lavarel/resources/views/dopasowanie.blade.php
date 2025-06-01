@extends('layout')

@section('title', 'PureMeal - Dopasowanie diety')

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        height: 200px; 
        object-fit: cover; 
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .card-text {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .card-text.fw-bold {
        font-size: 1.1rem;
        color: var(--accent-color);
    }
    .btn-add-to-cart {
        background-color: var(--accent-color);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-add-to-cart:hover {
        background-color: #e67e22;
        color: white;
        transform: translateY(-2px);
    }

    .admin-buttons {
        border-top: 1px solid #eee;
        padding-top: 1rem;
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Nasze Dania</h1>
    
    <div class="row g-4">
        @foreach ($menus as $menu)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                @if ($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->name }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ $menu->description }}</p>
                    <p class="card-text fw-bold">Cena: {{ number_format($menu->price, 2) }} zł</p>
                    
                    @auth
                        <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-add-to-cart w-100">
                                <i class="fas fa-shopping-cart me-2"></i>Dodaj do koszyka
                            </button>
                        </form>
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
        @endforeach
    </div>
</div>
@endsection