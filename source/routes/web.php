<?php

use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AdminController;
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
Route::get('/', [UserController::class, 'main']);
Route::get('/index', [UserController::class, 'main']);
Route::get('/user/login', [UserController::class, 'login'])->name('user.login'); // login_main
Route::get('/user/signup', [UserController::class, 'signup1'])->name('user.signup');
Route::get('/user/signup-step1', [UserController::class, 'signup1'])->name('user.signup1');
Route::get('/user/signup-step2', [UserController::class, 'signup2'])->name('user.signup2');
Route::get('/user/signup-step3', [UserController::class, 'signup3'])->name('user.signup3');

Route::get('/point', [UserController::class, 'pointhome']) ->name('user.pointhome');
Route::get('/point/payment/{type}', [UserController::class, 'pointpayment']) ->name('user.pointpayment');
Route::get('/point/history', [UserController::class, 'payhistory']) ->name('user.payhistory');
Route::get('/point/approval/{result_code}', [UserController::class, 'approval']) ->name('user.approval');

Route::get('/brand', [UserController::class, 'brand']) ->name('user.brand');
Route::get('/brand/minishspa', [UserController::class, 'minishspa']) ->name('user.minishspa');
Route::get('/brand/valmontspa', [UserController::class, 'valmontspa']) ->name('user.valmontspa');
Route::get('/brand/nail', [UserController::class, 'nail']) ->name('user.nail');
Route::get('/brand/deepfocus', [UserController::class, 'deepfocus']) ->name('user.deepfocus');
Route::get('/brand/minishtherapy', [UserController::class, 'minishtherapy']) ->name('user.minishtherapy');
Route::get('/brand/forestablack', [UserController::class, 'forestablack']) ->name('user.forestablack');

Route::get('/profile', [UserController::class, 'profile']) ->name('user.profile');
Route::get('/profile/edit', [UserController::class, 'profile_edit']) ->name('user.profile.edit');
Route::get('/profile/edit-prev', [UserController::class, 'mypage_edit']) ->name('user.mypage.edit');

Route::get('/profile/voucher', [UserController::class, 'voucher']) ->name('user.voucher');
Route::get('/profile/coupon', [UserController::class, 'coupon']) ->name('user.coupon');

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

Route::get('/terms/tos', [UserController::class, 'tos']) ->name('user.tos');
Route::get('/terms/thirdparty', [UserController::class, 'thirdparty']) ->name('user.thirdparty');
Route::get('/terms/marketing', [UserController::class, 'marketing']) ->name('user.marketing');


Route::post('/user/login/proccess', [UserController::class, 'login_proccess']);
Route::post('/user/logout/proccess', [UserController::class, 'logout_proccess']);


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/index', [AdminController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/members', [AdminController::class, 'medibox_member']);
    Route::get('/members/{id}/infos', [AdminController::class, 'medibox_member_view'])->name('admin.medibox_member_view');
    Route::get('/members/{id}', [AdminController::class, 'medibox_member_detail'])->name('admin.medibox_member_detail');
    Route::get('/login', [AdminController::class, 'login_medibox'])->name('admin.login_medibox');

    Route::post('/login/proccess', [AdminController::class, 'login_proccess']);
    Route::get('/logout/proccess', [AdminController::class, 'logout_proccess']);
});
