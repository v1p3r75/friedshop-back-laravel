<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name','img', 'price', 'desc','reviews', 'old_price', 'reduction', 'total_quantity', 'categorie_id'
    ];

    public function category() {

        return $this->belongsTo(Category::class, 'categorie_id');
    }

}
