<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PointController;

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
//    ->middleware('guest')
    Route::post('user/login', [UserController::class, 'login']);

    Route::get('user/logout', [UserController::class, 'logout']);

    Route::get('user/check-dupplicate-id', [UserController::class, 'isDupplicated']);

    Route::post('user/add', [UserController::class, 'add']);
    Route::post('user/modify', [UserController::class, 'modify']);
    Route::post('user/memo-modify', [UserController::class, 'modifyMemo']);
    

    Route::post('user/approve', [UserController::class, 'approve']);
    Route::post('user/delete', [UserController::class, 'delete']);


    Route::post('user/points', [PointController::class, 'myPoint']);
    Route::post('user/payments', [PointController::class, 'myPayments']);

    Route::post('user/point-collect', [PointController::class, 'collect']);
    Route::post('user/point-refund', [PointController::class, 'refund']);
    Route::post('user/point-use', [PointController::class, 'use']);
    Route::post('user/point-cancel', [PointController::class, 'cancel']);
    Route::post('user/point-approve', [PointController::class, 'approve']);
    Route::get('point/check-approve', [PointController::class, 'checkApproved']);
    
    
    Route::post('user/point-use-self', [PointController::class, 'useBySelf']);
    

    Route::get('point-types', [PointController::class, 'getTypes']);
    Route::get('point-types/shops', [PointController::class, 'getShops']);
    Route::get('point-types/shops/services', [PointController::class, 'getServices']);
    Route::get('point-types/collects', [PointController::class, 'getCollects']);
    
    
    Route::get('users', [UserController::class, 'list']);
    Route::get('user', [UserController::class, 'find']);
//});

