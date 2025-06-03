<?php

namespace App\Http\Controllers\Controlls;

use App\Http\Controllers\Controlls\Controller;
use App\Models\DietPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Wyświetla stronę główną z dostępnymi planami dietetycznymi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dietPlans = DietPlan::where('is_active', true)->take(6)->get();
        return view('index', compact('dietPlans'));
    }
}