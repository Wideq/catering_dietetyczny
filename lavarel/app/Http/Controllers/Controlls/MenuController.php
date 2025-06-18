<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
        $menus = Menu::where('is_active', true)
                 ->orderBy('created_at', 'desc')
                 ->paginate(12);
    } else {
    $menus = Menu::orderBy('is_active', 'desc')
                 ->orderBy('created_at', 'desc')
                 ->paginate(12);
    }      
        return view('dopasowanie', compact('menus'));
    }

    public function create()
    {
        return view('add-menu');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'calories' => 'nullable|integer|min:0|max:2000',
            'protein' => 'nullable|numeric|min:0|max:100',
            'carbs' => 'nullable|numeric|min:0|max:200',
            'fat' => 'nullable|numeric|min:0|max:100',
            'fiber' => 'nullable|numeric|min:0|max:50',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Menu::create($validatedData);

        return redirect()->route('dopasowanie')
            ->with('success', 'Danie "' . $validatedData['name'] . '" zostało dodane do menu.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'calories' => 'nullable|numeric|min:0|max:2000',
            'protein' => 'nullable|numeric|min:0|max:100',
            'carbs' => 'nullable|numeric|min:0|max:200',
            'fat' => 'nullable|numeric|min:0|max:100',
            'fiber' => 'nullable|numeric|min:0|max:50',
            'remove_image' => 'nullable|in:0,1', 
        ]);

        if ($request->input('remove_image') == '1') {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $validatedData['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        unset($validatedData['remove_image']);

        $menu->update($validatedData);

        return redirect()->route('dopasowanie')
            ->with('success', 'Danie "' . $menu->name . '" zostało zaktualizowane.');
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $name = $menu->name;
            
            // Sprawdź czy danie jest używane w zamówieniach
            $orderItemsCount = OrderItem::where('menu_id', $id)->count();
            
            if ($orderItemsCount > 0) {
                // SOFT DELETE - oznacz jako nieaktywne zamiast usuwania
                $menu->update([
                    'name' => $name . ' (USUNIĘTE)',
                    'description' => $menu->description . "\n\n--- DANIE ZOSTAŁO USUNIĘTE ---",
                    'is_active' => false // Dodaj tę kolumnę do migracji jeśli nie istnieje
                ]);
                
                return redirect()->route('dopasowanie')
                    ->with('warning', 
                        "Danie \"{$name}\" zostało oznaczone jako usunięte.<br>" .
                        "📦 Zachowano powiązania z {$orderItemsCount} zamówieniami<br>" .
                        "🔒 Danie nie będzie już widoczne dla użytkowników"
                    );
                    
            } else {
                // HARD DELETE - usuń całkowicie
                
                // Usuń zdjęcie z dysku
                if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                    Storage::disk('public')->delete($menu->image);
                }
                
                // Usuń danie z bazy
                $menu->delete();
                
                return redirect()->route('dopasowanie')
                    ->with('success', "Danie \"{$name}\" zostało całkowicie usunięte z menu.");
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Błąd bazy danych przy usuwaniu dania: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                return redirect()->route('dopasowanie')
                    ->with('error', 'Nie można usunąć tego dania - jest używane w zamówieniach. Danie zostało oznaczone jako nieaktywne.');
            }
            
            return redirect()->route('dopasowanie')
                ->with('error', 'Wystąpił błąd bazy danych podczas usuwania dania.');
                
        } catch (\Exception $e) {
            Log::error('Ogólny błąd usuwania dania: ' . $e->getMessage());
            return redirect()->route('dopasowanie')
                ->with('error', 'Wystąpił nieoczekiwany błąd podczas usuwania dania.');
        }
    }
}