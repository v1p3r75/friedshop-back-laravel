<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index() {


        if (!$all = Product::all()) {

            return ApiResponse::error('Error while fetching products');
        }

        return ApiResponse::success('List of products', $all->toArray());

    }


    public function show($id = null) {

        if($product = Product::find($id)) {

            return ApiResponse::success('Product Found', $product->toArray());
        }

        return ApiResponse::error('Product Not Found', [], 404);
    }


    public function create(Request $request) {

        $data = $request->all();

        $validation = validator($data, Product::rules());

        if($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all() , 400);
        }

        $imageName = $data['name'] . '-' . time() . '.' . $request->file('img')->extension();

        if($request->file('img')->storeAs('public', $imageName)) {

            $data['img'] = $imageName;

            if (! Product::create($data)) {

                return ApiResponse::error('Product creation failed', [], 500);

            }


            return ApiResponse::success('Product created successfully', $data, 201);
        }

        return ApiResponse::error('Image Upload Error', [], 403);


    }

    public function edit(Request $request) {
        
        
        $data = $request->except('id', '_method');

        if ($db_product = Product::find($request->input('id'))) {
            
            if ($request->input('imageEdited') == "true") {
                
                $imageName = $data['name'] . '-' . time() . '.' . $request->file('img')->extension();

                if($request->file('img')->storeAs('public', $imageName)) {

                    $data['img'] = $imageName;
                    
                }
            } else unset($data['img']);

            if(! $db_product->update($data)) {

                return ApiResponse::error('Product edit failed', [], );
            }

            return ApiResponse::success('Product edited successfully', $data);

        }

        return ApiResponse::error('Product not found', [$data], 404);

    }

    public function destroy(Request $request) {

        $id = $request->input('id');

        if (! empty($id)) {

            if (Product::destroy($id)) {

                return ApiResponse::success('Product deleted successfully');
            }

            return ApiResponse::error('Delete failed', []);
        }

        return ApiResponse::error('You must specify a product identifier');

    }

}
