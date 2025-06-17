<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Menu;
use App\Models\DietPlan;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }

        $dateRange = $request->input('date_range', '30');
        $dishTypeFilter = $request->input('dish_type');
        
        $startDate = match($dateRange) {
            '7' => Carbon::now()->subDays(7),
            '14' => Carbon::now()->subDays(14), 
            '30' => Carbon::now()->subDays(30),
            '90' => Carbon::now()->subDays(90),
            default => Carbon::now()->subDays(30),
        };
        
        $endDate = Carbon::now();

        $totalUsers = User::count();
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');
        $totalMenuItems = Menu::count();
        $totalDietPlans = DietPlan::count();

        $dailyRevenue = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        $revenueData = [];
        foreach ($period as $date) {
            $dateKey = $date->format('d.m');
            $fullDateKey = $date->format('Y-m-d');
            $revenueData[$dateKey] = $dailyRevenue[$fullDateKey] ?? 0;
        }

        $popularDishesQuery = OrderItem::join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.menu_id');
            
        if ($dishTypeFilter) {
            $popularDishesQuery->where('menus.category', $dishTypeFilter);
        }
        
        $popularDishes = $popularDishesQuery
            ->selectRaw('menus.name, SUM(order_items.quantity) as ordered')
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('ordered')
            ->limit(5)
            ->pluck('ordered', 'menus.name')
            ->toArray();
            
        if (empty($popularDishes)) {
            $popularDishes = [
                'Kurczak z ryżem' => 0,
                'Sałatka grecka' => 0,
                'Pasta bolognese' => 0,
                'Smoothie owocowe' => 0,
                'Kanapki' => 0
            ];
        }

        $recentOrders = Order::with(['user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('dashboard', compact(
            'totalUsers',
            'totalOrders', 
            'totalRevenue',
            'totalMenuItems',
            'totalDietPlans',
            'revenueData',
            'popularDishes',
            'dateRange',
            'dishTypeFilter',
            'recentOrders'
        ));
    }
}