<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\NoticePartnerController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponUsedController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipUsedController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\EventBannerController;
use App\Http\Controllers\EvenBannerUsedController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHistoryController;
use App\Http\Controllers\AuthSmsController;


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
    Route::post('user/change-password', [UserController::class, 'changePassword']);

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
    
    Route::get('coupon-check-approve', [CouponController::class, 'checkApproved']);
    Route::get('voucher-check-approve', [VoucherController::class, 'checkApproved']);

    Route::post('user/coupon-cancel', [CouponController::class, 'cancel']);
    Route::post('user/coupon-approve', [CouponController::class, 'approve']);
    Route::post('user/voucher-cancel', [VoucherController::class, 'cancel']);
    Route::post('user/voucher-approve', [VoucherController::class, 'approve']);
    Route::get('my-voucher', [VoucherController::class, 'myVouchers']);

    Route::post('user/voucher-collect', [VoucherController::class, 'collect']);
    Route::post('user/voucher-refund', [VoucherController::class, 'refund']);
    
    
    
    Route::post('user/point-use-self', [PointController::class, 'useBySelf']);
    

    Route::get('point-types', [PointController::class, 'getTypes']);
    Route::get('point-types/shops', [PointController::class, 'getShops']);
    Route::get('point-types/shops/services', [PointController::class, 'getServices']);
    Route::get('point-types/collects', [PointController::class, 'getCollects']);
    
    Route::get('point/history', [PointController::class, 'list']);
    Route::post('point/auto-conf', [PointController::class, 'conf']);
    
    
    Route::get('users', [UserController::class, 'list']);
    Route::get('user', [UserController::class, 'find']);
    Route::post('user/membership-card/modify', [UserController::class, 'updateMembershipCardNo']);
    

    // 공지사항 유저
    Route::get('contents/notice/app', [NoticeController::class, 'list']);
    Route::get('contents/notice/app/{id}', [NoticeController::class, 'find']);
    Route::post('contents/notice/app', [NoticeController::class, 'add']);
    Route::post('contents/notice/app/{id}/remove', [NoticeController::class, 'remove']);
    // 공지사항 파트너
    Route::get('contents/notice/partner', [NoticePartnerController::class, 'list']);
    Route::get('contents/notice/partner/{id}', [NoticePartnerController::class, 'find']);
    Route::post('contents/notice/partner', [NoticePartnerController::class, 'add']);
    Route::post('contents/notice/partner/{id}/remove', [NoticePartnerController::class, 'remove']);
    // 자주묻는질문
    Route::get('contents/faq', [FaqController::class, 'list']);
    Route::get('contents/faq/{id}', [FaqController::class, 'find']);
    Route::post('contents/faq', [FaqController::class, 'add']);
    Route::post('contents/faq/{id}/remove', [FaqController::class, 'remove']);
    // 도움말
    Route::get('contents/help', [HelpController::class, 'list']);
    Route::get('contents/help/{id}', [HelpController::class, 'find']);
    Route::post('contents/help', [HelpController::class, 'add']);
    Route::post('contents/help/{id}/remove', [HelpController::class, 'remove']);
    // 이용약관
    Route::get('contents/usage', [UsageController::class, 'list']);
    Route::get('contents/usage/{id}', [UsageController::class, 'find']);
    Route::post('contents/usage', [UsageController::class, 'add']);
    Route::post('contents/usage/{id}/modify', [UsageController::class, 'modify']);
    Route::post('contents/usage/{id}/remove', [UsageController::class, 'remove']);
    // 개인정보처리약관
    Route::get('contents/privacies', [PrivacyController::class, 'list']);
    Route::get('contents/privacies/{id}', [PrivacyController::class, 'find']);
    Route::post('contents/privacies', [PrivacyController::class, 'add']);
    Route::post('contents/privacies/{id}/modify', [PrivacyController::class, 'modify']);
    Route::post('contents/privacies/{id}/remove', [PrivacyController::class, 'remove']);

    // 메인화면 템플릿 선택
    Route::get('contents/template', [TemplateController::class, 'list']);
    Route::get('contents/template/choosen', [TemplateController::class, 'choosen']);
    Route::post('contents/template/choose', [TemplateController::class, 'choose']);
    
    // 브랜드 관리
    Route::get('partners', [PartnerController::class, 'list']);
    Route::get('partners-all', [PartnerController::class, 'getAll']);
    Route::get('partners/{id}', [PartnerController::class, 'find']);
    Route::post('partners', [PartnerController::class, 'add']);
    Route::post('partners/{id}/remove', [PartnerController::class, 'remove']);
    Route::post('partners/{id}/modify', [PartnerController::class, 'modify']);

    // 매장 관리
    Route::get('stores', [StoreController::class, 'list']);
    Route::get('stores-all', [StoreController::class, 'getAll']);
    Route::get('stores/{id}', [StoreController::class, 'find']);
    Route::post('stores', [StoreController::class, 'add']);
    Route::post('stores/{id}/modify', [StoreController::class, 'modify']);
    Route::post('stores/{id}/remove', [StoreController::class, 'remove']);
    
    // 예약 관리 (예약 현황, 예약 내역)
    Route::get('reservations', [ReservationController::class, 'list']);
    Route::get('reservations/day', [ReservationController::class, 'getListInStore']);
    Route::get('reservations/check-available', [ReservationController::class, 'checkTime']);
    Route::get('reservations/{id}', [ReservationController::class, 'find']);
    Route::post('reservations', [ReservationController::class, 'add']);
    Route::post('reservations/{id}/modify', [ReservationController::class, 'modify']);
    Route::post('reservations/{id}/remove', [ReservationController::class, 'remove']);
    Route::post('reservations/{id}/status', [ReservationController::class, 'modifyStatus']);
    // 매니저 (임원/매니저/실장/디자이너 등 실무 직원 통칭)
    Route::get('managers', [ManagerController::class, 'getListInStore']);
    Route::get('managers/{id}', [ManagerController::class, 'find']);
    Route::post('managers', [ManagerController::class, 'add']);
    Route::post('managers/{id}/modify', [ManagerController::class, 'modify']);
    Route::post('managers/{id}/remove', [ManagerController::class, 'remove']);
    // 담당 직위 매니저들의 서비스
    Route::get('manager-services', [ServiceController::class, 'getListInStore']);
    Route::get('manager-services/{id}', [ServiceController::class, 'find']);
    Route::post('manager-services', [ServiceController::class, 'add']);
    Route::post('manager-services/{id}/modify', [ServiceController::class, 'modify']);
    Route::post('manager-services/{id}/remove', [ServiceController::class, 'remove']);
    Route::get('stores-services', [ServiceController::class, 'getAllInStore']);
    // 매장/매니저별 휴일
    Route::get('manager-holiday', [HolidayController::class, 'getListInStore']);
    Route::post('manager-holiday', [HolidayController::class, 'add']);
    Route::post('manager-holiday/{id}/remove', [HolidayController::class, 'remove']);

    

    // 상품 관리
    Route::get('products', [ProductController::class, 'list']);
    Route::get('products/{id}', [ProductController::class, 'find']);
    Route::post('products', [ProductController::class, 'add']);
    Route::post('products/{id}/modify', [ProductController::class, 'modify']);
    Route::post('products/{id}/remove', [ProductController::class, 'remove']);
    
    // 바우처 관리
    Route::get('vouchers', [VoucherController::class, 'list']);
    Route::get('vouchers/{id}', [VoucherController::class, 'find']);
    Route::post('vouchers', [VoucherController::class, 'add']);
    Route::post('vouchers/{id}/modify', [VoucherController::class, 'modify']);
    Route::post('vouchers/{id}/remove', [VoucherController::class, 'remove']);
    Route::post('vouchers/{id}/use', [VoucherController::class, 'use']);
    
    // 쿠폰 관리
    Route::get('coupon', [CouponController::class, 'list']);
    Route::get('coupons/mine', [CouponUsedController::class, 'myEnabledCoupons']);
    Route::get('coupon/{id}', [CouponController::class, 'find']);
    Route::post('coupon', [CouponController::class, 'add']);
    Route::post('coupon/{id}/modify', [CouponController::class, 'modify']);
    Route::post('coupon/{id}/remove', [CouponController::class, 'remove']);
    Route::post('coupon/{id}/status', [CouponController::class, 'modifyStatus']);
    // 쿠폰 사용 내역
    Route::get('coupon-history', [CouponUsedController::class, 'list']);
    Route::get('coupon-history/{id}', [CouponUsedController::class, 'find']);
    
    // 이벤트 쿠폰 관리
    Route::get('event-coupon', [EventBannerController::class, 'list']);
    Route::get('event-coupon/{id}', [EventBannerController::class, 'find']);
    Route::post('event-coupon', [EventBannerController::class, 'add']);
    Route::post('event-coupon/{id}/modify', [EventBannerController::class, 'modify']);
    Route::post('event-coupon/{id}/remove', [EventBannerController::class, 'remove']);
    Route::post('event-coupon/{id}/status', [EventBannerController::class, 'modifyStatus']);
    // 이벤트 배너 -> 이벤트 배너의 쿠폰으로 controller 책임 변경
