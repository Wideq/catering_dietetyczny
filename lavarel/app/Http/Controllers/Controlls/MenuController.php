<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // Paginacja - 12 elementów na stronę
        $menus = Menu::orderBy('created_at', 'desc')->paginate(12);
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

    // W metodzie update dodaj obsługę usuwania zdjęć:

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
        $menu = Menu::findOrFail($id);
        $name = $menu->name;
        
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        
        $menu->delete();

        return redirect()->route('dopasowanie')
            ->with('warning', 'Danie "' . $name . '" zostało usunięte z menu.');
    }
}