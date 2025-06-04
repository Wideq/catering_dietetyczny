@extends('layout')

@section('title', 'Strona nie znaleziona')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-danger">404</h1>
    <h2 class="mb-4">Ups! Strona nie została znaleziona.</h2>
    <p class="mb-4">Wygląda na to, że strona, której szukasz, nie istnieje lub została przeniesiona.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Wróć na stronę główną</a>
</div>
@endsection