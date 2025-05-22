<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'menu_id' => ['required', 'exists:menus,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:255'],
        ];
    }
}