<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SlideShow;
use App\Models\User;

class UtilsController extends Controller
{
    //
    public function index() {

        try {

            $data = [
                'products' => Product::count(),
                'categories' => Category::count(),
                'customers' => User::where('admin', '=', 0)->count(),
                'slides' => SlideShow::count(),
                'admin' => User::where('admin', '=', 1) -> count(),
            ];

            return ApiResponse::success('Startistic', $data);

        }catch (\Exception $e) {

            return ApiResponse::error(message: 'Something went wrong', code: 500);
        }

    }
}
