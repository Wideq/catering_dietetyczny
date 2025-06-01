<?php

namespace App\Http\Controllers\Controlls;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $orders = Order::where('user_id', $user->id)
                 ->with(['items.menu', 'transaction'])
                 ->orderBy('created_at', 'desc')
                 ->get();
    
    return view('user.userdashboard', compact('user', 'orders'));
}

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'Nieprawidłowe aktualne hasło']);
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        User::where('id', Auth::id())->update($updateData);

        return back()->with('success', 'Profil został zaktualizowany');
    }
}