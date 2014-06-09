<?php
Route::get('/', [
	'as' => 'home',
	'uses' => 'ClientController@index',
]);

Route::resource('client', 'ClientController', [
	'only' => ['show', 'store', 'destroy'],
]);