<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Command;
use App\Models\ProductsCommands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    //

    public function index() {


        if (!$all = Command::all()) {

            return ApiResponse::error('Error while fetching commands');
        }

        return ApiResponse::success('List of commands', $all->toArray());

    }

    public function create(Request $request) {

        $data = $request->all();

        $validation = validator($data, [
            'user_id' => 'required|numeric',
            'commands' => 'required'
        ]);

        if($validation->fails()) {

            return ApiResponse::error('Validation failed', $validation->errors()->all() , 400);
        }

        try {
            $command = new Command();
            $command->code = uniqid();
            $command -> save();

            $product_commands = new ProductsCommands();

            foreach ($data['commands'] as $commands) {

                $product_commands->create([
                    'user_id' => $data['user_id'],
                    'product_id' => $commands['product_id'],
                    'quantity' => $commands['quantity'],
                    'command_id' => $command->id
                ]);

            }
        } catch (\Exception $e) {

            return ApiResponse::error('Une erreur s\'est produite. Veillez réeseayer !');
        }
        return ApiResponse::success('Command added successfully', $data, 201);
    }
}
