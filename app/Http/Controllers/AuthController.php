<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register( Request $request){
        $data = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'in:admin,moderator',
        ]);
        
        // Set default role to 'writer' if not provided in the request
        $userData = array_merge($data, ['role' => $data['role'] ?? 'writer']);
 
        
        // Mass assign the validated request data to a new instance of the User model
        $user = User::create($userData);
        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'token' =>$token,
            'Type' => 'Bearer'
        ]);
    }

    public function login( Request $request){
        
        $fields = $request->validate([
            'username' => 'required',
            'password' => 'required',
          
        ]);

        $user =  User::where('username', $fields['username'])->first();

        if(!$user || !Hash::check($fields['password'] , $user->password)){
            return response( [
                'message' => 'Wrong credentials'
            ]);
        }
        
        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'token' =>$token,
            'Type' => 'Bearer'
        ]);


    }
}
