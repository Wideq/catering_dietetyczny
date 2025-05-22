@extends('layout')

@section('title', 'Edytuj Menu')

@section('content')
<div class="container">
    <h2 class="mb-4">Edytuj Menu</h2>
    <form method="POST" action="{{ route('menu.update', $menu->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $menu->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $menu->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Cena</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $menu->price }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Zdjęcie</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Zapisz</button>
    </form>
</div>
@endsection