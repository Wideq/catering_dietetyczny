@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 fw-bold">Twój koszyk</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(count($cartItems) > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                @foreach($cartItems as $id => $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                        <div>
                                            <h5 class="mb-1">{{ $item['name'] }}</h5>
                                            <p class="mb-0 text-muted">
                                                <span class="me-3">Ilość: {{ $item['quantity'] }}</span>
                                                <span>Cena: {{ number_format($item['price'], 2) }} zł</span>
                                            </p>
                                        </div>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Usuń
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Podsumowanie zamówienia</h5>
                                <div class="d-flex justify-content-between mb-4">
                                    <span>Suma:</span>
                                    <span class="fw-bold fs-5">{{ number_format($total, 2) }} zł</span>
                                </div>
                                
                                <form action="{{ route('cart.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100" id="checkout-button">
                                        <i class="bi bi-cart-check"></i> Zrealizuj zamówienie
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart3 fs-1 text-muted mb-3"></i>
                    <p class="lead text-muted">Twój koszyk jest pusty</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Wróć do menu
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Dodaj interaktywne potwierdzenie przy składaniu zamówienia
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutButton = document.getElementById('checkout-button');
        
        if (checkoutButton) {
            checkoutButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Wyświetl wizualny feedback
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Przetwarzanie...';
                this.disabled = true;
                
                // Prześlij formularz po krótkim opóźnieniu (pokazuje loading state)
                setTimeout(() => {
                    this.closest('form').submit();
                }, 800);
            });
        }
    });
</script>
@endpush
@endsection