<?php
namespace App\Http\Controllers\Controlls;

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
    Order::create($request->validated());

    return redirect()->route('orders.index')->with('success', 'Zamówienie zostało dodane.');
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
    $order->update($request->validated());

    return redirect()->route('orders.index')->with('success', 'Zamówienie zostało zaktualizowane.');
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Zamówienie zostało usunięte.');
    }
}