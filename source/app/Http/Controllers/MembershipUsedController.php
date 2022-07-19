<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class MembershipUsedController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $user_phone = $request->get('user_phone');
        $user_name = $request->get('user_name');
        $user_seqno = $request->get('user_seqno');
        
        $dt_option_type = $request->get('dt_option_type', 'use');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');
        $hst_type = $request->get('hst_type');
        $seqno = $request->get('seqno');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
//        array_push($where, ['deleted', '=', 'N']);
        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        $whereUser = [];
        if(! empty($user_phone) && $user_phone != ''){
            array_push($whereUser, ['user_phone', 'like', '%'.$user_phone.'%']);
        }
        if(! empty($user_name) && $user_name != ''){
            array_push($whereUser, ['user_name', 'like', '%'.$user_name.'%']);
        }
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($whereUser, ['user_seqno', '=', $user_seqno]);
        }

        if(! empty($start_dt) && $start_dt != ''){
            // NOTICE: 기간 옵션 (사용일자, 가입일, 종료일)
            if($dt_option_type == 'use') {
                array_push($where, ['hst_type', '=', 'U']);
                array_push($where, ['membership_user_hst.create_dt', '>=', $start_dt]);
                array_push($where, ['membership_user_hst.create_dt', '<=', $end_dt]);
            } else if($dt_option_type == 'join') {
                array_push($where, ['membership_user.real_start_dt', '>=', $start_dt]);
                array_push($where, ['membership_user.real_start_dt', '<=', $end_dt]);
            } else if($dt_option_type == 'end') {
                array_push($where, ['membership_user.real_end_dt', '>=', $start_dt]);
                array_push($where, ['membership_user.real_end_dt', '<=', $end_dt]);
            }
        }
        if(! empty($hst_type) && $hst_type != ''){
            array_push($where, ['hst_type', '=', $hst_type]);
        }
        if(! empty($seqno) && $seqno != ''){
            array_push($where, ['membership_seqno', '=', $seqno]);
        }
        
        $contents = DB::table("membership_user_hst")->where($where)
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('membership_user_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            })
            ->join('membership_user', 'membership_user_hst.membership_user_seqno', '=', 'membership_user.seqno')
            ->leftJoin('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
            ->leftJoin('store_service', 'membership_user_hst.service_seqno', '=', 'store_service.seqno')
            ->leftJoin('product_voucher', 'membership_user_hst.voucher_seqno', '=', 'product_voucher.seqno')
            ->leftJoin('coupon', 'membership_user_hst.coupon_seqno', '=', 'coupon.seqno')
            ->select(
                'membership_user_hst.*', 
                'user_info.user_seqno', 'user_info.user_phone', 'user_info.user_name',
                'product_membership.name as membership_name', 'membership_user.real_start_dt', 'membership_user.real_end_dt','product_membership.price as price',
                'store_service.name', 'product_voucher.name', 'coupon.name', 
                'membership_user.real_start_dt', 'membership_user.real_end_dt')
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("membership_user_hst")->where($where)
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('membership_user_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            })
            ->join('membership_user', 'membership_user_hst.membership_user_seqno', '=', 'membership_user.seqno')
            ->leftJoin('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
            ->leftJoin('store_service', 'membership_user_hst.service_seqno', '=', 'store_service.seqno')
            ->leftJoin('product_voucher', 'membership_user_hst.voucher_seqno', '=', 'product_voucher.seqno')
            ->leftJoin('coupon', 'membership_user_hst.coupon_seqno', '=', 'coupon.seqno')
            ->select(
                'user_info.user_seqno', 'user_info.user_phone', 'user_info.user_name',
                'product_membership.name as membership_name', 'membership_user.real_start_dt', 'membership_user.real_end_dt',
                'store_service.name as service_name', 'product_voucher.name as voucher_name', 'coupon.name as coupon_name', 
                'membership_user_hst.hst_type', 'membership_user_hst.create_dt',
                'membership_user.real_start_dt', 'membership_user.real_end_dt')
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }



    
    // 충전
    public function collect(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 식별자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $membership_seqno = $request->post('membership_seqno'); // 대상 멤버쉽
        $memo = $request->post('memo', '');
        
        $result = [];
        $result['ment'] = '멤버쉽이 적립되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($membership_seqno)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        $admin = DB::table("admin_info")->where([
            ['admin_seqno', '=', $admin_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            $result['ment'] = '멤버쉽이 적립되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        $membership = DB::table("product_membership")->where([
            ['seqno', '=', $membership_seqno],
            ['deleted', '=', 'N']
        ])->first();
        
        if(empty($membership)) {
            $result['ment'] = '멤버쉽이 적립되지 않았습니다.\r없는 멤버쉽 정보입니다.';
            return $result;
        }

        // 히스토리에 포인트 이력 추가 <- 현금 결제로 변경
        /*
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => 'P'
                , 'hst_type' => 'U'
                , 'point' => $membership->price
                , 'memo' => '[멤버쉽 구매] ' . $membership->name
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        */
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => 'P'
                , 'hst_type' => 'S'
                , 'point' => $membership->point
                , 'memo' => '[멤버쉽] ' . $membership->name . ' 구매로 포인트 리턴'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $membership_user_seqno = DB::table('membership_user')->insertGetId(
            [
                'membership_seqno' => $membership->seqno
                , 'user_seqno' => $user_seqno
                , 'used' => 'N'
                , 'approved' => 'N'
                , 'real_start_dt' => date('Y-m-d H:i:s')
                , 'real_end_dt' => ($membership->date_use > 0 ? date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' +'.$membership->date_use.' day')) : '9999-12-30 23:59:59')
                , 'deleted' => 'N'
//                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s')
            ], 'seqno'
        );
        $id = DB::table('membership_user_hst')->insertGetId(
            [
                'membership_user_seqno' => $membership_user_seqno
                , 'user_seqno' => $user_seqno
                , 'hst_type' => 'S'
                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
            ]
        );
        $price = $membership->price;
        // 내 포인트에 증가 처리
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->first();

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->update(
            [
                'point' => $point->point /* - $membership->price */ + $membership->point
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        
        // 회원가입시 추천인 포인트 지급 처리 (최초 결제건에 대해 1회 % 적립)
        /*
        $countUsed = DB::table("user_point_hst")->where([
            ['user_seqno', '=', $user_seqno],
            ['hst_type', '=', 'U']
        ])->count();
        if($countUsed < 2 && $user->recommended_code && $user->recommended_code != '') {
            $recommender = DB::table("user_info")->where([
                ['user_phone', '=', $user->recommended_code],
                ['delete_yn', '=', 'N']
            ])->first();

            $conf = DB::table("conf_auto_point")->first();
            if(!empty($conf) && $conf->recommand_bonus == 'Y'
                && !empty($recommender)) {
                
                $etcPoint = ($price / 100) * $conf->recommand_bonus_rate;

                DB::table('user_point_hst')->insertGetId(
                    [
                        'admin_seqno' => $admin_seqno
                        , 'user_seqno' => $user_seqno
                        , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                        , 'point_type' => 'P'
                        , 'product_seqno' => 0
                        , 'hst_type' => 'S'
                        , 'point' => $etcPoint
                        , 'memo' => '추천인 자동 적립 [추천한 고객: '.$recommender->user_name.' / '.$recommender->user_phone.', 사용금액: '.$price.']'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ], 'user_point_hst_seqno'
                );
                DB::table('user_point')->where([
                    ['user_seqno', '=', $user_seqno],
                    ['point_type', '=', 'P']
                ])->update(
                    [
                        'point' => $point->point + $etcPoint
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );

                $prevPoint = DB::table('user_point')->where([
                    ['user_seqno', '=', $recommender->user_seqno],
                    ['point_type', '=', 'P']
                ])->first();

                DB::table('user_point_hst')->insertGetId(
                    [
                        'admin_seqno' => $admin_seqno
                        , 'user_seqno' => $recommender->user_seqno
                        , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                        , 'point_type' => 'P'
                        , 'product_seqno' => 0
                        , 'hst_type' => 'S'
                        , 'point' => $etcPoint
                        , 'memo' => '추천인 자동 적립 [추천받은(가입) 고객: '.$user->user_name.' / '.$user->user_phone.', 사용금액: '.$price.']'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ], 'user_point_hst_seqno'
                );
                DB::table('user_point')->where([
                    ['user_seqno', '=', $recommender->user_seqno],
                    ['point_type', '=', 'P']
                ])->update(
                    [
                        'point' => $prevPoint->point + $etcPoint
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }
        */
        // 멤버쉽에 소속된 쿠폰/바우처가 제공됩니다.
        $vouchers = DB::table('membership_service_grp')->where([
            ['membership_seqno', '=', $membership->seqno]
        ])->get();
        for($inx = 0; $inx < count($vouchers); $inx++){
            $voucher_user_seqno = DB::table('voucher_user')->insertGetId(
                [
                    'membership_seqno' => $membership->seqno
                    , 'voucher_seqno' => $vouchers[$inx]->seqno
                    , 'user_seqno' => $user_seqno
                    , 'used' => 'N'
                    , 'approved' => 'Y'
                    , 'hst_type' => 'S'
                    , 'deleted' => 'Y'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );

            DB::table('voucher_user_history')->insertGetId(
                [
                    'voucher_user_seqno' => $voucher_user_seqno
                    , 'hst_type' => 'S'
                    , 'canceled' => 'N'
                    , 'approved' => 'Y'
                    , 'memo' => '멤버쉽 가입으로 인한 충전'
                    , 'create_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );
        }
        $etcVouchers = DB::table('membership_etc_voucher_grp')->where([
            ['membership_seqno', '=', $membership->seqno]
        ])->get();
        for($inx = 0; $inx < count($etcVouchers); $inx++){
            $voucher_user_seqno = DB::table('voucher_user')->insertGetId(
                [
                    'membership_seqno' => $membership->seqno
                    , 'voucher_seqno' => $etcVouchers[$inx]->etc_voucher_seqno
                    , 'user_seqno' => $user_seqno
                    , 'used' => 'N'
                    , 'approved' => 'Y'
                    , 'hst_type' => 'S'
                    , 'deleted' => 'N'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );

            DB::table('voucher_user_history')->insertGetId(
                [
                    'voucher_user_seqno' => $voucher_user_seqno
                    , 'hst_type' => 'S'
                    , 'canceled' => 'N'
                    , 'approved' => 'Y'
                    , 'memo' => '멤버쉽 가입으로 인한 충전'
                    , 'create_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );
        }
        $coupons = DB::table('membership_coupon_grp')->where([
            ['membership_seqno', '=', $membership->seqno]
        ])->get();
        for($inx = 0; $inx < count($coupons); $inx++){
            $coupon_user_seqno = DB::table('coupon_user')->insertGetId(
                [
                    'coupon_seqno' => $coupons[$inx]->seqno
                    , 'user_seqno' => $user_seqno
                    , 'used' => 'N'
                    , 'real_start_dt' => date('Y-m-d H:i:s')
                    , 'real_end_dt' => ($membership->date_use > 0 ? date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' +'.$membership->date_use.' day')) : '9999-12-30 23:59:59')
                    , 'real_discount_price' => 0
                    , 'approved' => 'Y'
                    , 'hst_type' => 'S'
                    , 'deleted' => 'N'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );

            DB::table('coupon_user_history')->insertGetId(
                [
                    'coupon_user_seqno' => $coupon_user_seqno
                    , 'hst_type' => 'S'
                    , 'canceled' => 'N'
                    , 'approved' => 'Y'
                    , 'memo' => '멤버쉽 가입으로 인한 충전'
                    , 'create_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );
        }

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원에게 멤버쉽이 적용되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }

    // 내가 구매한 멤버쉽 목록
    public function myMemberships(Request $request)
    {
        $user_seqno = $request->get('user_seqno'); // 대상 고객
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        if(empty($user_seqno)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user)) {
            $result['ment'] = '없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        // join product_membership
        $memberships = DB::table("membership_user")
        ->join('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
        ->where([
            ['user_seqno', '=', $user_seqno]
        ])
        ->select('membership_user.*', 'product_membership.name', 'product_membership.price')
        ->orderBy('membership_user.create_dt', 'desc')
        ->get();

        $result['data'] = $memberships;
        $result['result'] = true;

        return $result;
    }

    // 멤버쉽 환불
    public function refund(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 식별자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $membership_seqno = $request->post('membership_seqno'); // 대상 멤버쉽
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($membership_seqno)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        $admin = DB::table("admin_info")->where([
            ['admin_seqno', '=', $admin_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }

        $membership = DB::table("membership_user")->where([
            ['seqno', '=', $membership_seqno],
            ['deleted', '=', 'N']
        ])->first();
        if(empty($membership)) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r없는 멤버쉽이거나 이미 환불된 멤버쉽입니다.';
            return $result;
        }
        $targetTime = date('Y-m-d H:i:s');

        // 멤버쉽 사용 기한이 지난경우
        if($membership->real_end_dt < $targetTime) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r이미 사용기한이 지난 멤버쉽입니다.';
            return $result;
        }
        $membershipInfo = DB::table("product_membership")->where([
            ['seqno', '=', $membership_seqno],
            ['deleted', '=', 'N']
        ])->first();

        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->first();
        /*
        if($point->point + $membershipInfo->price - $membershipInfo->point < 0){
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r환불할 포인트가 부족합니다.';
            return $result;
        }
        */
        
        // 멤버쉽을 이미 사용한 경우
        // 1. 포인트 적립금이 있고, 사용한 경우
        $pointHistoryCount = DB::table("user_point_hst")->where([
            ['user_seqno', '=', $user_seqno],
            ['hst_type', '=', 'U'],
            ['point_type', '=', 'P'],
            ['create_dt', '>', $membership->real_start_dt]
        ])->count();
        if($membershipInfo->point > 0 && $pointHistoryCount > 0) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r이미 포인트를 사용한 멤버쉽입니다.';
            return $result;
        }
        // 2. 쿠폰을 사용한 경우
        $couponHistoryCount = DB::table("coupon_user_history")
        ->join('coupon_user', 'coupon_user_history.coupon_user_seqno', '=', 'coupon_user.seqno')
        ->join('membership_coupon_grp', 'coupon_user.coupon_seqno', '=', 'membership_coupon_grp.coupon_seqno')
        ->where([
            ['coupon_user.user_seqno', '=', $user_seqno],
            ['membership_coupon_grp.membership_seqno', '=', $membership_seqno],
            ['coupon_user_history.hst_type', '=', 'U'],
            ['coupon_user_history.create_dt', '>', $membership->real_start_dt]
        ])->count();
        if($couponHistoryCount > 0) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r이미 쿠폰을 사용한 멤버쉽입니다.';
            return $result;
        }
        // 3. 바우처를 사용한 경우
        $voucherHistoryCount = DB::table("voucher_user_history")
        ->join('voucher_user', 'voucher_user_history.voucher_user_seqno', '=', 'voucher_user.seqno')
        ->join('membership_etc_voucher_grp', 'voucher_user.voucher_seqno', '=', 'membership_etc_voucher_grp.etc_voucher_seqno')
        ->where([
            ['voucher_user.user_seqno', '=', $user_seqno],
            ['membership_etc_voucher_grp.membership_seqno', '=', $membership_seqno],
            ['voucher_user_history.hst_type', '=', 'U'],
            ['voucher_user_history.create_dt', '>', $membership->real_start_dt]
        ])->count();
        if($voucherHistoryCount > 0) {
            $result['ment'] = '멤버쉽이 환불되지 않았습니다.\r이미 바우처를 사용한 멤버쉽입니다.';
            return $result;
        }
        // 멤버쉽 쿠폰을 모두 삭제
        {
            // 가진 쿠폰 삭제
            $coupons = DB::table("coupon_user")
            ->join('membership_coupon_grp', 'coupon_user.coupon_seqno', '=', 'membership_coupon_grp.coupon_seqno')
            ->where([
                ['coupon_user.user_seqno', '=', $user_seqno],
                ['membership_coupon_grp.membership_seqno', '=', $membership_seqno],
                ['coupon_user.deleted', '=', 'N']
            ])->get();
            for($inx = 0; $inx < count($coupons); $inx++){
                DB::table('coupon_user')->where('seqno', '=', $coupons[$inx]->seqno)->update(
                    [
                        'deleted' => 'Y', 
                        'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
                
                DB::table('coupon_user_history')->insertGetId(
                    [
                        'coupon_user_seqno' => $coupons[$inx]->seqno
                        , 'hst_type' => 'R'
                        , 'canceled' => 'N'
                        , 'approved' => 'Y'
                        , 'memo' => '멤버쉽 환불로 인한 삭제'
                        , 'create_dt' => date('Y-m-d H:i:s')
                    ], 'seqno'
                );
            }
        }
        // 멤버쉽 바우처를 모두 삭제
        {
            // 가진 바우처를 삭제
            $vouchers = DB::table("voucher_user")
            ->join('membership_etc_voucher_grp', 'voucher_user.voucher_seqno', '=', 'membership_etc_voucher_grp.etc_voucher_seqno')
            ->where([
                ['voucher_user.user_seqno', '=', $user_seqno],
                ['membership_etc_voucher_grp.membership_seqno', '=', $membership_seqno],
                ['voucher_user.deleted', '=', 'N']
            ])->get();
            for($inx = 0; $inx < count($vouchers); $inx++){
                DB::table('voucher_user')->where('seqno', '=', $vouchers[$inx]->seqno)->update(
                    [
                        'deleted' => 'Y', 
                        'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );

                DB::table('voucher_user_history')->insertGetId(
                    [
                        'voucher_user_seqno' => $vouchers[$inx]->seqno
                        , 'hst_type' => 'S'
                        , 'canceled' => 'N'
                        , 'approved' => 'Y'
                        , 'memo' => '멤버쉽 환불로 인한 삭제'
                        , 'create_dt' => date('Y-m-d H:i:s')
                    ], 'seqno'
                );
            }
        }
        // 멤버쉽 포인트를 반환 처리
        {
            DB::table('user_point_hst')->insertGetId(
                [
                    'admin_seqno' => $admin_seqno
                    , 'user_seqno' => $user_seqno
                    , 'admin_name' => $admin_name
                    , 'point_type' => 'P'
                    , 'product_seqno' => 0
                    , 'hst_type' => 'R'
                    , 'point' => /* $membershipInfo->price - */ $membershipInfo->point
                    , 'memo' => '멤버쉽 환불로 인한 포인트 반환'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'user_point_hst_seqno'
            );
            DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', 'P']
            ])->update(
                [
                    'point' => $point->point - $membershipInfo->point /*+ $membershipInfo->price */
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }
        DB::table("membership_user")->where([
            ['seqno', '=', $membership_seqno],
            ['deleted', '=', 'N']
        ])->update(
            [
                'deleted' => 'Y'
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $id = DB::table('membership_user_hst')->insertGetId(
            [
                'membership_user_seqno' => $membership->seqno
                , 'user_seqno' => $user_seqno
                , 'hst_type' => 'R'
                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
            ]
        );

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$membershipInfo->name.'] 멤버쉽이 환불되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
}
