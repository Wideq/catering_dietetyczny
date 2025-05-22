@extends('layout')

@section('title', 'Edytuj Zamówienie')

@section('content')
<div class="container">
    <h2 class="mb-4">Edytuj Zamówienie</h2>
    <form method="POST" action="{{ route('orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">Użytkownik</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="menu_id" class="form-label">Menu</label>
            <select name="menu_id" id="menu_id" class="form-control" required>
                @foreach ($menus as $menu)
                <option value="{{ $menu->id }}" {{ $order->menu_id == $menu->id ? 'selected' : '' }}>{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Ilość</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $order->quantity }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Oczekujące</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Zakończone</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Anulowane</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </form>
</div>
@endsection