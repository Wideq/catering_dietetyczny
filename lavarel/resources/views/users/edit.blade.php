@extends('layout')

@section('content')
<div class="container">
    <h2>Edytuj użytkownika</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Imię</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
    </div>

    <button type="submit" class="btn btn-primary">Zapisz</button>
</form>
</div>
@endsection
