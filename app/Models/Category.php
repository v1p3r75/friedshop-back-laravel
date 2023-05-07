<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


     protected $fillable = [
        'name','desc'
    ];


    static function rules () {

        return [
            'name' => 'required|max:20',
        ];
    }

    public function products() {

        return $this->hasMany(Product::class, 'product_id');
    }
}
