<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any?}', function () {
    return view('superadmin');
})->where('any', '^(?!storage).*$')->name('dashboard');

Route::domain('{page}.myapp.com')->group(function () {
    Route::get('/{any?}', function ($page) {
        switch ($page) {
            case 'dash':
                return view('superadmin');
                break;
            case 'porteria':
                return view('reception');
                break;
            case 'conjunto':
                return view('adminconjuntos');
                break;
        }
    });
});
