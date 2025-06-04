<?php
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

    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_diet_plan')
                    ->withTimestamps();
    }

    public function getMenuByCategories()
    {
        $menus = $this->menuItems;
        
        return [
            'śniadanie' => $menus->where('category', 'śniadanie'),
            'drugie śniadanie' => $menus->where('category', 'drugie śniadanie'),
            'obiad' => $menus->where('category', 'obiad'),
            'podwieczorek' => $menus->where('category', 'podwieczorek'),
            'kolacja' => $menus->where('category', 'kolacja'),
        ];
    }
    
    public function getMenuByCategory(string $category)
    {
        return $this->menuItems()->where('category', $category)->get();
    }
}