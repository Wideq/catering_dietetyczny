@extends('layout')

@section('title', 'Panel Administratora - PureMeal')

@push('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        border-left: 4px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.users { border-left-color: #3b82f6; }
    .stat-card.orders { border-left-color: #10b981; }
    .stat-card.revenue { border-left-color: #f59e0b; }
    .stat-card.menu { border-left-color: #8b5cf6; }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filters-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-container {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        position: relative;
    }

    .chart-container canvas {
        max-height: 300px;
    }

    .recent-orders {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .recent-orders-header {
        background: #f8fafc;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table th,
    .orders-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
    }

    .orders-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-new { background: #dbeafe; color: #1e40af; }
    .status-in_progress { background: #fef3c7; color: #d97706; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #dc2626; }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .action-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .action-card:hover {
        transform: translateY(-3px);
        text-decoration: none;
        color: inherit;
    }

    .action-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        display: block;
    }

    .action-card.users .action-icon { color: #3b82f6; }
    .action-card.menu .action-icon { color: #10b981; }
    .action-card.orders .action-icon { color: #f59e0b; }
    .action-card.diet-plans .action-icon { color: #8b5cf6; }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 0 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .charts-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">Panel Administratora</h1>
                <p class="mb-0 opacity-90">Witaj z powrotem! Oto przegląd Twojej aplikacji.</p>
            </div>
            <div class="text-end">
                <div class="fs-5 fw-bold">{{ now()->format('d.m.Y') }}</div>
                <div class="opacity-75">{{ now()->format('H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Statystyki -->
    <div class="stats-grid">
        <div class="stat-card users">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Użytkownicy</div>
                    <div class="stat-number text-primary">{{ $totalUsers }}</div>
                    <small class="text-muted">Łącznie w systemie</small>
                </div>
                <i class="fas fa-users fa-2x text-primary opacity-75"></i>
            </div>
        </div>

        <div class="stat-card orders">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Zamówienia</div>
                    <div class="stat-number text-success">{{ $totalOrders }}</div>
                    <small class="text-muted">W ostatnich {{ $dateRange }} dniach</small>
                </div>
                <i class="fas fa-shopping-cart fa-2x text-success opacity-75"></i>
            </div>
        </div>

        <div class="stat-card revenue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Przychody</div>
                    <div class="stat-number text-warning">{{ number_format($totalRevenue, 2) }} zł</div>
                    <small class="text-muted">W ostatnich {{ $dateRange }} dniach</small>
                </div>
                <i class="fas fa-chart-line fa-2x text-warning opacity-75"></i>
            </div>
        </div>

        <div class="stat-card menu">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Menu</div>
                    <div class="stat-number text-info">{{ $totalMenuItems }}</div>
                    <small class="text-muted">Dostępnych dań</small>
                </div>
                <i class="fas fa-utensils fa-2x text-info opacity-75"></i>
            </div>
        </div>
    </div>

    <!-- Filtry dla wykresów -->
    <div class="filters-section">
        <h5 class="mb-3">
            <i class="fas fa-filter me-2"></i>Filtry wykresów
        </h5>
        <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
            <div class="col-md-4">
                <label for="date_range" class="form-label">Zakres dat:</label>
                <select name="date_range" id="date_range" class="form-select">
                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Ostatnie 7 dni</option>
                    <option value="14" {{ $dateRange == '14' ? 'selected' : '' }}>Ostatnie 14 dni</option>
                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Ostatnie 30 dni</option>
                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Ostatnie 90 dni</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dish_type" class="form-label">Kategoria dań:</label>
                <select name="dish_type" id="dish_type" class="form-select">
                    <option value="">Wszystkie kategorie</option>
                    @foreach(['śniadanie', 'drugie śniadanie', 'obiad', 'podwieczorek', 'kolacja', 'przekąska'] as $category)
                        <option value="{{ $category }}" {{ $dishTypeFilter == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filtruj
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Wykresy -->
    <div class="charts-grid">
        <!-- Wykres przychodów -->
        <div class="chart-container">
            <h4 class="mb-3">
                <i class="fas fa-chart-line me-2 text-primary"></i>
                Przychody dzienne
                <small class="text-muted">(ostatnie {{ $dateRange }} dni)</small>
            </h4>
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- Wykres popularnych dań -->
        <div class="chart-container">
            <h4 class="mb-3">
                <i class="fas fa-chart-pie me-2 text-success"></i>
                Popularne dania
                @if($dishTypeFilter)
                    <small class="text-muted">({{ ucfirst($dishTypeFilter) }})</small>
                @endif
            </h4>
            <canvas id="popularDishesChart"></canvas>
        </div>
    </div>

    <!-- Szybkie akcje -->
    <div class="quick-actions">
        <a href="{{ route('users.index') }}" class="action-card users">
            <i class="fas fa-users action-icon"></i>
            <h5>Zarządzaj użytkownikami</h5>
            <p class="text-muted small mb-0">Dodawaj, edytuj i usuwaj użytkowników</p>
        </a>

        <a href="{{ route('dopasowanie') }}" class="action-card menu">
            <i class="fas fa-utensils action-icon"></i>
            <h5>Zarządzaj menu</h5>
            <p class="text-muted small mb-0">Dodawaj i edytuj dania</p>
        </a>

        <a href="{{ route('orders.index') }}" class="action-card orders">
            <i class="fas fa-clipboard-list action-icon"></i>
            <h5>Zarządzaj zamówieniami</h5>
            <p class="text-muted small mb-0">Przeglądaj i edytuj zamówienia</p>
        </a>

        <a href="{{ route('diet-plans.index') }}" class="action-card diet-plans">
            <i class="fas fa-apple-alt action-icon"></i>
            <h5>Plany dietetyczne</h5>
            <p class="text-muted small mb-0">Zarządzaj dietami</p>
        </a>
    </div>

    <!-- Ostatnie zamówienia -->
    <div class="recent-orders">
        <div class="recent-orders-header">
            <h3 class="mb-0">
                <i class="fas fa-clock me-2"></i>
                Ostatnie zamówienia
                <span class="badge bg-secondary ms-2">{{ $recentOrders->total() ?? 0 }}</span>
            </h3>
        </div>
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Użytkownik</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Kwota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user ? $order->user->name : 'Usuniętego użytkownika' }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('new') Nowe @break
                                    @case('in_progress') W realizacji @break
                                    @case('completed') Zakończone @break
                                    @case('cancelled') Anulowane @break
                                    @default {{ ucfirst($order->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td>{{ number_format($order->total_amount ?? 0, 2) }} zł</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-clipboard-list text-muted fs-1"></i>
                            <p class="mt-2 mb-0">Brak ostatnich zamówień w wybranym okresie</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($recentOrders) && $recentOrders->hasPages())
            <div class="pagination-wrapper">
                {{ $recentOrders->links('pagination') }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wykres przychodów
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueData ?? []);
    
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: Object.keys(revenueData),
            datasets: [{
                label: 'Przychody (zł)',
                data: Object.values(revenueData),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    callbacks: {
                        label: function(context) {
                            return 'Przychód: ' + context.parsed.y.toFixed(2) + ' zł';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(2) + ' zł';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Wykres popularnych dań
    const dishesCtx = document.getElementById('popularDishesChart').getContext('2d');
    const popularDishes = @json($popularDishes ?? []);
    
    new Chart(dishesCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(popularDishes),
            datasets: [{
                data: Object.values(popularDishes),
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#06b6d4',
                    '#f97316'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' zamówień (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection