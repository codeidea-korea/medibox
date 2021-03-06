<?php

use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ExcelController;
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

Route::post('/user/login/change-password', [UserController::class, 'changePassword'])->name('user.login.change.password'); 
Route::get('/user/login/find-id', [UserController::class, 'findId'])->name('user.login.find.id'); 
Route::get('/user/login/find-password', [UserController::class, 'findPassword'])->name('user.login.find.password'); 

Route::get('/point', [UserController::class, 'pointhome']) ->name('user.pointhome');
Route::get('/point/payment/{type}', [UserController::class, 'pointpayment']) ->name('user.pointpayment');
Route::get('/point/history', [UserController::class, 'payhistory']) ->name('user.payhistory');
Route::get('/point/history/{type}', [UserController::class, 'payhistoryType']) ->name('user.payhistory.type');
Route::get('/point/approval/{result_code}', [UserController::class, 'approval']) ->name('user.approval');
Route::get('/point/coupon/approval/{result_code}', [UserController::class, 'approvalCoupon']) ->name('user.approval.coupon');
Route::get('/point/voucher/approval/{result_code}', [UserController::class, 'approvalVoucher']) ->name('user.approval.voucher');

Route::get('/brand', [UserController::class, 'brand']) ->name('user.brand');
Route::get('/brand/{partnerNo}', [UserController::class, 'brandDetail']) ->name('user.brand.detail');

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
Route::get('/profile/voucher/{id}', [UserController::class, 'voucher_confirm']) ->name('user.voucher_confirm');

Route::get('/profile/coupon', [UserController::class, 'coupon']) ->name('user.coupon');
Route::get('/profile/services', [UserController::class, 'services']) ->name('user.services');

Route::get('/profile/notices', [UserController::class, 'notices']) ->name('user.notices');
Route::get('/profile/notices/{id}', [UserController::class, 'notice']) ->name('user.notice');
Route::get('/profile/faqs', [UserController::class, 'faqs']) ->name('user.faqs');
Route::get('/profile/faqs/{id}', [UserController::class, 'faq']) ->name('user.faq');
Route::get('/profile/helps', [UserController::class, 'helps']) ->name('user.helps');
Route::get('/profile/helps/{id}', [UserController::class, 'help']) ->name('user.help');

Route::get('/profile/events', [UserController::class, 'events']) ->name('user.events');
Route::get('/profile/events/{id}', [UserController::class, 'event']) ->name('user.event');

Route::get('/profile/app-version', [UserController::class, 'version']) ->name('user.version');

Route::get('/reservation/deepfocus', [UserController::class, 'deepfocus_reservation']) ->name('user.deepfocus_reservation');
Route::get('/reservation/forestablack', [UserController::class, 'forestablack_reservation']) ->name('user.forestablack_reservation');
Route::get('/reservation/minishmanultherapy', [UserController::class, 'minishmanultherapy_reservation']) ->name('user.minishmanultherapy_reservation');
Route::get('/reservation/minishspa', [UserController::class, 'minishspa_reservation']) ->name('user.minishspa_reservation');
Route::get('/reservation/nail', [UserController::class, 'nail_reservation']) ->name('user.nail_reservation');
Route::get('/reservation/valmontspa', [UserController::class, 'valmontspa_reservation']) ->name('user.valmontspa_reservation');

Route::get('/brands/{brandNo}/shops/{shopNo}/reservation/cart', [UserController::class, 'reservationCart']) ->name('user.reservation.cart');
Route::get('/brands/{brandNo}/shops/{shopNo}/reservation/payment', [UserController::class, 'reservationPayment']) ->name('user.reservation.payment');

Route::get('/reservation-history', [UserController::class, 'reservationHistory']) ->name('user.reservation.history.list');
Route::get('/reservation-history/{historyNo}', [UserController::class, 'reservationHistoryView']) ->name('user.reservation.history.view');
Route::get('/reservation-history/{historyNo}/modify', [UserController::class, 'reservationModify']) ->name('user.reservation.modify');

Route::get('/reservation-modify/cart/{historyNo}', [UserController::class, 'reservationModifyCart']) ->name('user.reservation.modify.cart');
Route::get('/reservation-modify/payment/{historyNo}', [UserController::class, 'reservationModifyPayment']) ->name('user.reservation.modify.payment');

Route::get('/reservation', [UserController::class, 'reservation']) ->name('user.reservation');
Route::get('/reservation/{storeNo}', [UserController::class, 'reservationDetail']) ->name('user.reservation.detail');

Route::get('/reservation-voucher/{voucherNo}', [UserController::class, 'reservationByVoucher']) ->name('user.reservation.voucher');

Route::any('/terms/agreement', [UserController::class, 'agreement']) ->name('user.agreement');
Route::get('/terms/privacy', [UserController::class, 'privacy']) ->name('user.privacy');
Route::get('/terms/policy', [UserController::class, 'policy']) ->name('user.policy');

Route::get('/terms/tos', [UserController::class, 'tos']) ->name('user.tos');
Route::get('/terms/thirdparty', [UserController::class, 'thirdparty']) ->name('user.thirdparty');
Route::get('/terms/marketing', [UserController::class, 'marketing']) ->name('user.marketing');


Route::post('/user/login/proccess', [UserController::class, 'login_proccess']);
Route::post('/user/logout/proccess', [UserController::class, 'logout_proccess']);


