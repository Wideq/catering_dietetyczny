@extends('layout')

@section('title', 'Dodaj Zamówienie')

@section('content')
<div class="container">
    <h2 class="mb-4">Dodaj Zamówienie</h2>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Użytkownik</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="menu_id" class="form-label">Menu</label>
            <select name="menu_id" id="menu_id" class="form-control" required>
                @foreach ($menus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Ilość</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Oczekujące</option>
                <option value="completed">Zakończone</option>
                <option value="cancelled">Anulowane</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj Zamówienie</button>
    </form>
</div>
@endsection