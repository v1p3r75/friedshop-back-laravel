<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'code', 'quantity'];

    static function rules() {

        return [
            'id' => 'required|numeric',
            'code' => 'required|unique',
        ];
    }

}
