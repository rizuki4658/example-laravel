<?php

Route::group(['middleware' => ['api']], function(){

	Route::post('/auth/signup', 'AuthController@signup');
	Route::post('/auth/signin', 'AuthController@signin');

	Route::group(['middleware' => ['jwt.auth']], function(){

		Route::get('/profile', 'UserController@show');
		Route::get('/users', 'UserController@allshow');
		Route::post('/users/add', 'UserController@addNewUser');
		Route::put('/users/{id}', 'UserController@updateUser');
		Route::put('/users/status/{id}', 'UserController@updateStatus');
		Route::delete('/users/{id}', 'UserController@destroy');

		Route::post('/inventory/create', 'InventoryController@create');

		Route::get('/inventory', 'InventoryController@index');
		Route::get('/inventory/{id}', 'InventoryController@show');
		Route::put('/inventory/{id}', 'InventoryController@update');
		Route::delete('/inventory/{id}', 'InventoryController@destroy');

		Route::get('/sales', 'SalesController@index');
		Route::get('/sales/{id}', 'SalesController@show');
		Route::post('/sales/create', 'SalesController@create');
		Route::put('/sales/{id}', 'SalesController@update');
		Route::delete('/sales/{id}', 'SalesController@destroy');

		Route::get('/profile/{username}', 'ProfileController@show');
		Route::put('/profile/{id}', 'ProfileController@update');
		Route::put('/profile/password/{id}/{username}', 'ProfileController@updatePassword');
	});
});