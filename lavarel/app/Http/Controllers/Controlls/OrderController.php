<?php
namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller; // Dodany brakujący import
use App\Models\Order;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'menu')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $menus = Menu::all();
        return view('orders.create', compact('users', 'menus'));
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create($request->validated());
        $userName = User::find($request->user_id)->name ?? 'Użytkownik';
        $menuName = Menu::find($request->menu_id)->name ?? 'Produkt';

        return redirect()->route('orders.index')
            ->with('success', 'Nowe zamówienie #' . $order->id . ' dla ' . $userName . ' zostało dodane.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $users = User::all();
        $menus = Menu::all();
        return view('orders.edit', compact('order', 'users', 'menus'));
    }

    public function update(OrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        
        $order->update($request->validated());
        
        if ($oldStatus !== $request->status) {
            return redirect()->route('orders.index')
                ->with('info', 'Status zamówienia #' . $order->id . ' został zmieniony z "' . 
                    $oldStatus . '" na "' . $order->status . '"');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie #' . $order->id . ' zostało zaktualizowane.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $orderNumber = $order->id;
        $userName = $order->user->name ?? 'Użytkownika';
        
        $order->delete();

        return redirect()->route('orders.index')
            ->with('warning', 'Zamówienie #' . $orderNumber . ' dla ' . $userName . ' zostało usunięte.');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:new,processing,completed,cancelled'
        ]);
        
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('orders.index')
            ->with('info', 'Status zamówienia #' . $order->id . ' został zmieniony z "' . 
                $oldStatus . '" na "' . $order->status . '"');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status === 'completed') {
            return redirect()->route('orders.index')
                ->with('error', 'Nie można anulować zrealizowanego zamówienia #' . $order->id);
        }
        
        $order->status = 'cancelled';
        $order->save();
        
        return redirect()->route('orders.index')
            ->with('warning', 'Zamówienie #' . $order->id . ' zostało anulowane.');
    }
}