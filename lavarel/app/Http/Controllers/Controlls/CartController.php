<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
{
    $cartItems = session()->get('cart', []);
    $total = 0;
    
    $updated = false;
    foreach($cartItems as $id => $item) {
        if (!isset($item['type'])) {
            $cartItems[$id]['type'] = 'menu'; 
            $updated = true;
        }
        $total += $item['price'] * $item['quantity'];
    }
    
    if ($updated) {
        session()->put('cart', $cartItems);
    }

    return view('cart.index', compact('cartItems', 'total'));
}

    public function add(Menu $menuItem, Request $request)
{
    $cart = session()->get('cart', []);
    
    if(isset($cart[$menuItem->id])) {
        $cart[$menuItem->id]['quantity']++;
    } else {
        $cart[$menuItem->id] = [
            'id' => $menuItem->id, 
            'name' => $menuItem->name,
            'price' => $menuItem->price,
            'quantity' => 1,
            'type' => 'menu', 
            'image' => $menuItem->image ? asset('storage/' . $menuItem->image) : null,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Produkt dodany do koszyka!');
}

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produkt usunięty z koszyka!');
    }

    public function checkout(Request $request)
{
    if (!session()->has('cart') || count(session('cart')) == 0) {
        return redirect()->route('cart.index')->with('error', 'Twój koszyk jest pusty');
    }

    try {
        DB::enableQueryLog();
        
        $cart = session()->get('cart');
        $total = 0;
        
        Log::info('Zawartość koszyka przed przetwarzaniem:', $cart);

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        Log::info('Suma koszyka: ' . $total);

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $total,
                'status' => 'completed', 
                'description' => 'Zamówienie online',
                'payment_method' => 'online' 
            ]);

            $order = Order::create([
                'user_id' => Auth::id(),
                'menu_id' => null, 
                'quantity' => 1,
                'status' => 'new',
                'order_date' => now(),
                'transaction_id' => $transaction->id,
                'total_amount' => $total
            ]);

            $itemCount = 0;

            foreach($cart as $id => $item) {
    if (!isset($item['price']) || !isset($item['quantity'])) {
        Log::warning('Niepełny element koszyka, pomijam: ' . json_encode($item));
        continue;
    }
    
    $price = (float)$item['price'];
    $quantity = (int)$item['quantity'];
    
    $itemType = isset($item['type']) ? $item['type'] : 'menu';
    
    if ($itemType === 'diet_plan') {
        if (!isset($item['id']) || !isset($item['duration']) || !isset($item['start_date'])) {
            Log::warning('Brak wymaganych danych dla diety: ' . json_encode($item));
            continue;
        }
        
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => null,
            'diet_plan_id' => $item['id'],
            'quantity' => 1,
            'price' => $price,
            'item_type' => 'diet_plan',
            'duration' => $item['duration'],
            'start_date' => $item['start_date'],
            'notes' => $item['notes'] ?? null
        ]);
        $itemCount++;
    } else {
        if (!isset($item['id'])) {
            Log::warning('Brak ID menu dla elementu koszyka: ' . json_encode($item));
            continue;
        }
        
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $item['id'],
            'diet_plan_id' => null,
            'quantity' => $quantity,
            'price' => $price,
            'item_type' => 'menu'
        ]);
        $itemCount += $quantity;
    }
}

            session()->forget('cart');
            
            DB::commit();

            return redirect()->route('user.dashboard')
                ->with('success', "Zamówienie zostało złożone pomyślnie! Zawiera $itemCount pozycji na łączną kwotę " . number_format($total, 2) . " zł");
                
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    } catch (\Exception $e) {
        Log::error('Exception during checkout: ' . $e->getMessage());
        Log::error('Exception trace: ' . $e->getTraceAsString());
        
        if (DB::transactionLevel() > 0) {
            DB::rollBack();
        }
        
        Log::error('Last executed queries: ', DB::getQueryLog());
        
        if (config('app.debug')) {
            return redirect()->route('cart.index')
                ->with('error', 'Błąd: ' . $e->getMessage());
        } else {
            return redirect()->route('cart.index')
                ->with('error', 'Wystąpił błąd podczas przetwarzania zamówienia. Prosimy spróbować ponownie.');
        }
    }
}
    public function addAdvanced(Request $request)
{
    $validatedData = $request->validate([
        'diet_plan_id' => 'required_if:item_type,diet_plan|exists:diet_plans,id',
        'menu_id' => 'required_if:item_type,menu|exists:menus,id',
        'item_type' => 'required|in:diet_plan,menu',
        'duration' => 'required_if:item_type,diet_plan|integer|min:1',
        'start_date' => 'required_if:item_type,diet_plan|date|after:today',
        'notes' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required_if:item_type,menu|integer|min:1',
    ]);

    if (!session()->has('cart')) {
        session()->put('cart', []);
    }
    
    $cart = session()->get('cart');

    if ($validatedData['item_type'] === 'diet_plan') {
        $dietPlan = \App\Models\DietPlan::findOrFail($validatedData['diet_plan_id']);
        
        $cartItemId = 'diet_' . $dietPlan->id . '_' . time();
        
        $cart[$cartItemId] = [
            'id' => $dietPlan->id,
            'type' => 'diet_plan',
            'name' => $dietPlan->name,
            'price' => $validatedData['price'],
            'quantity' => 1, 
            'duration' => $validatedData['duration'],
            'start_date' => $validatedData['start_date'],
            'notes' => $validatedData['notes'] ?? '',
            'image' => $dietPlan->image ? asset('storage/' . $dietPlan->image) : null,
        ];
    } else {
        $menuId = $validatedData['menu_id'];
        $menu = \App\Models\Menu::findOrFail($menuId);
        
        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += $validatedData['quantity'];
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'type' => 'menu',
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => $validatedData['quantity'],
                'image' => $menu->image ? asset('storage/' . $menu->image) : null,
            ];
        }
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.index')->with('success', 'Produkt został dodany do koszyka');
}
}