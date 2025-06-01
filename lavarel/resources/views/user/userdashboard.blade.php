@extends('layout')

@section('title', 'Panel użytkownika - PureMeal')

@push('styles')
<style>
    :root {
        --primary-color: #1a1a1a;
        --accent-color: #3b82f6;
        --border-color: #e5e7eb;
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .user-dashboard {
        max-width: 1100px;
        margin: 3rem auto;
        padding: 0 1.5rem;
    }

    .profile-section, .orders-section {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .profile-section:hover, .orders-section:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent-color);
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-submit {
        background-color: var(--accent-color);
        color: white;
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: var(--shadow-sm);
    }

    .btn-submit:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1rem;
    }

    .orders-table th,
    .orders-table td {
        padding: 1.25rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .orders-table th {
        font-weight: 600;
        background-color: #f8fafc;
        color: var(--primary-color);
    }

    .orders-table tr:hover {
        background-color: #f8fafc;
    }
    
    .order-items {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    
    .order-items li {
        padding: 0.5rem 0;
        border-bottom: 1px dashed var(--border-color);
    }
    
    .order-items li:last-child {
        border-bottom: none;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        min-width: 120px;
    }

    .status-new { 
        background-color: #fef3c7; 
        color: #92400e;
        border: 1px solid #fcd34d;
    }

    .status-in-progress { 
        background-color: #e0f2fe; 
        color: #075985;
        border: 1px solid #7dd3fc;
    }

    .status-completed { 
        background-color: #dcfce7; 
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
        animation: fadeInDown 0.5s ease-in-out;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .user-dashboard {
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .profile-section, .orders-section {
            padding: 1.5rem;
        }

        .orders-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
@endpush


@section('content')
<div class="user-dashboard">
    @if(session('success'))
        <div class="alert alert-success animate__animated animate__fadeIn">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-section">
        <h2 class="section-title">Twój profil</h2>
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Imię i nazwisko</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="current_password">Aktualne hasło</label>
                <input type="password" id="current_password" name="current_password" class="form-control">
            </div>

            <div class="form-group">
                <label for="new_password">Nowe hasło</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Potwierdź nowe hasło</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn-submit">Zapisz zmiany</button>
        </form>
    </div>

    <div class="orders-section">
        <h2 class="section-title">Twoje zamówienia</h2>
        @if($orders->count() > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Nr zamówienia</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Produkty</th>
                        <th>Kwota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('new')
                                        Nowe
                                        @break
                                    @case('in_progress')
                                        W realizacji
                                        @break
                                    @case('completed')
                                        Zakończone
                                        @break
                                    @default
                                        {{ ucfirst($order->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            @if(isset($order->items) && $order->items->count() > 0)
                                <ul class="order-items">
                                    @foreach($order->items as $item)
                                        <li>{{ $item->menu->name }} x {{ $item->quantity }} - {{ number_format($item->price * $item->quantity, 2) }} zł</li>
                                    @endforeach
                                </ul>
                            @else
                                {{ $order->menu->name ?? 'Brak danych' }} x {{ $order->quantity }}
                            @endif
                        </td>
                        <td>
                            @php
                                // Obliczenie sumy dla zamówienia z wieloma pozycjami
                                $totalAmount = 0;
                                
                                if(isset($order->items) && $order->items->count() > 0) {
                                    foreach($order->items as $item) {
                                        $totalAmount += $item->price * $item->quantity;
                                    }
                                } elseif(isset($order->total_amount) && $order->total_amount > 0) {
                                    $totalAmount = $order->total_amount;
                                } elseif(isset($order->menu)) {
                                    $totalAmount = $order->menu->price * $order->quantity;
                                }
                            @endphp
                            {{ number_format($totalAmount, 2) }} zł
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nie masz jeszcze żadnych zamówień.</p>
            
            <!-- Kod diagnostyczny do wyświetlenia tylko podczas debugowania -->
            <div style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">
                <p>ID użytkownika: {{ $user->id }}</p>
                
                @if(isset($orders))
                    <p>Kolekcja orders istnieje, ale jest pusta.</p>
                @else
                    <p>Kolekcja orders nie została przekazana do widoku.</p>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide success alert after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.animation = 'fadeOut 0.5s ease-in-out forwards';
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

<style>
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>
@endpush
@endsection