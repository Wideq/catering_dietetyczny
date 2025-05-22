<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controlls\MenuController;
use App\Http\Controllers\Controlls\TransactionController;
use App\Http\Controllers\Controlls\OrderController;

// ==================== Strona główna i statyczne strony ====================

// Strona główna
Route::get('/', function () {
    return view('index');
})->name('home');

// Cennik
Route::get('/cennik', function () {
    return view('cennik');
})->name('pricing');

// Dopasowanie diety
Route::get('/dopasowanie', [MenuController::class, 'index'])->name('dopasowanie');

// Dostawa
Route::get('/dostawa', function () {
    return view('dostawa'); 
})->name('delivery');

// ==================== Dashboard ====================

// Dashboard (zabezpieczony, np. po zalogowaniu)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== Profile użytkownika ====================

Route::middleware('auth')->group(function () {
    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/user/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== Logowanie i wylogowanie ====================

// Logowanie
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Wylogowanie
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ==================== Rejestracja użytkownika ====================

// Formularz rejestracji
Route::get('/register', [App\Http\Controllers\Controlls\UserController::class, 'create'])->name('register');

// Obsługa rejestracji
Route::post('/register', [App\Http\Controllers\Controlls\UserController::class, 'store'])->name('register.store');

// ==================== Zarządzanie użytkownikami ====================

// Lista użytkowników
Route::get('/users', function () {
    $users = User::all(); 
    return view('users.index', compact('users')); 
})->middleware('auth')->name('users.index');

// Edycja użytkownika (z ID)
Route::get('/users/edit/{id}', function ($id) {
    $user = User::findOrFail($id); 
    return view('users.edit', compact('user')); 
})->middleware('auth')->name('users.edit');

// Aktualizacja użytkownika
Route::put('/users/update/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->only(['name', 'email']));
    return redirect()->route('users.index')->with('success', 'Dane użytkownika zostały zaktualizowane.');
})->middleware('auth')->name('users.update');

// Usuwanie użytkownika
Route::delete('/users/{id}', function ($id) {
    $user = User::findOrFail($id); 
    $user->delete(); 
    return redirect()->route('users.index')->with('success', 'Użytkownik został usunięty.');
})->middleware('auth')->name('users.destroy');

// ==================== Zarządzanie menu ====================

// Formularz dodawania dania do menu
Route::get('add-menu', [MenuController::class, 'create'])->middleware('auth')->name('menu.create');

// Zapis nowego dania do menu
Route::post('add-menu', [MenuController::class, 'store'])->middleware('auth')->name('menu.store');

// Edycja dania w menu
Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');

// Usuwanie dania z menu
Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

// ==================== Zarządzanie transakcjami ====================

// Lista transakcji
Route::get('/transactions', [TransactionController::class, 'index'])->middleware('auth')->name('transactions.index');

// Edycja transakcji
Route::get('/transactions/edit/{id}', [TransactionController::class, 'edit'])->middleware('auth')->name('transactions.edit');

// Aktualizacja transakcji
Route::put('/transactions/update/{id}', [TransactionController::class, 'update'])->middleware('auth')->name('transactions.update');

// Usuwanie transakcji
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->middleware('auth')->name('transactions.destroy');

// ==================== Zarządzanie zamówieniami ====================

// Lista zamówień
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');

// Formularz dodawania zamówienia
Route::get('/orders/create', [OrderController::class, 'create'])->middleware('auth')->name('orders.create');

// Zapis nowego zamówienia
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth')->name('orders.store');

// Formularz edycji zamówienia
Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->middleware('auth')->name('orders.edit');

// Aktualizacja zamówienia
Route::put('/orders/update/{id}', [OrderController::class, 'update'])->middleware('auth')->name('orders.update');

// Usuwanie zamówienia
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('auth')->name('orders.destroy');