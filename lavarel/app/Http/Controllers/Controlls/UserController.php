<?php

namespace App\Http\Controllers\Controlls;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
            $userName = $user->name;
            
            // Nie pozwól na usunięcie własnego konta
            if ($user->id === Auth::id()) {
                return redirect()->route('users.index')
                    ->with('error', 'Nie możesz usunąć własnego konta.');
            }
            
            // Sprawdź relacje z zamówieniami i transakcjami
            $ordersCount = $user->orders()->count();
            $transactionsCount = $user->transactions()->count();
            $cartItemsCount = $user->cartItems()->count() ?? 0;
            
            Log::info("Próba usunięcia użytkownika {$userName}: {$ordersCount} zamówień, {$transactionsCount} transakcji");
            
            if ($ordersCount > 0 || $transactionsCount > 0) {
                // SOFT DELETE - zachowaj użytkownika ale zablokuj dostęp
                $user->update([
                    'name' => $userName . ' (KONTO USUNIĘTE)',
                    'email' => 'deleted_user_' . $user->id . '_' . time() . '@deleted.local',
                    'password' => Hash::make(Str::random(60)), // Zablokuj logowanie
                    'email_verified_at' => null,
                    'remember_token' => null,
                ]);
                
                // Usuń avatar jeśli istnieje
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                    $user->update(['avatar' => null]);
                }
                
                return redirect()->route('users.index')
                    ->with('warning', 
                        "Użytkownik \"{$userName}\" został oznaczony jako usunięty.<br>" .
                        "📦 Zachowano {$ordersCount} zamówień<br>" .
                        "💳 Zachowano {$transactionsCount} transakcji<br>" .
                        "🔒 Konto zostało zablokowane"
                    );
                    
            } else {
                // HARD DELETE - użytkownik bez powiązanych danych
                
                // Usuń avatar
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                // Usuń elementy koszyka jeśli istnieją
                if ($cartItemsCount > 0) {
                    $user->cartItems()->delete();
                }
                
                // Usuń użytkownika
                $user->delete();
                
                return redirect()->route('users.index')
                    ->with('success', "Użytkownik \"{$userName}\" został całkowicie usunięty z systemu.");
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Błąd bazy danych przy usuwaniu użytkownika: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                return redirect()->route('users.index')
                    ->with('error', 'Nie można usunąć użytkownika - ma powiązane dane w systemie. Skontaktuj się z administratorem.');
            }
            
            return redirect()->route('users.index')
                ->with('error', 'Wystąpił błąd bazy danych podczas usuwania użytkownika.');
                
        } catch (\Exception $e) {
            Log::error('Ogólny błąd usuwania użytkownika: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Wystąpił nieoczekiwany błąd podczas usuwania użytkownika.');
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

    /**
     * Aktualizuje profil zalogowanego użytkownika
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // POPRAWIONE LOGOWANIE
        Log::info('=== PROFILE UPDATE START ===');
        Log::info('Request method: ' . $request->method());
        Log::info('All request data:', $request->all());
        Log::info('Files in request:', $request->allFiles());
        Log::info('Remove avatar value: ' . $request->input('remove_avatar', 'not set'));
        Log::info('Current user ID: ' . $user->id);
        Log::info('Current user avatar before: ' . ($user->avatar ?? 'null'));
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:8|confirmed',
                'avatar' => 'nullable|image|max:2048',
                'remove_avatar' => 'nullable|in:0,1',
            ]);
            
            Log::info('Validation passed');

            if ($request->input('remove_avatar') == '1') {
                Log::info('=== REMOVING AVATAR ===');
                Log::info('User avatar path: ' . ($user->avatar ?? 'null'));
                
                if ($user->avatar) {
                    $fullPath = storage_path('app/public/' . $user->avatar);
                    Log::info('Full file path: ' . $fullPath);
                    Log::info('File exists: ' . (file_exists($fullPath) ? 'yes' : 'no'));
                    
                    if (Storage::disk('public')->exists($user->avatar)) {
                        $deleted = Storage::disk('public')->delete($user->avatar);
                        Log::info('File deletion result: ' . ($deleted ? 'success' : 'failed'));
                    } else {
                        Log::info('File does not exist in storage');
                    }
                }
                
                $updateResult = $user->update(['avatar' => null]);
                Log::info('Database update result: ' . ($updateResult ? 'success' : 'failed'));
                
                $user->refresh();
                Log::info('User avatar after refresh: ' . ($user->avatar ?? 'null'));
                
                Log::info('=== AVATAR REMOVAL COMPLETE ===');
            }

            if ($request->hasFile('avatar') && $request->input('remove_avatar') != '1') {
                Log::info('=== UPLOADING NEW AVATAR ===');
            
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                    Log::info('Old avatar deleted: ' . $user->avatar);
                }
                
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->update(['avatar' => $avatarPath]);
                
                Log::info('New avatar uploaded: ' . $avatarPath);
            }

            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
                Log::info('Password will be updated');
            }

            $user->update($updateData);
            
            Log::info('=== FINAL STATE ===');
            Log::info('Final user avatar: ' . ($user->fresh()->avatar ?? 'null'));
            Log::info('=== PROFILE UPDATE END ===');

            return redirect()->route('profile.edit')
                ->with('success', 'Profil został zaktualizowany pomyślnie.');
                
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('profile.edit')
                ->with('error', 'Wystąpił błąd podczas aktualizacji profilu: ' . $e->getMessage());
        }
    }
} 