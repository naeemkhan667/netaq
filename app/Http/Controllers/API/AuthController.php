<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password'
            ]);

            if ($validator->fails()) {
               return response()->json(['status' => false, 'message' => $validator->errors()->first()], 401);
            }

            $user_input = $request->all();
            $user_input['password'] = bcrypt($user_input['password']);
            $user = User::create($user_input);
            $token = $user->createToken('netaq')->plainTextToken;
            $data = ['name' => $user->name, 'user_id' => $user->id, 'token' => $token];

            return response()->json(['status' => true, 'message' => 'User successfully created', 'data' => $data], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function login(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 401);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('netaq')->plainTextToken;
                $data = ['name' => $user->name, 'token' => $token];

                return response()->json(['status' => true, 'message' => 'User successfully logged in', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Unauthorized Access'], 403);
            }

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }


    }
}
