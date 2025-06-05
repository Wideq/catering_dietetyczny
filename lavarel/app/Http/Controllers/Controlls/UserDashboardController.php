<?php

namespace App\Http\Controllers\Controlls;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\User;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with(['items.menu', 'items.dietPlan', 'menu'])
                      ->where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('user.userdashboard', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '_' . $avatar->getClientOriginalName();
            
            // Store avatar
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $updateData['avatar'] = $path;
            
            // Remove old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }

        // Handle password change
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Aktualne hasło jest wymagane do zmiany hasła']);
            }
            
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Nieprawidłowe aktualne hasło']);
            }
            
            $updateData['password'] = Hash::make($request->new_password);
        }

        // Update user data
        $user->fill($updateData);
        $user->save();
        
        return back()->with('success', 'Profil został pomyślnie zaktualizowany');
    }
}