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
        
        foreach($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
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
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => 1
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

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Twój koszyk jest pusty!');
        }
        
        $total = 0;
        
        foreach($cart as $item) {
            $total += (float)$item['price'] * (int)$item['quantity'];
        }

        try {
            // Start a database transaction
            DB::beginTransaction();
            
            Log::info('Suma koszyka: ' . $total);
            Log::info('Zawartość koszyka: ', $cart);

            // Tworzenie transakcji
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $total,
                'status' => 'completed',
                'description' => 'Zamówienie online',
                'payment_method' => 'online'
            ]);

            // Wybierz pierwszy produkt jako główny dla zamówienia (dla zachowania kompatybilności)
            $firstItemId = array_key_first($cart);
            
            // Tworzenie głównego zamówienia
            $order = Order::create([
                'user_id' => Auth::id(),
                'menu_id' => $firstItemId, 
                'quantity' => 1,
                'status' => 'new',
                'order_date' => now(),
                'transaction_id' => $transaction->id,
                'total_amount' => $total // Zapisz łączną kwotę zamówienia
            ]);

            // Dodaj wszystkie produkty jako pozycje zamówienia
            $itemCount = 0;
            $itemsTotal = 0; // Dodatkowa zmienna do weryfikacji sumy

foreach($cart as $menuId => $item) {
    $price = (float)$item['price'];
    $quantity = (int)$item['quantity'];
    $itemsTotal += $price * $quantity;
    
    OrderItem::create([
        'order_id' => $order->id,
        'menu_id' => $menuId,
        'quantity' => $quantity,
        'price' => $price
    ]);
}

            Log::info('Suma z pozycji: ' . $itemsTotal);
            
            // Upewnij się, że total_amount jest poprawnie zapisane
            // Użyj abs() i małej tolerancji ze względu na potencjalne błędy zaokrąglenia
            if (abs($itemsTotal - $total) > 0.01) {
                Log::warning('Różnica w obliczeniach sumy zamówienia!');
                // Aktualizuj sumę zamówienia
                $order->update(['total_amount' => $itemsTotal]);
            }
            // Czyszczenie koszyka
            session()->forget('cart');
            
            // Commit the transaction
            DB::commit();

            return redirect()->route('user.dashboard')
                ->with('success', "Zamówienie zostało złożone pomyślnie! Dodano $itemCount produktów do zamówienia za kwotę " . number_format($total, 2) . " zł");
                
        } catch (\Exception $e) {
            // Roll back the transaction if something goes wrong
            DB::rollBack();
            
            return redirect()->route('cart.index')
                ->with('error', 'Wystąpił błąd podczas składania zamówienia: ' . $e->getMessage());
        }
    }
}