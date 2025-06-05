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
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--accent-color);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fafafa;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-color);
        background-color: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Avatar section */
    .avatar-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .current-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: var(--shadow-md);
    }

    .avatar-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 2.5rem;
        border: 4px solid white;
        box-shadow: var(--shadow-md);
    }

    .avatar-info {
        flex: 1;
    }

    .avatar-info h3 {
        margin: 0 0 0.5rem 0;
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .avatar-info p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        margin-top: 0.75rem;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--accent-color);
        color: white;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--accent-color) 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .orders-table th {
        background: linear-gradient(135deg, var(--primary-color) 0%, #374151 100%);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .orders-table tr:hover {
        background-color: #f8fafc;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-new {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-in_progress {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .order-items {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .order-items li {
        padding: 0.25rem 0;
        font-size: 0.9rem;
        color: #64748b;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: none;
        font-weight: 500;
        animation: slideIn 0.3s ease-out;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    @keyframes slideIn {
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

        .avatar-section {
            flex-direction: column;
            text-align: center;
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

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-section">
        <h2 class="section-title">Twój profil</h2>
        
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Avatar section -->
            <div class="avatar-section">
                <div class="avatar-container">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="current-avatar">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <div class="avatar-info">
                    <h3>Zdjęcie profilowe</h3>
                    <p>Dodaj swoje zdjęcie profilowe. Akceptowane formaty: JPG, PNG, maksymalny rozmiar: 2MB</p>
                    
                    <div class="file-input-wrapper">
                        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/jpg">
                        <label for="avatar" class="file-input-label">
                            <i class="fas fa-camera me-1"></i>
                            {{ Auth::user()->avatar ? 'Zmień zdjęcie' : 'Dodaj zdjęcie' }}
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="name">Imię i nazwisko</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="current_password">Aktualne hasło (wymagane do zmiany hasła)</label>
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

            <button type="submit" class="btn-submit">
                <i class="fas fa-save me-2"></i>Zapisz zmiany
            </button>
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
                                        @if($item->item_type == 'diet_plan' && isset($item->dietPlan))
                                            <li>{{ $item->dietPlan->name ?? 'Dieta' }} ({{ $item->duration ?? 0 }} dni od {{ \Carbon\Carbon::parse($item->start_date)->format('d.m.Y') }}) - {{ number_format($item->price, 2) }} zł</li>
                                        @elseif(isset($item->menu))
                                            <li>{{ $item->menu->name ?? 'Produkt' }} x {{ $item->quantity }} - {{ number_format($item->price * $item->quantity, 2) }} zł</li>
                                        @else
                                            <li>Pozycja #{{ $item->id }} x {{ $item->quantity }} - {{ number_format($item->price * $item->quantity, 2) }} zł</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @elseif(isset($order->menu) && $order->menu)
                                {{ $order->menu->name }} x {{ $order->quantity }}
                            @else
                                Zamówienie #{{ $order->id }}
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
                                } elseif(isset($order->menu) && $order->menu) {
                                    $totalAmount = $order->menu->price * $order->quantity;
                                } else {
                                    $totalAmount = $order->total_amount ?? 0;
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
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview avatara
        const avatarInput = document.getElementById('avatar');
        const avatarContainer = document.querySelector('.avatar-container');
        
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarContainer.innerHTML = `<img src="${e.target.result}" alt="Podgląd" class="current-avatar">`;
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto-hide success messages
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