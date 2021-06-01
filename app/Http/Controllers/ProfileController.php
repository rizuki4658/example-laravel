<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
class ProfileController extends Controller
{
    public function show(Request $request)
    {
    	return $request->user();
    }
    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'name',
    		'username',
    		'email',
    		'phone',
    		'birth_date',
    		'address',
    	]);

    	$findProfile = User::find($id);

    	$findAll = User::where('id', '!=', $id)->where('username', 'like', '%' . $request->json('username') . '%')->where('email', 'like', '%' . $request->json('email') . '%')->where('phone', 'like', '%' . $request->json('phone') . '%')->get();
    	
    	if (count($findAll) > 0) {
    		return response()->json(['error' => 'username, phone, or email is already taken !'], 500);
    	}
    	
    	$findProfile->name 			= $request->json('name');
		$findProfile->username		= $request->json('username');
		$findProfile->email			= $request->json('email');
		$findProfile->phone			= $request->json('phone');
		$findProfile->birth_date	= $request->json('birth_date');
		$findProfile->address 		= $request->json('address');
		$findProfile->save();
		return $findProfile;
    }
    public function updatePassword(Request $request, $id, $username)
    {
    	$this->validate($request, [
    		'old_password'		=> 'required',
    		'new_password' 		=> 'required',
    		'confirm_password' 	=> 'required',
    	]);
    	$findPassword = User::find($id)->password;
    	$findProfile = User::find($id);

    	if (!$findProfile) {
			return response()->json(['error' => 'profile not found !'], 500);
		}

    	if (!crypt($request->json('old_password'), $findPassword)) {
    		return response()->json(['error' => 'password validation is wrong !'], 406);
    	}

    	if ($request->json('new_password') !== $request->json('confirm_password')) {
    		return response()->json(['error' => 'password confirmation not same !'], 406);
    	}

    	$findProfile->password 	= bcrypt($request->json('new_password'));
		$findProfile->save();
		return $findProfile;
    }
}
