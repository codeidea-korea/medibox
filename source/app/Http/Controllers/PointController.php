<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $user_seqno = $request->get('no');
        $startDt = $request->get('startDt');
        $endDt = $request->get('endDt');
        $hst_type = $request->get('hst_type');
        
        $user_phone = $request->get('user_phone');
        $user_name = $request->get('user_name');
        
        $point_type = $request->get('point_type');
        $startPoint = $request->get('startPoint');
        $endPoint = $request->get('endPoint');
        $admin_name = $request->get('admin_name');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        $whereUser = [];
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['user_point_hst.user_seqno', '=', $user_seqno]);
        }
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['user_point_hst.user_seqno', '=', $user_seqno]);
        }
        if(! empty($hst_type) && $hst_type != ''){
            array_push($where, ['user_point_hst.hst_type', '=', $hst_type]);
        }
        if(! empty($user_phone) && $user_phone != ''){
            array_push($whereUser, ['user_info.user_phone', 'like', '%'.$user_phone.'%']);
        }
        if(! empty($user_name) && $user_name != ''){
            array_push($whereUser, ['user_info.user_name', 'like', '%'.$user_name.'%']);
        }
        if(! empty($startDt) && $startDt != ''){
            array_push($whereUser, ['user_point_hst.create_dt', '>=', $startDt . ' 00:00:00']);
        }
        if(! empty($endDt) && $endDt != ''){
            array_push($whereUser, ['user_point_hst.create_dt', '<=', $endDt . ' 00:00:00']);
        }
        
        if(! empty($startPoint) && $startPoint != ''){
            array_push($where, ['user_point_hst.point', '>=', $startPoint]);
        }
        if(! empty($endPoint) && $endPoint != ''){
            array_push($where, ['user_point_hst.point', '<=', $endPoint]);
        }
        if(! empty($admin_name) && $admin_name != ''){
            array_push($where, ['user_point_hst.admin_name', 'like', '%'.$admin_name.'%']);
        }
        
        $contents = DB::table("user_point_hst")
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                     ->where($whereUser);
            })
            ->leftJoin('product', 'user_point_hst.product_seqno', '=', 'product.product_seqno')
            ->leftJoin('store_service', 'user_point_hst.service_seqno', '=', 'store_service.seqno')
            ->leftJoin('partner', 'partner.seqno', '=', 'store_service.partner_seqno')
            ->leftJoin('store', 'store.seqno', '=', 'store_service.store_seqno')
            ->leftJoin('admin_info', 'user_point_hst.admin_seqno', '=', 'admin_info.admin_seqno');
        $count = DB::table("user_point_hst")
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            });

        if(! empty($point_type) && $point_type != ''){
            if($point_type == 'S') {
                $contents = $contents->whereNotIn('user_point_hst.point_type', ['P','K']);
                $count = $count->whereNotIn('user_point_hst.point_type', ['P','K']);
            } else {
                array_push($where, ['user_point_hst.point_type', '=', $point_type]);
            }
        }
        $contents = $contents
            ->where($where)
            ->orderBy('user_point_hst.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->select(DB::raw('user_point_hst.*, user_info.user_phone as user_phone, user_info.user_name as user_name, product.service_name as service_name, product.type_name as type_name'
                . ', store_service.name as store_service_name, partner.cop_name as cop_name, store.name as store_name, admin_info.admin_name as adm_admin_name'))
            ->get();
        $count = $count
            ->where($where)
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function conf(Request $request)
    { 
        $admin_seqno = $request->post('admin_seqno');

        $join_bonus = $request->post('join_bonus', 'N');
        $join_bonus_point = $request->post('join_bonus_point', 0); 
        $recommand_bonus = $request->post('recommand_bonus', 'Y');
        $recommand_bonus_point = $request->post('recommand_bonus_point', 0);
        $recommand_bonus_rate = $request->post('recommand_bonus_rate', 2);

        DB::table('conf_auto_point')->update(
            [
                'join_bonus' => $join_bonus
                , 'join_bonus_point' => $join_bonus_point
                , 'recommand_bonus' => $recommand_bonus
                , 'recommand_bonus_point' => $recommand_bonus_point
                , 'recommand_bonus_rate' => $recommand_bonus_rate
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['result'] = true;

        return $result;
    }

    // 나의 포인트 조회 - 일반 고객
    public function myPoint(Request $request)
    {
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $point_type = $request->post('point_type', ''); // 

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
            return $result;
        }

        $where = [];
        array_push($where, ['user_seqno', '=', $user_seqno]);
        if(! empty($point_type) && $point_type != ''){
            array_push($where, ['point_type', '=', $point_type]);
        }
        $point = DB::table('user_point')->where($where)->get();

        $package = DB::table("user_package")->where([
            ['user_seqno', '=', $user_seqno],
            ['deleted', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $point;
        $result['package'] = $package;
        $result['result'] = true;

        return $result;
    }
    // 나의 결제 내역 (포인트/정액권/ 전체)
    public function myPayments(Request $request)
    { 
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $hst_type = $request->post('hst_type', ''); // U: 사용, R: 환불, S: 충전, !U: 사용이 아닌것
        $point_type = $request->post('point_type', ''); // 
        $startDay = $request->post('startDay', '');
        $endDay = $request->post('endDay', '');
        $pageSize = $request->post('pageSize', 20);
        $pageNo = $request->post('pageNo', 1);

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
            return $result;
        }
        $where = [];
        array_push($where, ['user_seqno', '=', $user_seqno]);
        if(! empty($hst_type) && $hst_type == '!U'){
            //
        } else if(! empty($hst_type) && $hst_type != ''){
            array_push($where, ['hst_type', '=', $hst_type]);
        }
        if(! empty($point_type) && $point_type == '!P'){
            array_push($where, ['point_type', '!=', 'P']);
        } else if(! empty($point_type) && $point_type != ''){
            array_push($where, ['point_type', '=', $point_type]);
        }
        if(! empty($startDay) && $startDay != ''){
            array_push($where, ['create_dt', '>', $startDay]);
        }
        if(! empty($endDay) && $endDay != ''){
            array_push($where, ['create_dt', '<', $endDay]);
        }

        $points;
        if(! empty($hst_type) && $hst_type == '!U'){
            $points = DB::table('user_point_hst')->where($where)
                ->where(function($query) {
                    $query->orWhere('hst_type', 'R')
                        ->orWhere('hst_type', 'S');
                })
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)->orderByDesc('user_point_hst_seqno')->get();
        } else {
            $points = DB::table('user_point_hst')->where($where)
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)->orderByDesc('user_point_hst_seqno')->get();
        }
        
        for($inx = 0; $inx < count($points); $inx++){
            if(empty($points[$inx]->product_seqno)) {
                continue;
            }
            $detail = DB::table("product")
                ->where([
                    ['product_seqno', '=', $points[$inx]->product_seqno]
                ])->first();
            $points[$inx]->detail = $detail;
        }

        $result['ment'] = '성공';
        $result['data'] = $points;
        $result['result'] = true;

        return $result;
    }

    // 포인트 충전
    public function collect(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno', 0); // 대상 상품 식별번호 (포인트는 0번)
        $point_type = $request->post('point_type'); // 적립 구분 (포인트는 P)
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
        $memo = $request->post('memo', '');

        $reIssueCoupon = $request->post('reIssueCoupon', 0); // 쿠폰 되살릴 번호
        
        $result = [];
        $result['ment'] = '포인트가 적립되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type)) {
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
            $result['ment'] = '포인트가 적립되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }

        $price = $amount;
        if($product_seqno != 0 && $point_type != 'P') {
            // 패키지의 경우, 계정 최초 1회만 구매 가능함
            if($point_type == 'K') {
                // 내 적립 내역 뒤져서 존재 하는지 확인
                /*
                $pointHistory = DB::table("user_point_hst")->where([
                    ['user_seqno', '=', $user_seqno],
                    ['point_type', '=', 'K']
                ])->first();
                */
                $pointHistory = DB::table("user_package")->where([
                    ['user_seqno', '=', $user_seqno],
                    ['deleted', '=', 'N']
                ])->first();
                
                if(! empty($pointHistory)) {
                    $result['ment'] = '포인트가 적립되지 않았습니다.\r패키지는 적립 이력이 있어 패키지 적립이 불가능합니다.';
                    return $result;
                }
            }
            $product = DB::table("product")->where([
                ['product_seqno', '=', $product_seqno],
                ['point_type', '=', $point_type]
            ])->first();

            if(empty($product)) {
                $result['ment'] = '포인트가 적립되지 않았습니다.\r존재하지 않는 서비스입니다.';
                return $result;
            }
            $amount = $product->return_point;
            $price = $product->price;
        } else {
            if($point_type != 'P') {
                return $result;
            }
            if(empty($amount) || $amount < 1) {
                return $result;
            }
            $product_seqno = 0;
        }
        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => $point_type
                , 'product_seqno' => $product_seqno
                , 'hst_type' => 'S'
                , 'point' => $amount
                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        // 내 포인트에 증가 처리
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', ($point_type == 'K' || $point_type == 'S1' ? 'P' : $point_type)]
        ])->first();

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', ($point_type == 'K' || $point_type == 'S1' ? 'P' : $point_type)]
        ])->update(
            [
                'point' => $point->point + $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        // 패키지 데이터 저장
        if($point_type == 'K') {
            $id = DB::table('user_package')->insertGetId(
                [
                    'user_seqno' => $user_seqno
                    , 'hst_type' => 'S'
                    , 'allow_refund' => 'Y'
                    , 'deleted' => 'N'
                    , 'point' => $amount 
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
            DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', $point_type]
            ])->update(
                [
                    'point' => $point->point + $amount
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }
        
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
                        'point' => $point->point + $amount + $etcPoint
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
        // 쿠폰 반환
        if(!empty($reIssueCoupon) && $reIssueCoupon > 0) {
            
            $coupon = DB::table("coupon_user")->where([
                ['seqno', '=', $reIssueCoupon]
            ])->first();

            if(!empty($coupon)) {
                DB::table('coupon_user')->where([
                    ['seqno', '=', $reIssueCoupon]
                ])->update(
                    [
                        'used' => 'N', 
                        'real_discount_price' => 0, 
                        'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
                DB::table('coupon_user_history')->insertGetId(
                    [
                        'coupon_user_seqno' => $reIssueCoupon,
                        'hst_type' => 'S',
                        'canceled' => 'N',
                        'approved' => 'N',
                        'memo' => '[쿠폰 반환] 예약 수정/취소로 인한 쿠폰 반환',
                        'create_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$amount.'] point가 적립되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }

    // 포인트 환불
    public function refund(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno', 0); // 대상 상품 식별번호 (포인트는 0번)
        $point_type = $request->post('point_type'); // 적립 구분 (포인트는 P)
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 환불되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($amount) || $amount < 0) {
            $result['ment'] = '포인트가 환불되지 않았습니다.\r환불할 포인트는 0보다 큰 자연수여야 합니다.';
            return $result;
        }
        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type)) {
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
            $result['ment'] = '포인트가 환불되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        // 패키지일 경우, 
        if($point_type == 'K') {
            $pointHistory = DB::table("user_package")->where([
                ['user_seqno', '=', $user_seqno],
                ['deleted', '=', 'N']
            ])->first();

            // 적립 여부 확인
            if(empty($pointHistory)) {
                $result['ment'] = '포인트가 환불되지 않았습니다.\r패키지 적립 이력이 없습니다.';
                return $result;
            }
            // 패키지 구매후 사용 이력이 있으면 환불 안됨
            $countCollectPackageAfterUsed = DB::table("user_point_hst")->where([
                ['hst_type', '=', 'U'],
                ['create_dt', '>', $pointHistory->create_dt]
            ])->count();
            if($countCollectPackageAfterUsed > 0) {
                $result['ment'] = '포인트가 환불되지 않았습니다.\r패키지 포인트 충전후 사용한 내역이 있습니다.';
                return $result;
            }            
            // 전액 환불이 아니면 환불 안됨
            if($pointHistory->point != $amount) {
                $result['ment'] = '포인트가 환불되지 않았습니다.\r패키지 포인트의 환불은 전액 환불만 가능합니다.';
                return $result;
            }
        }

        // TODO: 현재 구매 상품을 기준으로 환불이 이루어지지 않으므로, 정확한 의미의 환불은 아니고, 환불 처리를 정확하게 돌리려면 구매키를 받아서 검증을 해야함!
/*
        if($product_seqno != 0 && $point_type != 'P') {
            $product = DB::table("product")->where([
                ['product_seqno', '=', $product_seqno],
                ['point_type', '=', $point_type]
            ])->first();

            if(empty($product)) {
                return $result;
            }
            // 상품 구매 여부 확인 - 구매한 적 없는 경우 환불 불가            
            $pointHistory = DB::table("user_point_hst")->where([
                ['product_seqno', '=', $product_seqno],
                ['point_type', '=', $point_type],
                ['hst_type', '=', 'U'],
                ['refund_point_hst_seqno', 'is', '']
            ])->first();
            if(empty($pointHistory)) {
                $result['ment'] = $result['ment'] . ' - 구매한 적 없는 경우 환불 불가';
                return $result;
            }
            $amount = $product->return_point;
        } else {
            if($point_type != 'P') {
                return $result;
            }
            if(empty($amount) || $amount < 1) {
                return $result;
            }
            $product_seqno = 0;
        }
        */
        // 내 포인트에 차감 처리
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', ($point_type == 'K' || $point_type == 'S1' ? 'P' : $point_type)]
        ])->first();
        // 차감 가능 여부 확인
        if(empty($point) || $point->point < $amount) {
            $result['ment'] = $result['ment'] . ' - 사용 포인트 부족';
            return $result;
        }

        // 히스토리에 포인트 이력 추가
        $refund_point_hst_seqno = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => $point_type
                , 'product_seqno' => $product_seqno
                , 'hst_type' => 'R'
                , 'point' => $amount
                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $pointHistory = DB::table("user_point_hst")->where([
            ['product_seqno', '=', $product_seqno],
            ['point_type', '=', $point_type],
            ['hst_type', '=', 'U'],
            ['refund_point_hst_seqno', 'is', null]
        ])->update([
            'refund_point_hst_seqno' => $refund_point_hst_seqno
            , 'update_dt' => date('Y-m-d H:i:s') 
        ]);

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', ($point_type == 'K' || $point_type == 'S1' ? 'P' : $point_type)]
        ])->update(
            [
                'point' => $point->point - $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        // 패키지일 경우, 
        if($point_type == 'K') {
            DB::table('user_package')->where([
                ['user_seqno', '=', $user_seqno],
                ['deleted', '=', 'N']
            ])->update(
                [
                    'deleted' => 'Y'
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
            DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', $point_type]
            ])->update(
                [
                    'point' => 0
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$amount.'] point가 환불되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
    // 포인트 사용
    public function use(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 구매 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno'); // 대상 상품 식별번호
        $coupon_seqno = $request->post('coupon_seqno'); // 사용 쿠폰 일련번호
        $discount = $request->post('discount'); // 
        $service_seqno = $request->post('service_seqno'); // 대상 서비스 식별번호
        $point_type = $request->post('point_type'); // 사용 구분
        $memo = $request->post('memo', '');
        $approved = $request->post('approved', 'N');

        $pass_type = $request->post('point_type2'); // 정액권 구분
        $pass_amount = $request->post('amount', 0); // 정액권 사용 금액

        $result = [];
        $result['ment'] = '포인트가 사용되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['code'] = 'USER-INPUT';
        $result['result'] = false;

        if(empty($user_seqno) || empty($point_type)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            $result['ment'] = '포인트가 사용되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $product;
        $service_name = '';
        if(!empty($product_seqno)) {
            $product = DB::table("product")->where([
                ['product_seqno', '=', $product_seqno]
            ])->first();
        }
        if(!empty($service_seqno)) {
            $product = DB::table("store_service")->where([
                ['seqno', '=', $service_seqno]
            ])->first();
            $service_name = $product->name;
        }
        if(empty($product)) {
            $result['code'] = 'SERVICE-NULL';
            return $result;
        }

        if(!empty($coupon_seqno) && $coupon_seqno > 0) {
            $coupon = DB::table("coupon_user")->where([
                ['seqno', '=', $coupon_seqno]
            ])->first();

            if(!empty($coupon)) {
                DB::table('coupon_user')->where([
                    ['seqno', '=', $coupon_seqno]
                ])->update(
                    [
                        'used' => 'Y', 
                        'real_discount_price' => $discount, 
                        'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
                DB::table('coupon_user_history')->insertGetId(
                    [
                        'coupon_user_seqno' => $coupon_seqno,
                        'hst_type' => 'U',
                        'canceled' => 'N',
                        'approved' => 'N',
                        'memo' => '[쿠폰 사용] 예약',
                        'create_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        } else {
            $discount = 0;
        }
        
        $amount = $product->price - $discount - $pass_amount;
        // 내 포인트에 차감 처리
        {
            $point = DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', $point_type]
            ])->first();
            // 차감 가능 여부 확인
            if(empty($point) || $point->point < $amount) {
                $result['ment'] = $result['ment'] . ' - 사용 포인트 부족';
                $result['code'] = 'POINT-LESS';
                return $result;
            }
        }
        if(!empty($pass_type) && $pass_amount > 0) {
            // 정액권 부분 결제건
            $pass = DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', $pass_type]
            ])->first();
            // 차감 가능 여부 확인
            if(empty($pass) || $pass->point < $pass_amount) {
                $result['ment'] = $result['ment'] . ' - 정액권 사용 포인트 부족';
                $result['code'] = 'POINT-LESS';
                return $result;
            }
        }
        
        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => $point_type
                , 'product_seqno' => $product_seqno
                , 'product_name' => $service_name
                , 'service_seqno' => $service_seqno
                , 'hst_type' => 'U'
                , 'point' => $amount
                , 'memo' => $memo
                , 'approved' => $approved
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'user_point_hst_seqno' 
        );

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', $point_type]
        ])->update(
            [
                'point' => $point->point - $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        if(!empty($pass_type) && $pass_amount > 0) {
            // 히스토리에 정액권 이력 추가
            $id = DB::table('user_point_hst')->insertGetId(
                [
                    'admin_seqno' => $admin_seqno
                    , 'user_seqno' => $user_seqno
                    , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                    , 'point_type' => $pass_type
                    , 'product_seqno' => $product_seqno
                    , 'product_name' => $service_name
                    , 'service_seqno' => $service_seqno
                    , 'hst_type' => 'U'
                    , 'point' => $pass_amount
                    , 'memo' => $memo
                    , 'approved' => $approved
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'user_point_hst_seqno' 
            );

            DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', $pass_type]
            ])->update(
                [
                    'point' => $pass->point - $pass_amount
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$amount.'] point가 사용되었습니다.';
        $result['data'] = $id;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
    // 적립2 - 상품명하고 금액만으로 관리자 직접 입력 (서비스가 없는 경우)
    public function useBySelf(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $shop_name = $request->post('shop_name', ''); // 대상 샵명
        $service_name = $request->post('service_name', ''); // 대상 상품명
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)

        $point_type = $request->post('point_type'); // 사용 구분
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 사용되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['code'] = 'USER-INPUT';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type) || empty($shop_name) || empty($service_name)) {
            return $result;
        }
        if(empty($amount) || $amount < 1) {
            $result['ment'] = '포인트가 사용되지 않았습니다.\r사용할 포인트는 0보다 큰 자연수여야 합니다.';
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
            $result['ment'] = '포인트가 사용되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        // 내 포인트에 차감 처리
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', $point_type]
        ])->first();
        // 차감 가능 여부 확인
        if(empty($point) || $point->point < $amount) {
            $result['ment'] = $result['ment'] . '\r사용가능한 포인트가 부족합니다.';
            $result['code'] = 'POINT-LESS';
            return $result;
        }

        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'point_type' => $point_type
                , 'admin_name' => empty($admin) ? '' : $admin->admin_name
                , 'product_seqno' => 0
                , 'shop_name' => $shop_name
                , 'product_name' => $service_name
                , 'hst_type' => 'U'
                , 'point' => $amount
                , 'memo' => $memo
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', $point_type]
        ])->update(
            [
                'point' => $point->point - $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$amount.'] point가 사용되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
    // 포인트 작업 취소
    public function cancel(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 취소 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 취소 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $hst_type = $request->post('hst_type', 'U'); // 사용 구분
        $hst_seqno = $request->post('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '포인트가 취소되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['code'] = 'USER-INPUT';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($hst_type) || empty($hst_seqno) || $hst_type != 'U') {
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
            $result['ment'] = '포인트가 취소되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("user_point_hst")->where([
            ['user_point_hst_seqno', '=', $hst_seqno],
            ['hst_type', '=', $hst_type],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '포인트가 취소되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '포인트가 취소되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $history->user_seqno],
            ['point_type', '=', $history->point_type]
        ])->first();

        // 정보를 취소 정보로 업데이트 하고, 각각의 상태에 따른 역작업을 진행한다.
        // 1. 사용을 취소한다.
        DB::table('user_point')->where([
            ['user_seqno', '=', $history->user_seqno],
            ['point_type', '=', $history->point_type]
        ])->update(
            [
                'point' => $point->point + $history->point, 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('user_point_hst')->where([
            ['user_point_hst_seqno', '=', $hst_seqno],
            ['canceled', '=', 'N']
        ])->update(
            [
                'canceled' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '취소되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
    // 포인트 사용 승인
    public function approve(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 취소 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 취소 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $hst_seqno = $request->post('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '포인트가 승인되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['code'] = 'USER-INPUT';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($hst_seqno)) {
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
            $result['ment'] = '포인트가 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("user_point_hst")->where([
            ['user_point_hst_seqno', '=', $hst_seqno],
            ['hst_type', '=', 'U'],
            ['approved', '=', 'N'],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '포인트가 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '포인트가 승인되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        DB::table('user_point_hst')->where([
            ['user_point_hst_seqno', '=', $hst_seqno]
        ])->update(
            [
                'approved' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '사용되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
    // 포인트 사용 승인 확인
    public function checkApproved(Request $request)
    {
        $user_seqno = $request->get('user_seqno'); // 대상 고객
        $hst_seqno = $request->get('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '포인트가 승인되지 않았습니다.';
        $result['code'] = 'USER-INPUT';
        $result['result'] = false;

        if(empty($user_seqno) || empty($hst_seqno)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            $result['ment'] = '포인트가 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("user_point_hst")->where([
            ['user_point_hst_seqno', '=', $hst_seqno],
            ['hst_type', '=', 'U'],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '포인트가 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->approved == 'Y') {
            $result['ment'] = '승인되었습니다.';
            $result['data'] = $user;
            $result['code'] = 'S1';
            $result['result'] = true;
        } else {
            $result['ment'] = '승인 대기중입니다. 잠시 기다려주세요.';
            $result['data'] = $user;
            $result['code'] = 'S2';
            $result['result'] = true;
        }

        return $result;
    }

    // 포인트 타입 조회 (전체)
    public function getTypes(Request $request)
    {
        $result = [];
        $result['ment'] = '조회에 실패하였습니다.';
        $result['result'] = false;

        $pointTypes = DB::table("point_info")
            ->orderBy('create_dt', 'desc')
            ->get();

        $result['ment'] = '정상 조회 되었습니다.';
        $result['data'] = $pointTypes;
        $result['result'] = true;

        return $result;
    }
    // 해당 포인트로 구매 가능한 샵 조회 (포인트 종류) -> (샵)
    public function getShops(Request $request)
    {
        $point_type = $request->get('point_type', 'P'); // 포인트 타입

        $result = [];
        $result['ment'] = '조회에 실패하였습니다.';
        $result['result'] = false;

        $where = [];
        array_push($where, ['offline_type', '=', 'Y']);
        array_push($where, ['delete_yn', '=', 'N']);
        if (!empty($point_type) && $point_type != '' && $point_type != 'P') {
            array_push($where, ['point_type', '=', $point_type]);
        }

        $shops = DB::table("product")
            ->where($where)
            ->select('service_name', 'point_type')
            ->distinct()
            ->orderBy('service_name', 'asc')
            ->orderBy('orders', 'asc')
            ->get();

        $result['ment'] = '정상 조회 되었습니다.';
        $result['data'] = $shops;
        $result['result'] = true;

        return $result;
    }
    // 타입에 해당하는 포인트 리턴 리스트
    public function getCollects(Request $request)
    {
        $point_type = $request->get('point_type', 'P'); // 포인트 타입

        $result = [];
        $result['ment'] = '조회에 실패하였습니다.';
        $result['result'] = false;

        $where = [];
        array_push($where, ['offline_type', '=', 'N']);
        array_push($where, ['return_point', '>', 0]);
        array_push($where, ['delete_yn', '=', 'N']);
        if (!empty($point_type) && $point_type != '' && $point_type != 'P') {
            array_push($where, ['point_type', '=', $point_type]);
        }

        $shops = DB::table("product")
            ->where($where)
            ->select('product_seqno', 'point_type', 'type_name', 'service_sub_name', 'price', 'return_point')
            ->distinct()
            ->orderBy('point_type', 'asc')
//            ->orderBy('service_sub_name', 'asc')
            ->orderBy('orders', 'asc')
            ->get();

        $result['ment'] = '정상 조회 되었습니다.';
        $result['data'] = $shops;
        $result['result'] = true;

        return $result;
    }
    // 해당 샵의 서비스 조회 (포인트, 샵) -> (서비스)
    public function getServices(Request $request)
    {
        $point_type = $request->get('point_type', 'P'); // 포인트 타입
        $service_name = $request->get('service_name', '발몽스파'); // 샵이름

        $result = [];
        $result['ment'] = '조회에 실패하였습니다.';
        $result['result'] = false;

        $where = [];
        array_push($where, ['delete_yn', '=', 'N']);
        array_push($where, ['offline_type', '=', 'Y']);
        if (!empty($point_type) && $point_type != '' && $point_type != 'P') {
            array_push($where, ['point_type', '=', $point_type]);
        }
        if (!empty($service_name) && $service_name != '') {
            array_push($where, ['service_name', '=', $service_name]);
        }

        $services = DB::table("product")
            ->where($where)
            ->select('product_seqno', 'type_name', 'service_sub_name', 'price')
            ->distinct()
            ->orderBy('point_type', 'asc')
            ->orderBy('orders', 'asc')
            ->get();

        $result['ment'] = '정상 조회 되었습니다.';
        $result['data'] = $services;
        $result['result'] = true;

        return $result;
    }













































    // 정산
    public function getCalculate(Request $request)
    {
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');

        $store_seqno = $request->get('store_seqno');
        $service_type = $request->get('service_type'); // 서비스별 구분 (멤버쉽, 바우처, 쿠폰, 패키지, 정액권, 서비스, 예약)
        $hst_type = $request->get('hst_type'); // 구매 내역별 구분 (사용/예약, 충전/예약취소, 환불)

        $user_name = $request->get('user_name'); // 고객 이름
        
        $search_field = $request->get('searchField'); // 고객 이름/아이디
        $search_field_recommand = $request->get('searchFieldRecommand'); // 추천 고객 이름/아이디
        $pucharse_memo = $request->get('memo'); // 결제 메모
        $reservation_memo = $request->get('memo2'); // 예약 메모

        $result = [];
        $result['ment'] = '조회에 실패하였습니다.';
        $result['result'] = false;

        $latestReservation = DB::table('reservation')
            ->select('reservation.user_seqno', DB::raw('MAX(reservation.start_dt) as last_start_dt'))
            ->where([
                ['reservation.status', '!=', 'C'],
                ['reservation.deleted', '=', 'N']
            ])
            ->groupBy('reservation.user_seqno');

        if ((empty($service_type) || $service_type == 'K' || $service_type == 'F') && empty($reservation_memo)) {
            // 포인트 이력 조회 (패키지, 정액권, 서비스)
            $where = [];
            if (!empty($start_dt) && $start_dt != '') {
                array_push($where, ['user_point_hst.create_dt', '>=', $start_dt]);
            }
            if (!empty($end_dt) && $end_dt != '') {
                array_push($where, ['user_point_hst.create_dt', '<=', $end_dt]);
            }
            if (!empty($pucharse_memo) && $pucharse_memo != '') {
                array_push($where, ['user_point_hst.memo', 'like', '%'.$pucharse_memo.'%']);
            }
            if (!empty($service_type) && $service_type != '') {
                if ($service_type == 'K') {
                    array_push($where, ['user_point_hst.point_type', '=', 'K']);
                } else if ($service_type == 'F') {
                    array_push($where, ['user_point_hst.point_type', '!=', 'K']);
                    array_push($where, ['user_point_hst.point_type', '!=', 'P']);
                }
            }
            if (!empty($hst_type) && $hst_type != '') {
                array_push($where, ['user_point_hst.hst_type', '=', $hst_type]);
            }
            if (!empty($user_name) && $user_name != '') {
                array_push($where, ['user_info.user_name', 'like', '%'.$user_name.'%']);
            }
            if (!empty($store_seqno) && $store_seqno != '') {
                array_push($where, ['store.seqno', '=', $store_seqno]);

                $result['pointHistory'] = DB::table("user_point_hst")
                    ->join('user_info', 'user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->leftJoin('product', 'user_point_hst.product_seqno', '=', 'product.product_seqno')
                    ->join('partner', 'partner.type_code', '=', 'product.point_type')
                    ->join('store', 'partner.seqno', '=', 'store.partner_seqno')
                    ->leftJoin('admin_info', 'user_point_hst.admin_seqno', '=', 'admin_info.admin_seqno')
                    ->leftJoin('user_info as recommand_user', 'recommand_user.user_phone', '=', 'user_info.recommended_code')
                    ->join('user_point', function ($join) {
                        $join->on('user_point.user_seqno', '=', 'user_info.user_seqno')
                            ->where('user_point.point_type', '=', 'P');
                    })
                    ->joinSub($latestReservation, 'latest_reservation', function ($join) {
                        $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno');
                    });
            } else {
                $result['pointHistory'] = DB::table("user_point_hst")
                    ->join('user_info', 'user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->leftJoin('product', 'user_point_hst.product_seqno', '=', 'product.product_seqno')
                    ->leftJoin('partner', 'partner.type_code', '=', 'product.point_type')
                    ->leftJoin('admin_info', 'user_point_hst.admin_seqno', '=', 'admin_info.admin_seqno')
                    ->leftJoin('user_info as recommand_user', 'recommand_user.user_phone', '=', 'user_info.recommended_code')
                    ->join('user_point', function ($join) {
                        $join->on('user_point.user_seqno', '=', 'user_info.user_seqno')
                            ->where('user_point.point_type', '=', 'P');
                    })
                    ->joinSub($latestReservation, 'latest_reservation', function ($join) {
                        $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno');
                    });
            }
            
            if (!empty($search_field) && $search_field != '') {
                $result['pointHistory'] = $result['pointHistory']
                    ->where(function($query) use ($search_field){
                        $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                            ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                    });
            }
            if (!empty($search_field_recommand) && $search_field_recommand != '') {
                $result['pointHistory'] = $result['pointHistory']
                    ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                    ->where(function($query) use ($search_field_recommand){
                        $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$search_field_recommand.'%')
                            ->orWhere('recommand_user_info.user_name', 'like', '%'.$search_field_recommand.'%');
                    });
            }

            $result['pointHistory'] = $result['pointHistory']
                ->where($where)
                ->whereNull('user_point_hst.service_seqno')
                ->orderBy('user_point_hst.create_dt', 'desc')
                ->select(DB::raw('user_point_hst.*, user_point_hst.point as price, '
                    . 'user_info.user_seqno as user_seqno, user_info.user_name as user_name, user_info.user_phone as user_phone, '
                    . 'recommand_user.user_seqno as recommand_user_seqno, recommand_user.user_name as recommand_user_name, recommand_user.user_phone as recommand_user_phone, '
                    . 'user_point.point as user_remain_point, '
                    . 'latest_reservation.last_start_dt as last_reservation_start_dt, '
                    . 'product.service_name as service_name, product.type_name as type_name, product.service_sub_name as service_sub_name, '
                    . 'admin_info.admin_name as admin_name, '
                    . 'user_point_hst.point_type as point_type, user_point_hst.hst_type as hst_type'))
                ->get();
        }

        if ((empty($service_type) || $service_type == 'M') && empty($reservation_memo) && empty($pucharse_memo)) {
            // 멤버쉽 이력 조회 (멤버쉽) 
            $where = [];
            if (!empty($start_dt) && $start_dt != '') {
                array_push($where, ['membership_user_hst.create_dt', '>=', $start_dt]);
            }
            if (!empty($end_dt) && $end_dt != '') {
                array_push($where, ['membership_user_hst.create_dt', '<=', $end_dt]);
            }
            if (!empty($hst_type) && $hst_type != '') {
                array_push($where, ['membership_user_hst.hst_type', '=', $hst_type]);
            }
            if (!empty($store_seqno) && $store_seqno != '') {
                array_push($where, ['membership_user_hst.service_seqno', '=', $store_seqno]);
            }
            if (!empty($user_name) && $user_name != '') {
                array_push($where, ['user_info.user_name', 'like', '%'.$user_name.'%']);
            }
            
            $result['membershipHistory'] = DB::table("membership_user_hst")
                ->join('membership_user', 'membership_user_hst.membership_user_seqno', '=', 'membership_user.seqno')
                ->join('user_info', 'membership_user.user_seqno', '=', 'user_info.user_seqno')
                ->leftJoin('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
    //            ->leftJoin('store_service', 'membership_user_hst.service_seqno', '=', 'store_service.seqno')
        //            ->leftJoin('partner', 'partner.seqno', '=', 'store_service.partner_seqno')
    //            ->leftJoin('store', 'store.seqno', '=', 'store_service.store_seqno')
    //            ->leftJoin('admin_info', 'user_point_hst.admin_seqno', '=', 'admin_info.admin_seqno')
                ->leftJoin('user_info as recommand_user', 'recommand_user.user_phone', '=', 'user_info.recommended_code')
                ->join('user_point', function ($join) {
                    $join->on('user_point.user_seqno', '=', 'user_info.user_seqno')
                        ->where('user_point.point_type', '=', 'P');
                })
                ->joinSub($latestReservation, 'latest_reservation', function ($join) {
                    $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno');
                })
            ;
            if (!empty($search_field) && $search_field != '') {
                $result['membershipHistory'] = $result['membershipHistory']
                    ->where(function($query) use ($search_field){
                        $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                            ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                    });
            }
            if (!empty($search_field_recommand) && $search_field_recommand != '') {
                $result['membershipHistory'] = $result['membershipHistory']
                    ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                    ->where(function($query) use ($search_field_recommand){
                        $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$search_field_recommand.'%')
                            ->orWhere('recommand_user_info.user_name', 'like', '%'.$search_field_recommand.'%');
                    });
            }
            $result['membershipHistory'] = $result['membershipHistory']
                ->where($where)
                ->orderBy('membership_user_hst.create_dt', 'desc')
                ->select(DB::raw('membership_user_hst.*, product_membership.price as price, '
                    . 'recommand_user.user_seqno as recommand_user_seqno, recommand_user.user_name as recommand_user_name, recommand_user.user_phone as recommand_user_phone, '
                    . 'user_point.point as user_remain_point, '
                    . 'latest_reservation.last_start_dt as last_reservation_start_dt, '
                    . 'user_info.user_seqno as user_seqno, user_info.user_name as user_name, user_info.user_phone as user_phone, \'멤버쉽\' as point_type '))
                ->get();
        }
        if ((empty($service_type) || $service_type == 'V') && empty($reservation_memo) && empty($pucharse_memo)) {
            // 바우처 이력 조회 (바우처) 
            $where = [];
            if (!empty($start_dt) && $start_dt != '') {
                array_push($where, ['voucher_user_history.create_dt', '>=', $start_dt]);
            }
            if (!empty($end_dt) && $end_dt != '') {
                array_push($where, ['voucher_user_history.create_dt', '<=', $end_dt]);
            }
            if (!empty($hst_type) && $hst_type != '') {
                array_push($where, ['voucher_user_history.hst_type', '=', $hst_type]);
            }
            if (!empty($store_seqno) && $store_seqno != '') {
                array_push($where, ['product_voucher.store_seqno', '=', $store_seqno]);
            }
            if (!empty($user_name) && $user_name != '') {
                array_push($where, ['user_info.user_name', 'like', '%'.$user_name.'%']);
            }
            $result['voucherHistory'] = DB::table("voucher_user_history")
                ->join('voucher_user', 'voucher_user_history.voucher_user_seqno', '=', 'voucher_user.seqno')
                ->join('user_info', 'voucher_user.user_seqno', '=', 'user_info.user_seqno')
                ->leftJoin('product_voucher', 'voucher_user.voucher_seqno', '=', 'product_voucher.seqno')
                ->leftJoin('store_service', 'product_voucher.service_seqno', '=', 'store_service.seqno')
        //            ->leftJoin('partner', 'partner.seqno', '=', 'store_service.partner_seqno')
                ->leftJoin('store', 'store.seqno', '=', 'store_service.store_seqno')
        //            ->leftJoin('admin_info', 'user_point_hst.admin_seqno', '=', 'admin_info.admin_seqno')
                ->leftJoin('user_info as recommand_user', 'recommand_user.user_phone', '=', 'user_info.recommended_code')
                ->join('user_point', function ($join) {
                    $join->on('user_point.user_seqno', '=', 'user_info.user_seqno')
                        ->where('user_point.point_type', '=', 'P');
                })
                ->joinSub($latestReservation, 'latest_reservation', function ($join) {
                    $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno');
                })
            ;
            if (!empty($search_field) && $search_field != '') {
                $result['voucherHistory'] = $result['voucherHistory']
                    ->where(function($query) use ($search_field){
                        $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                            ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                    });
            }
            if (!empty($search_field_recommand) && $search_field_recommand != '') {
                $result['voucherHistory'] = $result['voucherHistory']
                    ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                    ->where(function($query) use ($search_field_recommand){
                        $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$search_field_recommand.'%')
                            ->orWhere('recommand_user_info.user_name', 'like', '%'.$search_field_recommand.'%');
                    });
            }
            $result['voucherHistory'] = $result['voucherHistory']
                ->where($where)
                ->orderBy('voucher_user_history.create_dt', 'desc')
                ->select(DB::raw('voucher_user_history.*, product_voucher.price as price, '
                    . 'recommand_user.user_seqno as recommand_user_seqno, recommand_user.user_name as recommand_user_name, recommand_user.user_phone as recommand_user_phone, '
                    . 'user_point.point as user_remain_point, '
                    . 'latest_reservation.last_start_dt as last_reservation_start_dt, '
                    . 'user_info.user_seqno as user_seqno, user_info.user_name as user_name, user_info.user_phone as user_phone, '
                    . 'product_voucher.name as service_name, product_voucher.price as service_price, \'바우처\' as point_type '))
                ->get();
        }
        /*
        if (empty($service_type) || $service_type != 'C') {
            // 쿠폰 이력 조회 (쿠폰)
            $where = [];
            if (!empty($start_dt) && $start_dt != '') {
                array_push($where, ['coupon_user_history.create_dt', '>=', $start_dt]);
            }
            if (!empty($end_dt) && $end_dt != '') {
                array_push($where, ['coupon_user_history.create_dt', '<=', $end_dt]);
            }
            if (!empty($hst_type) && $hst_type != '') {
                array_push($where, ['coupon_user_history.hst_type', '=', $hst_type]);
            }
            $result['couponHistory'] = DB::table("coupon_user_history")
                ->leftJoin('coupon_user', 'coupon_user_history.coupon_user_seqno', '=', 'coupon_user.seqno')
                ->leftJoin('user_info', 'coupon_user.user_seqno', '=', 'user_info.user_seqno')
                ->leftJoin('coupon', 'coupon_user.coupon_seqno', '=', 'coupon.seqno')
                ->where($where)
                ->orderBy('coupon_user_history.create_dt', 'desc')
                ->select(DB::raw('coupon_user_history.*, product_voucher.price as price, '
                    . 'user_info.user_seqno as user_seqno, user_info.user_name as user_name, user_info.user_phone as user_phone, '
                    . 'coupon.name as service_name, coupon_user.real_discount_price as real_discount_price, \'쿠폰\' as point_type '))
                ->get();
        }
        */

        if ((empty($service_type) || $service_type == 'R') && empty($pucharse_memo)) {
            // 예약 이력 조회
            $where = [];
            if (!empty($start_dt) && $start_dt != '') {
                array_push($where, ['reservation.start_dt', '>=', $start_dt]);
            }
            if (!empty($end_dt) && $end_dt != '') {
                array_push($where, ['reservation.start_dt', '<=', $end_dt]);
            }
            if (!empty($hst_type) && $hst_type != '') {
                if ($hst_type == 'RD') {
                    // 예약
                    array_push($where, ['reservation.status', '=', 'R']);
                } else if ($hst_type == 'RC') {
                    // 예약 취소
                    array_push($where, ['reservation.status', '=', 'C']);
                } else {
                    array_push($where, ['reservation.status', '=', 'M']);
                }
            }
            if (!empty($store_seqno) && $store_seqno != '') {
                array_push($where, ['reservation.store_seqno', '=', $store_seqno]);
            }
            if (!empty($user_name) && $user_name != '') {
                array_push($where, ['user_info.user_name', 'like', '%'.$user_name.'%']);
            }
            if (!empty($reservation_memo) && $reservation_memo != '') {
                array_push($where, ['reservation.memo', 'like', '%'.$reservation_memo.'%']);
            }
            $result['reservationHistory'] = DB::table("reservation")
                ->join('user_info', 'reservation.user_seqno', '=', 'user_info.user_seqno')
                ->leftJoin('store_service', 'reservation.service_seqno', '=', 'store_service.seqno')
    //            ->leftJoin('partner', 'partner.seqno', '=', 'store_service.partner_seqno')
                ->leftJoin('store', 'store.seqno', '=', 'store_service.store_seqno')
                ->leftJoin('admin_info', 'reservation.admin_seqno', '=', 'admin_info.admin_seqno')
                ->leftJoin('user_info as recommand_user', 'recommand_user.user_phone', '=', 'user_info.recommended_code')
                ->join('user_point', function ($join) {
                    $join->on('user_point.user_seqno', '=', 'user_info.user_seqno')
                        ->where('user_point.point_type', '=', 'P');
                })
                ->joinSub($latestReservation, 'latest_reservation', function ($join) {
                    $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno');
                })
            ;
            if (!empty($search_field) && $search_field != '') {
                $result['reservationHistory'] = $result['reservationHistory']
                    ->where(function($query) use ($search_field){
                        $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                            ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                    });
            }
            if (!empty($search_field_recommand) && $search_field_recommand != '') {
                $result['reservationHistory'] = $result['reservationHistory']
                    ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                    ->where(function($query) use ($search_field_recommand){
                        $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$search_field_recommand.'%')
                            ->orWhere('recommand_user_info.user_name', 'like', '%'.$search_field_recommand.'%');
                    });
            }
            $result['reservationHistory'] = $result['reservationHistory']
                ->where($where)
                ->whereIn('reservation.status', ['R', 'C'])
                ->orderBy('reservation.start_dt', 'desc')
                ->select(DB::raw('reservation.*, '
                    . 'recommand_user.user_seqno as recommand_user_seqno, recommand_user.user_name as recommand_user_name, recommand_user.user_phone as recommand_user_phone, '
                    . 'user_point.point as user_remain_point, '
                    . 'latest_reservation.last_start_dt as last_reservation_start_dt, '
                    . 'user_info.user_seqno as user_seqno, user_info.user_name as user_name, user_info.user_phone as user_phone, '
                    . 'store.name as store_name, store_service.name as service_name, store_service.estimated_time as estimated_time, store_service.price as price, '
                    . 'admin_info.admin_name as admin_name, '
                    . '\'예약\' as point_type, (if( reservation.status = \'R\', \'예약\', \'예약취소\' )) as hst_type'))
                ->get();
        }

        $result['ment'] = '정상 조회 되었습니다.';
        $result['result'] = true;

        return $result;
    }
}
