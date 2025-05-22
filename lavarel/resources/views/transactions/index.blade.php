@extends('layout')

@section('title', 'Lista Transakcji')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Lista Transakcji</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kwota</th>
                <th>Opis</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ number_format($transaction->amount, 2) }} zł</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->status }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-primary">Edytuj</a>
                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Czy na pewno chcesz usunąć tę transakcję?')">
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