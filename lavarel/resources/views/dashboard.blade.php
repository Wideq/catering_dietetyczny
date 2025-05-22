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
    }

    .btn-dashboard:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
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
        @endif
    </div>
</div>
@endsection