@extends('layout')

@section('title', 'Dashboard - PureMeal')

@push('styles')
<style>
    .dashboard-container {
        background-color: var(--secondary-color);
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        padding: 40px;
        width: 100%;
        max-width: 900px;
        margin: 50px auto;
        transition: all 0.3s ease;
    }

    .dashboard-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
    }

    .dashboard-title {
        text-align: center;
        margin-bottom: 35px;
        color: var(--primary-color);
        font-weight: 700;
        font-size: 2.5rem;
        letter-spacing: 1px;
    }

    .dashboard-content {
        font-size: 1.2rem;
        color: var(--primary-color);
        line-height: 1.6;
    }

    .dashboard-content p {
        margin-bottom: 20px;
    }

    .btn-dashboard {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: inline-block;
        margin-top: 20px;
        margin-right: 10px;
        text-decoration: none;
    }

    .btn-dashboard:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: var(--secondary-color);
    }

    .charts-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
        padding: 20px;
    }

    .chart-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        min-height: 400px;
        position: relative;
    }

    .chart-title {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 15px;
        font-size: 1.2rem;
        font-weight: 600;
    }

    canvas {
        width: 100% !important;
        height: calc(100% - 40px) !important;
        position: absolute;
        left: 0;
        bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container animate__animated animate__fadeIn">
    <h1 class="dashboard-title">Dashboard</h1>
    <div class="dashboard-content">
        <p>Witaj na swoim panelu! Tutaj możesz zarządzać swoim kontem, przeglądać zamówienia i dostosowywać swoje preferencje.</p>
        <a href="{{ url('/') }}" class="btn-dashboard">Powrót do strony głównej</a>
        @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ url('/users/edit') }}" class="btn-dashboard">Edytuj użytkowników</a>
            <a href="{{ url('/users') }}" class="btn-dashboard">Lista użytkowników</a>
            <a href="{{ route('menu.create') }}" class="btn-dashboard">Dodaj danie do menu</a>
            <a href="{{ route('transactions.index') }}" class="btn-dashboard">Zarządzaj transakcjami</a>
            <a href="{{ route('orders.index') }}" class="btn-dashboard">Zarządzaj zamówieniami</a>

            <div class="charts-container">
                <div class="chart-box">
                    <h3 class="chart-title">Statystyki systemu</h3>
                    <canvas id="statsChart"></canvas>
                </div>
                <div class="chart-box">
                    <h3 class="chart-title">Status zamówień</h3>
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('load', function() {
    setTimeout(() => {
        if(document.getElementById('statsChart') && document.getElementById('ordersChart')) {
            initializeCharts();
        }
    }, 100);
});

function initializeCharts() {
    // Statystyki systemu
    const statsCtx = document.getElementById('statsChart').getContext('2d');
    const statsData = {
        users: @json(\App\Models\User::count()),
        orders: @json(\App\Models\Order::count()),
        menu: @json(\App\Models\Menu::count())
    };

    new Chart(statsCtx, {
        type: 'bar',
        data: {
            labels: ['Użytkownicy', 'Zamówienia', 'Menu'],
            datasets: [{
                label: 'Ilość',
                data: [statsData.users, statsData.orders, statsData.menu],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Status zamówień
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const orderStats = {
        new: @json(\App\Models\Order::where('status', 'new')->count()),
        inProgress: @json(\App\Models\Order::where('status', 'in_progress')->count()),
        completed: @json(\App\Models\Order::where('status', 'completed')->count())
    };

    new Chart(ordersCtx, {
        type: 'doughnut',
        data: {
            labels: ['Nowe', 'W realizacji', 'Zakończone'],
            datasets: [{
                data: [orderStats.new, orderStats.inProgress, orderStats.completed],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>
@endpush