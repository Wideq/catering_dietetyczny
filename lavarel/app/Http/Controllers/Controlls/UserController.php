<?php

namespace App\Http\Controllers\Controlls;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $users = User::paginate(10); 
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user', 
            ]);

            Auth::login($user);
            
            return redirect()->route('user.dashboard')
                           ->with('success', 'Rejestracja zakończona pomyślnie!');
        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Wystąpił błąd podczas rejestracji.'])
                        ->withInput($request->except('password'));
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user); 
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
{
    try {
        $user = User::findOrFail($id);
       
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, 
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                       ->with('success', 'Użytkownik został zaktualizowany.');
    } catch (\Exception $e) {
        Log::error('User update failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Wystąpił błąd podczas aktualizacji: ' . $e->getMessage()]);
    }
}
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $this->authorize('delete', $user); 

            if ($user->id === Auth::id()) {
                return back()->withErrors(['error' => 'Nie możesz usunąć własnego konta.']);
            }

            $user->delete();
            return redirect()->route('users.index')
                           ->with('success', 'Użytkownik został usunięty.');
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Wystąpił błąd podczas usuwania użytkownika.']);
        }
    }
    public function createByAdmin()
{
    // Sprawdź czy użytkownik ma uprawnienia admina
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'Brak uprawnień');
    }
    
    return view('users.create-admin');
}

public function storeByAdmin(Request $request)
{
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'Brak uprawnień');
    }
    $this->authorize('create', User::class);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:user,admin',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ];
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $userData['avatar'] = $path;
        }
        
        $user = User::create($userData);
        
        return redirect()->route('users.index')
                       ->with('success', 'Użytkownik został pomyślnie utworzony.');
    } catch (\Exception $e) {
        Log::error('Admin user creation failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Wystąpił błąd podczas tworzenia użytkownika.'])
                    ->withInput($request->except('password'));
    }
}
}