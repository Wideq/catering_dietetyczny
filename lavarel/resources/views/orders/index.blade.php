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
                <td>{{ $order->user ? $order->user->name : 'Usuniętego użytkownika' }}</td>
                <td>
                    @if($order->menu)
                        {{ $order->menu->name }}
                    @elseif($order->items && $order->items->count() > 0)
                        <ul class="mb-0">
                            @foreach($order->items as $item)
                                @if($item->item_type == 'diet_plan' && $item->dietPlan)
                                    <li>{{ $item->dietPlan->name }} (dieta)</li>
                                @elseif($item->menu)
                                    <li>{{ $item->menu->name }}</li>
                                @else
                                    <li>Usunięty produkt</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Usunięte menu</span>
                    @endif
                </td>
                <td>{{ $order->quantity }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y H:i') }}</td>
                <td>
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
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
                            @case('cancelled')
                                Anulowane
                                @break
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </span>
                </td>
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