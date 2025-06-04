@extends('layout')

@section('title', 'Sesja wygasła')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-warning">419</h1>
    <h2 class="mb-4">Twoja sesja wygasła</h2>
    <p class="mb-4">Prosimy odświeżyć stronę i spróbować ponownie.</p>
    <p class="text-muted">Ten błąd pojawia się, gdy token bezpieczeństwa CSRF wygasł z powodu długiej nieaktywności.</p>
    <div class="mt-4">
        <a href="{{ url()->current() }}" class="btn btn-primary">Odśwież stronę</a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Wróć na stronę główną</a>
    </div>
</div>