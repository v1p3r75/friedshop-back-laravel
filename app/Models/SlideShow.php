<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    use HasFactory;

    protected $table = 'slideshows';

    protected $fillable = ['image', 'text'];

    static function rules () {

        return [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'text' => 'required'
        ];
    }
}
