<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\Category;
use App\Models\Command;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    //

    public function create(Request $request) {

        $data = $request->all();

        $validation = validator($data, Command::rules());

        if($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all() , 400);
        }

        return ApiResponse::success('Category created successfully', $data, 201);
    }
}
