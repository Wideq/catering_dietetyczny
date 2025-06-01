<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
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

        $menu = Menu::create($data);

        return redirect()->route('dopasowanie')->with('success', 'Danie "' . $menu->name . '" zostało dodane do menu.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $oldName = $menu->name;

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        if ($oldName !== $menu->name) {
            return redirect()->route('dopasowanie')
                ->with('info', 'Nazwa dania została zmieniona z "' . $oldName . '" na "' . $menu->name . '"');
        }

        return redirect()->route('dopasowanie')
            ->with('success', 'Danie "' . $menu->name . '" zostało zaktualizowane.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $name = $menu->name;
        $menu->delete();

        return redirect()->route('dopasowanie')
            ->with('warning', 'Danie "' . $name . '" zostało usunięte z menu.');
    }
}