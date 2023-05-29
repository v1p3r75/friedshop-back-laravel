<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCommands extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity', 'command_id'];

    static function rules() {

        return [

            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'command' => 'required|numeric'
        ];
    }

    public function products() {

        return $this->hasMany(Product::class);
    }

    public function commands() {

        return $this->hasMany(Command::class);
    }
}

