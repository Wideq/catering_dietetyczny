@extends('layout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Twój Koszyk</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-lg-8">
            @if(session('cart') && count(session('cart')) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produkt</th>
                                    <th>Cena</th>
                                    <th>Ilość</th>
                                    <th>Razem</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php 
                                        $itemTotal = $details['price'] * $details['quantity']; 
                                        $total += $itemTotal;
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if(!empty($details['image']))
                                                    <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $details['name'] }}</h6>
                                                    @if($details['type'] === 'diet_plan')
                                                        <small class="text-muted">
                                                            {{ $details['duration'] }} dni (od {{ \Carbon\Carbon::parse($details['start_date'])->format('d.m.Y') }})
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ number_format($details['price'], 2) }} zł</td>
                                        <td class="align-middle">
                                            @if(!isset($details['type']) || $details['type'] === 'menu')                                                <input type="number" class="form-control form-control-sm quantity update-cart" value="{{ $details['quantity'] }}" min="1" style="width: 60px;">
                                            @else
                                                1
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ number_format($itemTotal, 2) }} zł</td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-danger remove-from-cart">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-5">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kontynuuj zakupy
                    </a>
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" id="checkout-button">
                            Złóż zamówienie <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-info">
                    Twój koszyk jest pusty!
                </div>
                <div class="text-center mb-5">
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Wróć do menu
                    </a>
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            @if(session('cart') && count(session('cart')) > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Podsumowanie</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Wartość produktów:</span>
                            <span>{{ number_format($total, 2) }} zł</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Dostawa:</span>
                            <span>0.00 zł</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Razem:</strong>
                            <strong>{{ number_format($total, 2) }} zł</strong>
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100" id="checkout-button-summary">
                                Złóż zamówienie
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity.update-cart');
    const checkoutButton = document.getElementById('checkout-button');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 99;
            
            if (isNaN(value) || value < min) {
                this.value = min;
                showNotification('Minimalna ilość to ' + min, 'warning');
            } else if (value > max) {
                this.value = max;
                showNotification('Maksymalna ilość to ' + max, 'warning');
            }
            
            updateCartTotal();
        });
        
        input.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#28a745';
            }
        });
    });
    
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function(e) {
            let hasErrors = false;
            
            quantityInputs.forEach(input => {
                const value = parseInt(input.value);
                if (isNaN(value) || value < 1) {
                    hasErrors = true;
                    input.style.borderColor = '#dc3545';
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                showNotification('Sprawdź ilości produktów w koszyku', 'error');
                return;
            }
            
            if (quantityInputs.length === 0) {
                e.preventDefault();
                showNotification('Koszyk jest pusty', 'error');
                return;
            }
            
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Przetwarzanie...';
            this.disabled = true;
            
            setTimeout(() => {
                this.closest('form').submit();
            }, 800);
        });
    }
    
    function updateCartTotal() {
        let total = 0;
        quantityInputs.forEach(input => {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('td:nth-child(3)').textContent.replace(' zł', '').replace(',', '.'));
            const quantity = parseInt(input.value);
            total += price * quantity;
            
            const subtotalCell = row.querySelector('td:nth-child(5)');
            subtotalCell.textContent = (price * quantity).toFixed(2) + ' zł';
        });
        
        const totalElement = document.querySelector('.card-body strong:last-child');
        if (totalElement) {
            totalElement.textContent = total.toFixed(2) + ' zł';
        }
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        notification.innerHTML = `
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
@endpush
@endsection