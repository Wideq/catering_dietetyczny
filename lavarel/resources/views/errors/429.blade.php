@extends('layout')

@section('title', 'Zbyt wiele żądań')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-warning">429</h1>
    <h2 class="mb-4">Zbyt wiele żądań</h2>
    <p class="mb-4">Przepraszamy, wysłałeś zbyt wiele żądań w krótkim czasie. Prosimy odczekać chwilę i spróbować ponownie.</p>
    <div class="mt-4">
        <a href="javascript:history.back()" class="btn btn-primary">Wróć do poprzedniej strony</a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Wróć na stronę główną</a>
    </div>
</div>
@endsectio