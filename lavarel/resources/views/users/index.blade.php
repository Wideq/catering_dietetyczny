@extends('layout')

@push('styles')
<style>
    /* NADPISANIE STYLÓW PAGINACJI SPECJALNIE DLA UŻYTKOWNIKÓW */
    .pagination-wrapper {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 30px 0 !important;
        padding: 20px !important;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        border-radius: 12px !important;
    }

    .pagination {
        display: flex !important;
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        background: white !important;
        border: 1px solid #dee2e6 !important;
    }

    .pagination .page-item {
        margin: 0 !important;
        border: none !important;
    }

    .pagination .page-link {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 8px 12px !important;
        min-width: 40px !important;
        height: 40px !important;
        color: #495057 !important;
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
        border-left: none !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        font-size: 14px !important;
        font-weight: 500 !important;
    }

    .pagination .page-item:first-child .page-link {
        border-left: 1px solid #dee2e6 !important;
        border-top-left-radius: 8px !important;
        border-bottom-left-radius: 8px !important;
    }

    .pagination .page-item:last-child .page-link {
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }

    .pagination .page-link:hover {
        background: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 6px rgba(0,123,255,0.3) !important;
    }

    .pagination .page-item.active .page-link {
        background: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 6px rgba(0,123,255,0.3) !important;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none !important;
        box-shadow: none !important;
        background-color: #f8f9fa !important;
        color: #6c757d !important;
    }

    /* NAPRAW STRZAŁKI - usuń wielkie ikony */
    .pagination .page-link svg,
    .pagination .page-link i {
        display: none !important;
    }

    /* Dodaj małe strzałki tekstowe */
    .pagination .page-item:first-child .page-link::before {
        content: "‹" !important;
        font-size: 16px !important;
        font-weight: bold !important;
    }

    .pagination .page-item:last-child .page-link::before {
        content: "›" !important;
        font-size: 16px !important;
        font-weight: bold !important;
    }

    /* Responsywność */
    @media (max-width: 768px) {
        .pagination .page-link {
            padding: 6px 10px !important;
            min-width: 35px !important;
            height: 35px !important;
            font-size: 12px !important;
        }
        
        /* Ukryj środkowe numery na mobile */
        .pagination .page-item:not(.active):not(:first-child):not(:last-child) {
            display: none !important;
        }
    }

    /* Style dla kart statystyk */
    .stats-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
    }

    /* Style dla tabeli */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table th {
        background-color: #f8f9fa;
        border: none;
        padding: 15px;
        font-weight: 600;
        color: #495057;
    }

    .table td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Style dla avatarów */
    .avatar-container {
        position: relative;
    }

    .avatar-container img,
    .avatar-container div {
        transition: transform 0.2s ease;
    }

    .avatar-container:hover img,
    .avatar-container:hover div {
        transform: scale(1.1);
    }

    /* Style dla badges */
    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
    }

    /* Style dla przycisków akcji */
    .btn-group .btn {
        border-radius: 6px;
        margin: 0 2px;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-users me-2 text-primary"></i>
            Lista użytkowników
        </h2>
        <a href="{{ route('users.create-admin') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Dodaj użytkownika
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Łączna liczba</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->total() }}</h3>
                            <small class="opacity-75">użytkowników</small>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Administratorzy</h6>
                            <h3 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                            <small class="opacity-75">adminów</small>
                        </div>
                        <div>
                            <i class="fas fa-user-shield fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Klienci</h6>
                            <h3 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'user')->count() }}</h3>
                            <small class="opacity-75">zwykłych użytkowników</small>
                        </div>
                        <div>
                            <i class="fas fa-user fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lista użytkowników 
                    <span class="badge bg-secondary ms-2">{{ $users->total() }}</span>
                </h5>
                <small class="text-muted">
                    Strona {{ $users->currentPage() }} z {{ $users->lastPage() }} 
                    ({{ $users->firstItem() }}-{{ $users->lastItem() }} z {{ $users->total() }})
                </small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="80">Avatar</th>
                            <th>Użytkownik</th>
                            <th>Email</th>
                            <th width="120">Rola</th>
                            <th width="150">Data rejestracji</th>
                            <th width="120">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark fw-bold">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="avatar-container">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="rounded-circle"
                                             style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width: 45px; height: 45px; font-size: 18px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong class="d-block">{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-warning text-dark">To Ty</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-shield-alt me-1"></i>Admin
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i>Użytkownik
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="d-block fw-bold">{{ $user->created_at->format('d.m.Y') }}</small>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edytuj użytkownika">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Na pewno chcesz usunąć {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Usuń użytkownika">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" 
                                                disabled 
                                                title="Nie możesz usunąć własnego konta">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Brak użytkowników w systemie</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links('pagination') }}
        </div>
    @endif
</div>
@endsection