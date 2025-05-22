@extends('layout')

@section('title', 'Edytuj Transakcję')

@section('content')
<div class="container">
    <h2 class="mb-4">Edytuj Transakcję</h2>
    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="amount" class="form-label">Kwota</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $transaction->amount }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $transaction->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Oczekująca</option>
                <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Zakończona</option>
                <option value="failed" {{ $transaction->status == 'failed' ? 'selected' : '' }}>Nieudana</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Zapisz</button>
    </form>
</div>
@endsection