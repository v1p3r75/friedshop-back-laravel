<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guestOnly = $request->input('guest_only')

        if ($users = $guestOnly == "true" ? User::where('admin', '0') : User::all()) {

            return ApiResponse::success('List Of Users', $users->toArray());
        }

        return ApiResponse::error('Error while fetching users', [], 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $validation = validator($data, User::rules());

        if (! $validation->fails()) {

            $data['password'] = Hash::make($data['password']);

            //$data['api_token'] = Str::random(60);

            if($user = User::create($data)) {

                return ApiResponse::success('User created successfully', [$user, $user->createToken(env('AUTH_SECRET_KEY'))->plainTextToken], 201);
            }

            return ApiResponse::error('User creation failed', [], 400);

        }

        return ApiResponse::error('Validation failed', $validation->errors()->all());


    }


    public function updateToken(Request $request) {

        if ($request->user()) {

            $token = Str::random(60);

            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            return ApiResponse::success('Token updated successfully', ['token' => $token]);
        }

        ApiResponse::error('User not logged in', [], 400);

    }

    public function login(Request $request, User $user) {

        $validation = validator($request->all(), ['email' => 'required|email', 'password' => 'required']);

        if ($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all());
        }

        $userExist = $user::where('email', $request->email)->first();

        if ($userExist) {

            if (Hash::check($request->password, $userExist->password)) {

                return ApiResponse::success('User login successful', ['users' => $userExist, '_token' => $userExist->createToken(env('AUTH_SECRET_KEY'))->plainTextToken]);
            }

            return ApiResponse::error('Password is incorrect', ['Incorrect password'], 403);

        }

        return ApiResponse::error('User not found', [] , 404);


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

    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
