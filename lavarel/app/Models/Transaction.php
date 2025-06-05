<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'amount', 
        'description', 
        'status',
        'payment_method'
    ];

    public function user()
{
    return $this->belongsTo(User::class)->withDefault([
        'name' => 'Usunięty użytkownik'
    ]);
}

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}