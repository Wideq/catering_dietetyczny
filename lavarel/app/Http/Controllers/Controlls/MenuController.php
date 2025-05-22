<?php

namespace App\Http\Controllers\Controlls;

use App\Models\Menu;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    public function index()
    {
        // Pobierz wszystkie dania z tabeli menus
        $menus = Menu::all();

        // Przekaż dane do widoku
        return view('dopasowanie', compact('menus'));
    }

    public function create()
    {
        return view('add-menu');
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('dopasowanie')->with('success', 'Danie zostało dodane do menu.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('dopasowanie')->with('success', 'Menu zostało zaktualizowane.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('dopasowanie')->with('success', 'Menu zostało usunięte.');
    }
}