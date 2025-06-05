<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DietPlan;

class DietPlanSeeder extends Seeder
{
    public function run()
    {
        $dietPlans = [
            [
                'name' => 'Dieta Standard',
                'description' => 'Zbilansowana dieta dostarczająca wszystkich niezbędnych składników odżywczych. Idealna dla osób dbających o zdrowe odżywianie bez specjalnych wymagań dietetycznych.',
                'price_per_day' => 59.90,
                'icon' => 'fa-utensils',
                'is_active' => true,
            ],
            [
                'name' => 'Dieta Vegetarian',
                'description' => 'Dieta wegetariańska bogata w warzywa, owoce, produkty pełnoziarniste i roślinne źródła białka. Odpowiednia dla osób wykluczających mięso z jadłospisu.',
                'price_per_day' => 64.90,
                'icon' => 'fa-leaf',
                'is_active' => true,
            ],
            [
                'name' => 'Dieta Low Carb',
                'description' => 'Dieta niskowęglowodanowa ukierunkowana na redukcję tkanki tłuszczowej. Opiera się na zwiększonej ilości białka i tłuszczów, przy ograniczeniu węglowodanów.',
                'price_per_day' => 69.90,
                'icon' => 'fa-drumstick-bite',
                'is_active' => true,
            ],
            [
                'name' => 'Dieta Sport',
                'description' => 'Dieta dla osób aktywnych fizycznie, zawierająca zwiększoną ilość białka i węglowodanów złożonych. Wspomaga budowę masy mięśniowej i regenerację.',
                'price_per_day' => 74.90,
                'icon' => 'fa-dumbbell',
                'is_active' => true,
            ],
            [
                'name' => 'Dieta Ketogeniczna',
                'description' => 'Dieta bardzo niskowęglowodanowa z wysoką zawartością tłuszczów. Prowadzi do ketozy, w której organizm czerpie energię głównie z ketonu zamiast glukozy.',
                'price_per_day' => 79.90,
                'icon' => 'fa-bacon',
                'is_active' => true,
            ],
        ];

        foreach ($dietPlans as $plan) {
            DietPlan::create($plan);
        }
    }
}