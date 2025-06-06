<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'diet_plan_id',
        'quantity',
        'price',
        'item_type',
        'duration',
        'start_date',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }
}