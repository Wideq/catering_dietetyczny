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
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-primary me-2">Edytuj</a>
                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć to menu?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection