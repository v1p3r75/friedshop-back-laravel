<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(Request $request) {

        header('Content-Type: application/text');
    }

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
        
        if (! $product = Product::create($data)) {

            return ApiResponse::error('Product creation failed', [], 402);

        }


        return ApiResponse::success('Product created successfully', $data, 200);


    }

    public function edit(Request $request, Product $product) {

        $id = $request->input('product_id');
        $data = $request->except('product_id');

        if(! $product->updateOrFail([$id, $data])) {

            return ApiResponse::error('Product edit failed');
        }

        return ApiResponse::success('Product updated successfully', $data);

    }

    public function destroy(Request $request) {

        $id = $request->input('product_id');

        if (! (is_null($id) || empty($id))) {

            if (Product::deleted($id)) {

                return ApiResponse::success('Product deleted successfully');
            }

            return ApiResponse::error('Delete failed', []);
        }

        return ApiResponse::error('You must specify a product identifier');
        
    }

}
