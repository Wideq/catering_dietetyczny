Route::get('/menus', function () {
    return \App\Models\Menu::all();
});
