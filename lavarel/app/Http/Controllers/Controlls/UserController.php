<?php

namespace App\Http\Controllers\Controlls;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    // Metoda do wyświetlania formularza rejestracji
    public function create()
    {
        return view('register'); // Widok formularza rejestracji
    }

    // Metoda do zapisywania użytkownika
    

public function store(Request $request)
{
    // Walidacja danych wejściowych
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed', // Potwierdzenie hasła
    ]);

    // Tworzenie nowego użytkownika
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // Logowanie użytkownika po rejestracji
    Auth::login($user);

    // Przekierowanie do strony po zalogowaniu (np. strona główna)
    return redirect()->route('index');
}

public function index()
{
    $users = \App\Models\User::all();
    return view('users.index', compact('users'));
}
public function edit($id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('users.edit', compact('user'));
}

public function update(UserRequest $request, $id)
{
    $user = User::findOrFail($id);
    $user->update($request->validated());

    return redirect()->route('users.index')->with('success', 'Użytkownik został zaktualizowany.');
}
public function destroy($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->delete();
    return redirect()->route('users.index')->with('success', 'Użytkownik usunięty');
}

}

