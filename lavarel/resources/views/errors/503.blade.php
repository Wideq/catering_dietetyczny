@extends('layout')

@section('title', 'Serwis niedostępny')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 text-primary">503</h1>
    <h2 class="mb-4">Serwis tymczasowo niedostępny</h2>
    <p class="mb-4">Przepraszamy, serwis jest tymczasowo niedostępny z powodu prac konserwacyjnych lub aktualizacji.</p>
    <p>Prosimy spróbować ponownie za kilka minut.</p>
    
    @if(isset($exception) && $exception->getMessage())
        <div class="alert alert-info mt-4">
            <p>{{ $exception->getMessage() }}</p>
        </div>
    @endif
    
    <div class="mt-4">
        <a href="{{ url()->current() }}" class="btn btn-primary">Odśwież stronę</a>
    </div>
</div>
@endsection