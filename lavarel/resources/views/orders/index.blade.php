@extends('layout')

@section('title', 'Lista Zamówień')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Lista Zamówień</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Dodaj Zamówienie</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Użytkownik</th>
                <th>Menu</th>
                <th>Ilość</th>
                <th>Data Zamówienia</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->menu->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-primary">Edytuj</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Czy na pewno chcesz usunąć to zamówienie?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Usuń</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection