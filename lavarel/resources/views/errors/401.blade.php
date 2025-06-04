@extends('layout')

@section('title', 'Wymagane uwierzytelnienie')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-warning">401</h1>
    <h2 class="mb-4">Wymagane uwierzytelnienie</h2>
    <p class="mb-4">Musisz się zalogować, aby uzyskać dostęp do tej strony.</p>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary">Zaloguj się</a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Wróć na stronę główną</a>
    </div>
</div>
@endsection