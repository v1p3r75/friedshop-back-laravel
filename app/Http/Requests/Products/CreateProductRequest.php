<?php

namespace App\Http\Requests\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {

        return User::isAdmin($request->user('sanctum'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required',
            'img' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'categorie_id' => 'required|numeric',
            'reduction' => 'numeric',
            'desc' => 'required',
            'reviews' => 'required|numeric|max:5|min:0',
            'total_quantity' => 'required|numeric',
        ];
    }
}
