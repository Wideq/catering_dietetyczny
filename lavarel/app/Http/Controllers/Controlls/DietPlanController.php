<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\DietPlan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Ensure MenuItem model exists and is imported
class DietPlanController extends Controller
{
    public function index()
    {
        $dietPlans = DietPlan::all();
        return view('diet-plans.index', compact('dietPlans'));
    }

    public function create()
    {
        return view('diet-plans.create');
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price_per_day' => 'required|numeric|min:0',
        'icon' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $dietPlan = new DietPlan();
    $dietPlan->name = $validated['name'];
    $dietPlan->description = $validated['description'];
    $dietPlan->price_per_day = $validated['price_per_day'];
    $dietPlan->icon = $validated['icon'] ?? 'fa-utensils';
    $dietPlan->is_active = $request->has('is_active');

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('diet-plans', 'public');
        $dietPlan->image = $path;
    }

    $dietPlan->save();

    return redirect()->route('diet-plans.index')
        ->with('success', 'Dieta została dodana pomyślnie!');
    }

    public function edit(DietPlan $dietPlan)
    {
        return view('diet-plans.edit', compact('dietPlan'));
    }

    public function update(Request $request, DietPlan $dietPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('diet-plans', 'public');
        }

        $dietPlan->update($validated);

        return redirect()->route('diet-plans.index')
            ->with('success', 'Plan diety "' . $dietPlan->name . '" został zaktualizowany.');
    }

    public function destroy(DietPlan $dietPlan)
    {
        $name = $dietPlan->name;
        $dietPlan->delete();

        return redirect()->route('diet-plans.index')
            ->with('warning', 'Plan diety "' . $name . '" został usunięty.');
    }

    /**
     * Pokaż widok zarządzania menu dla diety
     */
    public function manageMenu(DietPlan $dietPlan)
{
    // Pobierz wszystkie pozycje menu
    $menuItems = Menu::orderBy('category')->get();
    $selectedMenuItems = $dietPlan->menuItems()->pluck('menus.id')->toArray();
    
    // Oblicz sumę cen wybranych pozycji menu
    $totalMealsPrice = 0;
    foreach($selectedMenuItems as $itemId) {
        $menuItem = $menuItems->find($itemId);
        if ($menuItem) {
            $totalMealsPrice += $menuItem->price;
        }
    }
    
    // Oblicz rabat (możesz dostosować tę logikę)
    $discount = 0;
    $count = count($selectedMenuItems);
    if ($count >= 5 && $count < 10) {
        $discount = $totalMealsPrice * 0.10; // 10% rabatu
    } else if ($count >= 10) {
        $discount = $totalMealsPrice * 0.15; // 15% rabatu
    }
    
    return view('diet-plans.manage-menu', compact('dietPlan', 'menuItems', 'selectedMenuItems'));
}

public function updateMenu(Request $request, DietPlan $dietPlan)
{
    // Aktualizuj przypisane pozycje menu
    $dietPlan->menuItems()->sync($request->menu_items ?? []);
    
    // Aktualizuj cenę jeśli została przekazana
    if ($request->has('price_per_day')) {
        $dietPlan->price_per_day = $request->price_per_day;
        $dietPlan->save();
    }
    
    return redirect()->route('diet-plans.index')
        ->with('success', 'Menu diety zostało zaktualizowane pomyślnie!');
}

public function show(DietPlan $dietPlan)
{
    // Upewnij się, że wyświetlamy tylko aktywne diety dla zwykłych użytkowników
    $user = Auth::user();
    if (!$user || $user->role !== 'admin') {
        if (!$dietPlan->is_active) {
            abort(404);
        }
    }
    
    return view('diet-plans.show', compact('dietPlan'));
}
}


