<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }
        
        $statsData = [
            'users' => User::count(),
            'orders' => Order::count(),
            'menu' => Menu::count()
        ];

        $orderStatuses = [
            'Nowe' => Order::where('status', 'new')->count(),
            'W realizacji' => Order::where('status', 'in_progress')->count(),
            'Zakończone' => Order::where('status', 'completed')->count(),
            'Anulowane' => Order::where('status', 'cancelled')->count()
        ];

        $popularDishes = Order::select('menus.name', DB::raw('count(*) as total'))
            ->join('menus', 'orders.menu_id', '=', 'menus.id')
            ->groupBy('menu_id', 'menus.name')
            ->orderBy('total', 'desc')
            ->limit(5) 
            ->pluck('total', 'menus.name')
            ->toArray();

        if (empty($popularDishes)) {
            $popularDishes = Menu::select('name')
                ->limit(5)
                ->get()
                ->pluck('name')
                ->mapWithKeys(function($name) {
                    return [$name => 0];
                })
                ->toArray();
        }

        $adminStats = [
            'transactionCount' => Transaction::count(),
            'failedTransactions' => Transaction::where('status', 'failed')->count()
        ];

        return view('dashboard', compact('statsData', 'orderStatuses', 'popularDishes', 'adminStats'));
    }
}