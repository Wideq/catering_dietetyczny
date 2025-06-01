@extends('layout')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Edytuj użytkownika</h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}" class="card shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Imię i nazwisko</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rola użytkownika</label>
                <select name="role" id="role" class="form-select">
                    <option value="">-- Wybierz rolę --</option>
                    <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>Użytkownik</option>
                    <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <hr class="my-4">

            <h5 class="mb-3">Zmiana hasła</h5>
            <div class="mb-3">
                <label for="password" class="form-label">Nowe hasło</label>
                <input type="password" name="password" id="password" class="form-control">
                <div class="form-text">Pozostaw puste, jeśli nie chcesz zmieniać hasła.</div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Anuluj</a>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </form>
</div>
@endsection