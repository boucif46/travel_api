<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\UserTripsController;
use App\Http\Controllers\TravelPlaceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix'=>'travelplaces'],function($router){
    Route::get('/get',[TravelPlaceController::class,'getTravelPlaces']);
    Route::post('/createplace',[TravelPlaceController::class,'create'])->name('createplace');
    Route::get('/search',[TravelPlaceController::class,'search']);
    Route::get('/nearby', [TravelPlaceController::class,'nearby']);
});


Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/logout', [AuthController::class,'logout']);
    
});


Route::group(['prefix' => '/travelplaces/{travelPlaceId}/galeries'], function () {
    Route::post('/create', [GalerieController::class, 'create']);
    Route::get('/get', [GalerieController::class, 'getImagesById']);
    
});

Route::group(['prefix' => 'usersTrips'], function () {
    Route::post('/store', [UserTripsController::class, 'store']);
    Route::post('/get', [UserTripsController::class, 'getUserTrips']);
    
});