//    Route::post('event-coupon/{id}/join', [EventBannerController::class, 'join']);
    
    // 이벤트 쿠폰 사용 내역
    Route::get('event-coupon-history', [EvenBannerUsedController::class, 'list']);
    Route::get('event-coupon/{couponId}/check', [EvenBannerUsedController::class, 'confirmIssuedEventCoupon']);
    Route::post('event-coupon/{couponId}/join', [EvenBannerUsedController::class, 'addEventCoupon']);

    // 멤버쉽 관리
    Route::get('membership', [MembershipController::class, 'list']);
    Route::get('membership/{id}', [MembershipController::class, 'find']);
    Route::post('membership', [MembershipController::class, 'add']);
    Route::post('membership/{id}/modify', [MembershipController::class, 'modify']);
    Route::post('membership/{id}/remove', [MembershipController::class, 'remove']);
    // 멤버쉽 사용 내역
    Route::get('membership-history', [MembershipUsedController::class, 'list']);
    // 
    Route::get('membership-history/user', [MembershipUsedController::class, 'myMemberships']);
    Route::post('membership-user/collect', [MembershipUsedController::class, 'collect']);
    Route::post('membership-user/refund', [MembershipUsedController::class, 'refund']);

    // 관리자 레벨
    Route::get('admin/level', [AdminController::class, 'list']);
    Route::get('admin/level/{id}', [AdminController::class, 'find']);
    Route::post('admin/level', [AdminController::class, 'add']);
    Route::post('admin/level/{id}/modify', [AdminController::class, 'modify']);
    Route::post('admin/level/{id}/remove', [AdminController::class, 'remove']);    

    // 관리자 history 관리
    Route::get('admin/history/action', [AdminHistoryController::class, 'list']);
    Route::post('admin/history/action', [AdminHistoryController::class, 'add']);


    // 파일 업로드
    Route::post('file/{type}', [FileController::class, 'add']);

    // 문자 인증
    Route::get('sms/result', [AuthSmsController::class, 'saveSmsHistory']);
    Route::post('auth/sms/send', [AuthSmsController::class, 'send']);
    Route::get('auth/sms/check', [AuthSmsController::class, 'check']);
    Route::get('auth/sms/sends', [AuthSmsController::class, 'index']);
//});

