<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
    	return $request->user();
    }
    public function allshow(Request $request)
    {
    	return User::all();
    }
    public function addNewUser(Request $request)
    {
    	$this->validate($request, [
    		'name'			=> 'required',
    		'username' 		=> 'required|unique:users',
    		'email' 		=> 'required|unique:users',
    		'password',
    		'phone' 		=> 'required|unique:users',
    		'birth_date' 	=> 'required',
    		'address' 		=> 'required',
    		'status',
    	]);

    	User::create([
    		'name'			=> $request->json('name'),
    		'username' 		=> $request->json('username'),
    		'email' 		=> $request->json('email'),
    		'password' 		=> bcrypt(12345678910),
    		'phone' 		=> $request->json('phone'),
    		'birth_date' 	=> $request->json('birth_date'),
    		'address' 		=> $request->json('address'),
    		'status' 		=> $request->json('status'),
    	]);
    }
    public function updateUser(Request $request, $id)
    {
    	$this->validate($request, [
    		'name'			=> 'required',
    		'birth_date' 	=> 'required',
    		'address' 		=> 'required',
    		'status'		=> 'required'
    	]);

    	$findUsers = User::find($id);

    	if (!$findUsers) {
			return response()->json(['error' => 'items not found !'], 404);
		}
		if ($request->json('status_editor') !== 1) {
			return response()->json(['error' => 'you not have permission !'], 403);
		}

		$findUsers->name 		= $request->json('name');
		$findUsers->birth_date	= $request->json('birth_date');
		$findUsers->address 	= $request->json('address');
		$findUsers->status 		= $request->json('status');
		$findUsers->save();
		return $findUsers;
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status'        => 'required'
        ]);

        $findUsers = User::find($id);

        if (!$findUsers) {
            return response()->json(['error' => 'items not found !'], 404);
        }
        if ($request->json('status_editor') !== 1) {
            return response()->json(['error' => 'you not have permission !'], 403);
        }

        $findUsers->status      = $request->json('status');
        $findUsers->save();
        return $findUsers;
    }

    public function destroy(Request $request, $id)
	{
		$findUsers = User::find($id);

		if (!$findUsers) {
			return response()->json(['error' => 'items not found !'], 404);
		}

		$findUsers->delete();

		return response()->json([
			'success' => true,
			'message' => 'items deleted',
		], 200);
	}
}
