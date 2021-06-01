<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
    	// rules|unique/not:table name
    	$this->validate($request, [
    		'name'			=> 'required',
    		'username' 		=> 'required|unique:users',
    		'email' 		=> 'required|unique:users',
    		'password' 		=> 'required',
    		'phone' 		=> 'required|unique:users',
    		'birth_date' 	=> 'required',
    		'address' 		=> 'required',
    		'status',
    	]);

    	User::create([
    		'name'			=> $request->json('name'),
    		'username' 		=> $request->json('username'),
    		'email' 		=> $request->json('email'),
    		'password' 		=> bcrypt($request->json('password')),
    		'phone' 		=> $request->json('phone'),
    		'birth_date' 	=> $request->json('birth_date'),
    		'address' 		=> $request->json('address'),
    		'status' 		=> 0,
    	]);
    }

    public function signin(Request $request)
    {
    	// rules|unique/not:table name
    	$this->validate($request, [
    		'email' 		=> 'required',
    		'password' 		=> 'required',
    	]);

    	$credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        $results = response()->json([
            'name'          => $request->user()->name,
            'username'      => $request->user()->username,
            'email'         => $request->user()->email,
            'phone'         => $request->user()->phone,
            'address'       => $request->user()->address,
            'birth_date'    => $request->user()->birth_date,
            'status'        => $request->user()->status,
            'token' => $token,
        ]);
        if ($request->user()->status !== 1) {
            if ($request->user()->status === 0) {
                return response()->json([
                    'error' => 'waiting confirmation'
                ], 406);
            }
            if ($request->user()->status === 2) {
                return response()->json([
                    'error' => 'Your Account Was Blocked'
                ], 500);
            }
        } else {
            return $results;
        }
    }
}
