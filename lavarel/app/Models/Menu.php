<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'price',
        'image',
        'category',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function dietPlans()
    {
        return $this->belongsToMany(DietPlan::class, 'menu_diet_plan');
    }

    public function getCaloriesPerGramAttribute()
    {
        return $this->calories ? round($this->calories / 100, 2) : 0;
    }

    public function getMacroBalanceAttribute()
    {
        if (!$this->protein || !$this->carbs || !$this->fat) {
            return null;
        }

        $total = $this->protein + $this->carbs + $this->fat;
        return [
            'protein_percent' => round(($this->protein / $total) * 100, 1),
            'carbs_percent' => round(($this->carbs / $total) * 100, 1),
            'fat_percent' => round(($this->fat / $total) * 100, 1),
        ];
    }
}