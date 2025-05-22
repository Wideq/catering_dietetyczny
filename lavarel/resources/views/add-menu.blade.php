@extends('layout')

@section('title', 'Dodaj danie do menu')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Dodaj danie do menu</h1>
    <form method="POST" action="{{ route('menu.create') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa dania</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Cena (zł)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Zdjęcie</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Dodaj danie</button>
    </form>
</div>
@endsection