<?php
// filepath: c:\Users\kosow\Desktop\catering_dietetyczny\lavarel\app\Models\DietPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DietPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price_per_day', 
        'icon',
        'image',
        'is_active'
    ];

    /**
     * Relacja z menu - dania wchodzące w skład diety
     */
    public function menuItems(): BelongsToMany
{
    return $this->belongsToMany(Menu::class, 'menu_diet_plan')
                ->withPivot('meal_type', 'day')
                ->withTimestamps();
}

    /**
     * Pobierz dania na konkretny dzień
     */
    public function getMenuForDay(int $day)
    {
        return $this->menuItems()
                    ->wherePivot('day', $day)
                    ->orderByPivot('meal_type')
                    ->get();
    }

    /**
     * Pobierz dania dla konkretnego posiłku (np. śniadanie) na wszystkie dni
     */
    public function getMenuForMealType(string $mealType)
    {
        return $this->menuItems()
                    ->wherePivot('meal_type', $mealType)
                    ->orderByPivot('day')
                    ->get();
    }
}