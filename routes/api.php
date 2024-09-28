<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)
->prefix('user')
->group(function(){
  Route::post('signin','signin');
  Route::post('signup','signup');
});

Route::resource('banner', BannerController::class);

Route::controller(CarController::class)
->group(function(){
  Route::get('car','listCar');
  Route::get('drop-bandara','listCarDropBandara');
});

Route::resource("tours", TourController::class);
