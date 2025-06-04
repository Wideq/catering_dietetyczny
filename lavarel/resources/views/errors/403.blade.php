@extends('layout')

@section('title', 'Brak dostępu')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-warning">403</h1>
    <h2 class="mb-4">Nie masz uprawnień do tej strony.</h2>
    <p class="mb-4">Jeśli uważasz, że to błąd, skontaktuj się z administratorem.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Wróć na stronę główną</a>
</div>
@endsection