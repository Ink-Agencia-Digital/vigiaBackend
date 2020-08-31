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
    return $request->user()->load(['roles', 'apartments.tower.complex', 'complex_administrator']);
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::post('email/verify', 'Auth\VerifyEmailController@verifyMail');


/** User */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.reservations', 'User\UserReservationController', ['only' => ['index']]);
/**Complex */
Route::resource('complexes', 'Complex\ComplexController', ['except' => ['create', 'edit']]);
Route::resource('complexes.locations', 'Complex\ComplexLocationController', ['only' => ['index']]);
Route::resource('complexes.towers', 'Complex\ComplexTowerController', ['only' => ['index']]);
Route::resource('complexes.reservations', 'Complex\ComplexReservationController', ['only' => ['index']]);
/** Tower */
Route::resource('towers', 'Tower\TowerController', ['except' => ['create', 'edit']]);
/** Apartment */
Route::resource('apartments', 'Apartment\ApartmentController', ['except' => ['create', 'edit']]);
Route::resource('apartments.codes', 'Apartment\ApartmentCodeController', ['only' => ['index']]);
Route::resource('apartments.users', 'Apartment\ApartmentUserController', ['except' => ['create', 'edit']]);
Route::resource('apartments.warehouses', 'Apartment\ApartmentWarehouseController', ['only' => ['index']]);
Route::resource('apartments.vehicles', 'Apartment\ApartmentVehicleController', ['only' => ['index']]);
/** Warehouse */
Route::resource('warehouses', 'Warehouse\WarehouseController', ['except' => ['create', 'edit']]);
/** Vehicle */
Route::resource('vehicles', 'Vehicle\VehicleController', ['except' => ['create', 'edit']]);
/** Code */
Route::resource('codes', 'Code\CodeController', ['except' => ['create', 'edit']]);
/** Location */
Route::resource('locations', 'Location\LocationController', ['except' => ['create', 'edit']]);
Route::resource('locations.reservations', 'Location\LocationReservationController', ['only' => ['index']]);
/** Reservation */
Route::resource('reservations', 'Reservation\ReservationController', ['except' => ['create', 'edit']]);
