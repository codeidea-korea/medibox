<?php

use App\Http\Controllers\Web\UserController;
// use App\Http\Controllers\Web\AdminController;
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
// Route::get('/', [UserController::class, 'main']);
Route::get('/', [UserController::class, 'welcome']);
// welcome.blade
Route::get('/index', [UserController::class, 'main']);
Route::get('/user/login', [UserController::class, 'login'])->name('user.login'); // login_main
Route::get('/user/signup', [UserController::class, 'signup'])->name('user.signup');

Route::get('/point', [UserController::class, 'pointhome']) ->name('user.pointhome');
Route::get('/point/payment', [UserController::class, 'pointpayment']) ->name('user.pointpayment');
Route::get('/point/history', [UserController::class, 'payhistory']) ->name('user.payhistory');
Route::get('/point/approval', [UserController::class, 'approval']) ->name('user.approval');

Route::get('/brand', [UserController::class, 'brand']) ->name('user.brand');
Route::get('/brand/minishspa', [UserController::class, 'minishspa']) ->name('user.minishspa');
Route::get('/brand/valmontspa', [UserController::class, 'valmontspa']) ->name('user.valmontspa');
Route::get('/brand/nail', [UserController::class, 'nail']) ->name('user.nail');
Route::get('/brand/deepfocus', [UserController::class, 'deepfocus']) ->name('user.deepfocus');
Route::get('/brand/minishtherapy', [UserController::class, 'minishtherapy']) ->name('user.minishtherapy');
Route::get('/brand/forestablack', [UserController::class, 'forestablack']) ->name('user.forestablack');

Route::get('/mypage', [UserController::class, 'mypage']) ->name('user.mypage');
Route::get('/reservation', [UserController::class, 'reservation']) ->name('user.reservation');
Route::get('/reservation/deepfocus', [UserController::class, 'deepfocus_reservation']) ->name('user.deepfocus_reservation');
Route::get('/reservation/forestablack', [UserController::class, 'forestablack_reservation']) ->name('user.forestablack_reservation');
Route::get('/reservation/minishmanultherapy', [UserController::class, 'minishmanultherapy_reservation']) ->name('user.minishmanultherapy_reservation');
Route::get('/reservation/minishspa', [UserController::class, 'minishspa_reservation']) ->name('user.minishspa_reservation');
Route::get('/reservation/nail', [UserController::class, 'nail_reservation']) ->name('user.nail_reservation');
Route::get('/reservation/valmontspa', [UserController::class, 'valmontspa_reservation']) ->name('user.valmontspa_reservation');

Route::any('/terms/agreement', [UserController::class, 'agreement']) ->name('user.agreement');
Route::get('/terms/privacy', [UserController::class, 'privacy']) ->name('user.privacy');
Route::get('/terms/policy', [UserController::class, 'policy']) ->name('user.policy');

/*
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/index', [AdminController::class, 'index']);
Route::prefix('admin')->group(function () {
    //
});
*/