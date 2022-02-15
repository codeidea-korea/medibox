<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
//Route::group(['middleware' => 'auth:api'], function () {
    
    Route::post('user/login', [UserController::class, 'login']);

    Route::get('user/logout', [UserController::class, 'logout']);
    Route::get('user/check-dupplicate-id', [UserController::class, 'isDupplicated']);

    Route::post('user/add', [UserController::class, 'add']);
    Route::post('user/modify', [UserController::class, 'modify']);
    Route::post('user/approve', [UserController::class, 'approve']);
    Route::post('user/delete', [UserController::class, 'delete']);
    
//});

