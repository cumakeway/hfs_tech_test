<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => "required",
             ],
             [
                 'name.required' => 'Please provide a name for the account',
                 'username.required' => 'Please provide a username',
                 'password.required' => 'Please provide a password',
             ]);

             if($validator->fails()){
                 return response()->json([
                     "error" => $validator->errors()
                 ], 422);
             }

             $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            return response()->json(['user' => $user ,
            'message' => 'User created'], 201);
        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }

    public function view(int $id)
    {
        try
        {
            $user = User::find($id);
            if(empty($user)){
                return response()->json([
                    "error" => "This user does not exist"
                ], 404);
            }
            return response()->json(['user' => $user], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
             ],
             [
                 'name.required' => 'This field cannot be blank',
             ]);

             if($validator->fails()){
                 return response()->json([
                     "error" => $validator->errors()
                 ], 422);
             }

             $name = $request['name'];
             $id = $request['id'];
             $user = User::find($id);
             $user->name = $name;
             $user->save();

             return response()->json(['user' => $user ,
             'message' => 'User updated!'], 201);

        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }
}
