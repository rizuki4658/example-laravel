<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Inventory;

class InventoryController extends Controller
{
	public function index()
	{
		/*
		For get data with relation from another table
		return ModlesName::with('relation names')->get();
		*/
		return Inventory::all();
	}

	public function show($id)
	{
		/*
		For get data with relation from another table
		$inventory = ModelsName::with('relation names')->where('primary keys child', value);
		*/

		$inventory = Inventory::find($id);
		if (!$inventory) {
			return response()->json(['error' => 'items not found !'], 404);
		}
		return $inventory;
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'code' 		=> 'required|unique:inventories',
			'name'		=> 'required',
			'brands'	=> 'required',
			'last_in'	=> 'required',
			'last_out'	=> 'required',
			'max_stocks'=> 'required',
			'min_stocks'=> 'required',
			'stocks'	=> 'required',
			'price'		=> 'required',
			'status'	=> 'required'
		]);

		$inventory = $request->user()->inventories()->create([
			'code' 		=> $request->json('code'),
			'name'		=> $request->json('name'),
			'brands'	=> $request->json('brands'),
			'last_in'	=> $request->json('last_in'),
			'last_out'	=> $request->json('last_out'),
			'max_stocks'=> $request->json('max_stocks'),
			'min_stocks'=> $request->json('min_stocks'),
			'stocks'	=> $request->json('stocks'),
			'price'		=> $request->json('price'),
			'status'	=> $request->json('status'),
			'username'	=> $request->user()->username,
		]);

		return $inventory;
	}


	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name'		=> 'required',
			'brands'	=> 'required',
			'last_in'	=> 'required',
			'last_out'	=> 'required',
			'max_stocks'=> 'required',
			'min_stocks'=> 'required',
			'stocks'	=> 'required',
			'price'		=> 'required',
			'status'	=> 'required',
		]);

		$findItems = Inventory::find($id);

		if (!$findItems) {
			return response()->json(['error' => 'items not found !'], 404);
		}
		if ($request->user()->status !== 1) {
			return response()->json(['error' => 'you not have permission !'], 403);
		}

		$findItems->name 		= $request->json('name');
		$findItems->brands		= $request->json('brands');
		$findItems->last_in		= $request->json('last_in');
		$findItems->last_out	= $request->json('last_out');
		$findItems->max_stocks	= $request->json('max_stocks');
		$findItems->min_stocks	= $request->json('min_stocks');
		$findItems->stocks		= $request->json('stocks');
		$findItems->price		= $request->json('price');
		$findItems->status 		= $request->json('status');
		$findItems->username 	= $request->user()->username;
		$findItems->save();
		return $findItems;
	}


	public function destroy(Request $request, $id)
	{
		$findItems = Inventory::find($id);

		if (!$findItems) {
			return response()->json(['error' => 'items not found !'], 404);
		}
		
		if ($request->user()->status !== 1) {
			return response()->json(['error' => 'you not have permission !'], 403);
		}

		$findItems->delete();

		return response()->json([
			'success' => true,
			'message' => 'items deleted',
		], 200);
	}
}