Route::get('/user/barcode', [UserController::class, 'barcode'])->name('user.barcode');


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/index', [AdminController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/members', [AdminController::class, 'medibox_member']);
    Route::get('/members-download/excel', [ExcelController::class, 'getUsers']);
    
    Route::get('/members/{id}/infos', [AdminController::class, 'medibox_member_view'])->name('admin.medibox_member_view');
    Route::get('/members/{id}', [AdminController::class, 'medibox_member_detail'])->name('admin.medibox_member_detail');
    Route::get('/login', [AdminController::class, 'login_medibox'])->name('admin.login_medibox');

    // ???????????? ??????
    Route::get('/contents/notices', [AdminController::class, 'notices']);
    Route::get('/contents/notices/{id}', [AdminController::class, 'notice']);
    // ???????????? ?????????
    Route::get('/contents/notices-partner', [AdminController::class, 'partnerNotices']);
    Route::get('/contents/notices-partner/{id}', [AdminController::class, 'partnerNotice']);
    // ??????????????????
    Route::get('/contents/faqs', [AdminController::class, 'faqs']);
    Route::get('/contents/faqs/{id}', [AdminController::class, 'faq']);
    // ?????????
    Route::get('/contents/helps', [AdminController::class, 'helps']);
    Route::get('/contents/helps/{id}', [AdminController::class, 'help']);
    // ????????????
    Route::get('/contents/usages', [AdminController::class, 'usages']);
    Route::get('/contents/usages/{id}', [AdminController::class, 'usage']);
    // ????????????????????????
    Route::get('/contents/privacies', [AdminController::class, 'privacies']);
    Route::get('/contents/privacies/{id}', [AdminController::class, 'privacy']);
    // ???????????? ????????? ??????
    Route::get('/contents/template', [AdminController::class, 'template']);

    // ????????? ??????
    Route::get('/partners', [AdminController::class, 'partners']);
    Route::get('/partners/{id}', [AdminController::class, 'partner']);
    // ?????? ??????
    Route::get('/stores', [AdminController::class, 'stores']);
    Route::get('/stores/{id}', [AdminController::class, 'store']);
    // ?????? ??????
    Route::get('/managers', [AdminController::class, 'managers']);
    Route::get('/managers/{id}', [AdminController::class, 'manager']);
    // ?????? ??????
    Route::get('/services', [AdminController::class, 'services']);
    Route::get('/services/{id}', [AdminController::class, 'service']);
    // ????????????/?????? ??????
    Route::get('/business-hours', [AdminController::class, 'businessHours']);
    // ????????? ?????? ?????? ??????
    Route::get('/point/history', [AdminController::class, 'pointHistory']);
    Route::get('/point/history/{historyNo}', [AdminController::class, 'pointHistoryDetail']);
    Route::get('/point/conf', [AdminController::class, 'pointConf']);
    // ????????? ??????
    Route::get('/service/tickets', [AdminController::class, 'flatRateTickets']);
    Route::get('/service/tickets/{tiketNo}', [AdminController::class, 'flatRateTicket']);
    // ????????? ??????
    Route::get('/service/packages', [AdminController::class, 'packages']);
    Route::get('/service/packages/{packageNo}', [AdminController::class, 'package']);
    // ????????? ??????
    Route::get('/service/vouchers', [AdminController::class, 'vouchers']);
    Route::get('/service/vouchers/{voucherNo}', [AdminController::class, 'voucher']);
    // ?????? ??????
    Route::get('/service/coupon', [AdminController::class, 'coupons']);
    Route::get('/service/coupon/{couponNo}', [AdminController::class, 'coupon']);
    // ?????? ?????? ??????
    Route::get('/service/coupon-history', [AdminController::class, 'couponHistory']);
    Route::get('/service/coupon-history/{historyNo}', [AdminController::class, 'couponHistoryDetail']);
    // ????????? ??????
    Route::get('/service/membership', [AdminController::class, 'memberships']);
    Route::get('/service/membership/{couponNo}', [AdminController::class, 'membership']);
    // ????????? ?????? ??????
    Route::get('/service/membership-history', [AdminController::class, 'membershipHistory']);
    // ?????? ????????????
    Route::get('/payments/membership', [AdminController::class, 'paymentsMembership']);
    Route::get('/payments/point', [AdminController::class, 'paymentsPoints']);
    // ????????? ?????? ??????
    Route::get('/service/event-coupon', [AdminController::class, 'eventCoupons']);
    Route::get('/service/event-coupon/{couponNo}', [AdminController::class, 'eventCoupon']);
    // ????????? ?????? ?????? ??????
    Route::get('/service/event-coupon-history', [AdminController::class, 'eventCouponHistory']);
    // ????????? ?????? ??????
    Route::get('/level', [AdminController::class, 'adminLevels']);
    Route::get('/level/{id}', [AdminController::class, 'adminLevel']);
    
    // ????????? ?????? ????????????
    Route::get('/history/action', [AdminController::class, 'adminActionHistory']);

    // ??????
    Route::get('/reservations/condition', [AdminController::class, 'reservationsCondition']);
    Route::get('/reservations', [AdminController::class, 'reservations']);

    Route::post('/login/proccess', [AdminController::class, 'login_proccess']);
    Route::get('/logout/proccess', [AdminController::class, 'logout_proccess']);

    Route::get('/main', [AdminController::class, 'partnerHome']);
    Route::get('/notice/{id}', [AdminController::class, 'partnerNoticeDetail']);

    // ?????? ??????
    Route::get('/calculate', [AdminController::class, 'calculate']);
});
