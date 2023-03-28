<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name','img', 'price', 'desc','reviews', 'old_price', 'reduction'
    ];


    static function rules () {

        return [
            'name' => 'required',
            'img' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'reduction' => 'numeric',
            'desc' => 'required',
            'reviews' => 'required|numeric|max:5|min:0',
            'total_quantity' => 'required|numeric',
        ];
    }

}
