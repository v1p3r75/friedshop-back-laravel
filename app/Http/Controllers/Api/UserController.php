<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guestOnly = $request->input('guest_only');

        if ($users = $guestOnly == "true" ? User::where('admin', '0') : User::all()) {

            return ApiResponse::success('List Of Users', $users->toArray());
        }

        return ApiResponse::error('Error while fetching users', [], 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
                
        $data['password'] = Hash::make($data['password']);
        
        $user = User::create($data);
        
        if($user) {

            return ApiResponse::success('User created successfully.', [

                'user' => $user,
                '_token' => $user->createToken(env('AUTH_SECRET_KEY'))->plainTextToken

            ], 201);
        }

        
        return ApiResponse::error('User creation failed', [], 400);



    }

    public function login(Request $request) {

        $credentials = $request->only(['email', 'password']);

        $validation = validator($credentials, ['email' => 'required|email', 'password' => 'required']);

        if ($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all());
        }


        if (! Auth::attempt($credentials)) {

            return ApiResponse::error('Login error', [], 403);

        }

        if ($user = User::where('email', $request->email)->first()) {

            return ApiResponse::success('User login successful',
            ['user' => $user, '_token' => $user->createToken(env('AUTH_SECRET_KEY'))->plainTextToken]);

        }
        
        return ApiResponse::error('Login error', [], 403);


    }


    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($user = User::find($id)) {

            return ApiResponse::success('User found', $user->toArray());
        }

        return ApiResponse::error('User not found', [] , 404);

    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Request $request) {


        $data = $request->except('id', '_method', 'admin');

        if ($user = User::find($request->input('id'))) {

            if (isset($data['password'])) {

                $data['password'] = Hash::make($data['password']);
            }

            if(! $user->update($data)) {

                return ApiResponse::error('User edit failed', [], );
            }

            return ApiResponse::success('User edited successfully', $data);

        }

        return ApiResponse::error('User not found', [$data], 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');

        if (! empty($id)) {

            if (User::destroy($id)) {

                return ApiResponse::success('User deleted successfully');
            }

            return ApiResponse::error('Delete failed', []);
        }

        return ApiResponse::error('You must specify a user identifier');
    }
}
