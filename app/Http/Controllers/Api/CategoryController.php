<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {


        if (!$all = Category::all()) {

            return ApiResponse::error('Error while fetching categories');
        }

        return ApiResponse::success('List of categories', $all->toArray());

    }


    public function show($id = null) {

        if($category = Category::find($id)) {

            $category = [$category -> toArray(), 'products' => $category->products()];

            return ApiResponse::success('Category Found', $category);
        }

        return ApiResponse::error('Category Not Found', [], 404);
    }


    public function create(Request $request) {

        $data = $request->all();

        $validation = validator($data, Category::rules());

        if($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all() , 400);
        }

        if (! Category::create($data)) {

            return ApiResponse::error('Category creation failed', [], 500);

        }

        return ApiResponse::success('Category created successfully', $data, 201);


    }

    public function edit(Request $request) {


        $data = $request->except('id', '_method');

        if ($db_cateogry = Category::find($request->input('id'))) {

            if(! $db_cateogry->update($data)) {

                return ApiResponse::error('Category edit failed', [], );
            }

            return ApiResponse::success('Category edited successfully', $data);

        }

        return ApiResponse::error('Category not found', [$data], 404);

    }

    public function destroy(Request $request) {

        $id = $request->input('id');

        if (! empty($id)) {

            if (Category::destroy($id)) {

                return ApiResponse::success('Category deleted successfully');
            }

            return ApiResponse::error('Delete failed', []);
        }

        return ApiResponse::error('You must specify a category identifier');

    }

}
