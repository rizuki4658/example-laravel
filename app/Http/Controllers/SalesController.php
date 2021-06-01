<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Sales;

class SalesController extends Controller
{
    public function index()
	{
		return Sales::all();
	}

	public function show($id)
	{
		$sale = Sales::find($id);
		if (!$sale) {
			return response()->json(['error' => 'items not found !'], 404);
		}
		return $sale;
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'name'			=> 'required',
			'item_id'		=> 'required',
			'item_code'		=> 'required',
			'item_name'		=> 'required',
			'price'			=> 'required',
			'qty'			=> 'required',
		]);

		$sale = $request->user()->sales()->create([
			'name' 		=> $request->json('name'),
			'item_id'	=> $request->json('item_id'),
			'item_code'	=> $request->json('item_code'),
			'item_name'	=> $request->json('item_name'),
			'price'		=> $request->json('price'),
			'qty'		=> $request->json('qty'),
			'username'	=> $request->user()->username,
		]);

		return $sale;
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name'			=> 'required',
			'item_id'		=> 'required',
			'item_code'		=> 'required',
			'item_name'		=> 'required',
			'price'			=> 'required',
			'qty'			=> 'required',
			'updated_at'	=> 'required',
		]);

		$findSales = Sales::find($id);

		if (!$findSales) {
			return response()->json(['error' => 'sales not found !'], 404);
		}
		if ($request->user()->status !== 1) {
			return response()->json(['error' => 'you not have permission !'], 403);
		}

		$findSales->name 		= $request->json('name');
		$findSales->item_id		= $request->json('item_id');
		$findSales->item_code	= $request->json('item_code');
		$findSales->item_name	= $request->json('item_name');
		$findSales->price		= $request->json('price');
		$findSales->qty			= $request->json('qty');
		$findSales->username	= $request->user()->username;
		$findSales->updated_at	= $request->json('updated_at');
		$findSales->save();
		return $findSales;
	}

	public function destroy(Request $request, $id)
	{
		$findSales = Sales::find($id);

		if (!$findSales) {
			return response()->json(['error' => 'data sales not found !'], 404);
		}
		
		if ($request->user()->status !== 1) {
			return response()->json(['error' => 'you not have permission !'], 403);
		}

		$findSales->delete();

		return response()->json([
			'success' => true,
			'message' => 'data sales deleted',
		], 200);
	}
}
