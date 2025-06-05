<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\DietPlan;
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
        
        // Obsługa filtrowania po datach
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->subMonth();
        
        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date')) 
            : Carbon::now();
            
        // Jeśli początkowa data jest późniejsza niż końcowa, zamieniamy je
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }
        
        // Filtr typu dania
        $dishTypeFilter = $request->input('dish_type');
        
        // Podstawowe statystyki
        $totalUsers = User::count();
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount') ?? 0;
        $totalMenuItems = Menu::count();
        $totalDietPlans = DietPlan::count();
        
        // Statystyki zamówień według statusu
        $orderStatusQuery = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, count(*) as count')
            ->groupBy('status');
        
        $orderStatuses = $orderStatusQuery->pluck('count', 'status')->toArray();
        
        // Formatujemy nazwy statusów do wyświetlenia
        $formattedOrderStatuses = [];
        foreach ($orderStatuses as $status => $count) {
            $statusName = match($status) {
                'new' => 'Nowe',
                'in_progress' => 'W realizacji',
                'completed' => 'Zakończone',
                'cancelled' => 'Anulowane',
                default => ucfirst($status)
            };
            $formattedOrderStatuses[$statusName] = $count;
        }
        
        // Najczęściej zamawiane dania z filtrowaniem
        $popularDishesQuery = OrderItem::join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('order_items.item_type', 'menu')
            ->whereNotNull('order_items.menu_id');
            
        if ($dishTypeFilter) {
            $popularDishesQuery->where('menus.category', $dishTypeFilter);
        }
        
        $popularDishes = $popularDishesQuery
            ->selectRaw('menus.name, SUM(order_items.quantity) as ordered')
            ->groupBy('menus.name')
            ->orderByDesc('ordered')
            ->limit(5)
            ->pluck('ordered', 'menus.name')
            ->toArray();
            
        // Jeśli brak danych, wyświetlamy puste wartości dla popularnych dań
        if (empty($popularDishes)) {
            $popularDishesQuery = Menu::query();
            
            if ($dishTypeFilter) {
                $popularDishesQuery->where('category', $dishTypeFilter);
            }
            
            $popularDishes = $popularDishesQuery
                ->select('name')
                ->limit(5)
                ->get()
                ->pluck('name')
                ->mapWithKeys(function($name) {
                    return [$name => 0];
                })
                ->toArray();
        }
        
        // Lista kategorii posiłków do filtrowania
        $mealCategories = Menu::distinct()->pluck('category')->toArray();
        
        // Statystyki numeryczne dla administratora
        $adminStats = [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalMenuItems' => $totalMenuItems,
            'totalDietPlans' => $totalDietPlans,
            'transactionCount' => Transaction::whereBetween('created_at', [$startDate, $endDate])->count(),
            'failedTransactions' => Transaction::where('status', 'failed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count()
        ];
        
        return view('dashboard', compact(
            'formattedOrderStatuses', 
            'popularDishes', 
            'adminStats',
            'startDate',
            'endDate',
            'mealCategories',
            'dishTypeFilter'
        ));
    }
}