<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|numeric|unique:users,phone',
            'username' => 'required|max:255|unique:users,username'
        ]);

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->password = $request->password;
        $data->username = $request->username;
        $data->save();

        $response['message'] = "User berhasil dibuat!";
        $response['data'] = $data;

        return response()->json($response);
    }

    public function login(Request $request){

        $request->validate([
            'password' => 'required',
            'username' => 'required|exists:users,username',
            'device_id' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if(!Hash::check($request->password, $user->password)){
            $response['message'] = "Password salah!";
            return response()->json($response);
        }

        $hashtoken = Hash::make($request->device_id.$request->username);

        $token =  new Token();
        $token->device_id = $request->device_id;
        $token->user_id = $user->id;
        $token->token = $hashtoken;
        $token->save();

        // $token = $user->createToken('auth_type')->plainTextToken;

        $response['message'] = "Berhasil login!";
        $response['token'] = $token;

        return response()->json($response);
    }

    public function logout(Request $request){
        $header = request()->header('Authorization');
        $hashToken = explode(" ", $header)[1];
        $token = Token::where('token', $hashToken)->first();

        $token->delete();
        // $user = auth()->user()->currentAccessToken()->delete();

        $response['message'] = "Berhasil logout!";

        return response()->json($response);
    }

    public static function findUser(){
        $header = request()->header('Authorization');
        $hashToken = explode(" ", $header)[1];
        $token = Token::where('token', $hashToken)->first();

        $user = User::where('id', $token->user_id)->first();
        return $user;
    }
}