<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controlls\MenuController;
use App\Http\Controllers\Controlls\TransactionController;
use App\Http\Controllers\Controlls\OrderController;
use App\Http\Controllers\Controlls\DashboardController;
use App\Http\Controllers\Controlls\UserController;
use App\Http\Controllers\Controlls\UserDashboardController;
use App\Http\Controllers\Controlls\CartController;
use App\Http\Controllers\Controlls\DietPlanController;
use App\Http\Controllers\Controlls\HomeController;
use Illuminate\Support\Facades\Hash;

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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [UserController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

// ==================== Zarządzanie użytkownikami ====================

Route::middleware(['auth'])->group(function () {
    // Lista użytkowników
    Route::get('/users', function () {
        $users = User::all(); 
        return view('users.index', compact('users')); 
    })->name('users.index');

    // Edycja użytkownika
    Route::get('/users/edit/{id}', function ($id) {
        $user = User::findOrFail($id); 
        return view('users.edit', compact('user')); 
    })->name('users.edit');

    // Aktualizacja użytkownika
    Route::put('/users/update/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    
    // Walidacja
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string|in:user,admin',
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    
    // Podstawowe dane
    $updateData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
    ];
    
    // Dodaj hasło tylko jeśli zostało podane
    if (!empty($validated['password'])) {
        $updateData['password'] = Hash::make($validated['password']);
    }
    
    $user->update($updateData);
    
    return redirect()->route('users.index')->with('success', 'Dane użytkownika zostały zaktualizowane.');
})->name('users.update');

    // Usuwanie użytkownika
    Route::delete('/users/{id}', function ($id) {
        $user = User::findOrFail($id); 
        $user->delete(); 
        return redirect()->route('users.index')->with('success', 'Użytkownik został usunięty.');
    })->name('users.destroy');
});

// ==================== Zarządzanie menu ====================

// Public menu route
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Admin menu management routes
Route::middleware(['auth'])->group(function () {
    Route::get('add-menu', [MenuController::class, 'create'])->name('menu.create');
    Route::post('add-menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
});

// ==================== Zarządzanie transakcjami ====================

Route::middleware(['auth'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

// ==================== Zarządzanie zamówieniami ====================

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/user/userdashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::put('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menuItem}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Dodaj te trasy w pliku routes/web.php
Route::middleware(['auth'])->group(function () {
    
    Route::resource('diet-plans', DietPlanController::class);
    Route::get('diet-plans/{dietPlan}/manage-menu', [DietPlanController::class, 'manageMenu'])->name('diet-plans.manage-menu');
    Route::put('diet-plans/{dietPlan}/update-menu', [DietPlanController::class, 'updateMenu'])->name('diet-plans.update-menu');
});

Route::get('diet-plans/{dietPlan}', [DietPlanController::class, 'show'])->name('diet-plans.show');

// Zaktualizuj trasę strony głównej (zastąp obecną implementację, około linii 23)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menuItem}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/add-advanced', [CartController::class, 'addAdvanced'])->name('cart.addAdvanced'); 
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/create', [UserController::class, 'createByAdmin'])->name('users.create-admin');
    Route::post('/users/store', [UserController::class, 'storeByAdmin'])->name('users.store-admin');
});
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::put('/user/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
});