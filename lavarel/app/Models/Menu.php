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
        'fiber',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'calories' => 'integer',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scope dla aktywnych dań
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relacje
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function dietPlans()
    {
        return $this->belongsToMany(DietPlan::class, 'menu_diet_plan');
    }
}