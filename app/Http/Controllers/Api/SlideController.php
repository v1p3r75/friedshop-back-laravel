<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlideShow;
use Illuminate\Http\Request;

class SlideController extends Controller
{

    public function index() {


        if (!$all = SlideShow::all()) {

            return ApiResponse::error('Error while fetching slideshows');
        }

        return ApiResponse::success('List of slideshows', $all->toArray());

    }


    public function show($id = null) {

        if($product = SlideShow::find($id)) {

            return ApiResponse::success('SlideShow Found', $product->toArray());
        }

        return ApiResponse::error('SlideShow Not Found', [], 404);
    }


    public function create(Request $request) {

        $data = $request->all();

        $validation = validator($data, SlideShow::rules());

        if($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all() , 400);
        }

        $imageName = $data['text'] . '-' . time() . '.' . $request->file('image')->extension();

        if($request->file('image')->storeAs('public', $imageName)) {

            $data['image'] = $imageName;

            if (! SlideShow::create($data)) {

                return ApiResponse::error('SlideShow creation failed', [], 500);

            }


            return ApiResponse::success('SlideShow created successfully', $data, 201);
        }

        return ApiResponse::error('Image Upload Error', [], 403);


    }

    public function edit(Request $request) {
        
        
        $data = $request->except('id', '_method');

        if ($db_product = SlideShow::find($request->input('id'))) {
            
            if ($request->input('imageEdited') == "true") {
                
                $imageName = $data['text'] . '-' . time() . '.' . $request->file('image')->extension();

                if($request->file('image')->storeAs('public', $imageName)) {

                    $data['image'] = $imageName;
                    
                }
            } else unset($data['image']);

            if(! $db_product->update($data)) {

                return ApiResponse::error('SlideShow edit failed', [], );
            }

            return ApiResponse::success('SlideShow edited successfully', $data);

        }

        return ApiResponse::error('SlideShow not found', [$data], 404);

    }

    public function destroy(Request $request) {

        $id = $request->input('id');

        if (! empty($id)) {

            if (SlideShow::destroy($id)) {

                return ApiResponse::success('SlideShow deleted successfully');
            }

            return ApiResponse::error('Delete failed', []);
        }

        return ApiResponse::error('You must specify a product identifier');

    }

}
