<?php
// filepath: c:\Users\kosow\Desktop\catering_dietetyczny\lavarel\app\Models\Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category'
    ];

    public function dietPlans(): BelongsToMany
{
    return $this->belongsToMany(DietPlan::class, 'menu_diet_plan')
                ->withTimestamps();
}
}