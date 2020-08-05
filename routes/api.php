<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->load(['roles', 'apartments']);
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::post('email/verify', 'Auth\VerifyEmailController@verifyMail');

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('complexes', 'Complex\ComplexController', ['except' => ['create', 'edit']]);
Route::resource('towers', 'Tower\TowerController', ['except' => ['create', 'edit']]);
Route::resource('apartments', 'Apartment\ApartmentController', ['except' => ['create', 'edit']]);
Route::resource('apartments.codes', 'Apartment\ApartmentCodeController', ['only' => ['index']]);
Route::resource('apartments.users', 'Apartment\ApartmentUserController', ['except' => ['create', 'edit']]);
Route::resource('apartments.warehouses', 'Apartment\ApartmentWarehouseController', ['only' => ['index']]);
Route::resource('warehouses', 'Warehouse\WarehouseController', ['except' => ['create', 'edit']]);
Route::resource('codes', 'Code\CodeController', ['except' => ['create', 'edit']]);
