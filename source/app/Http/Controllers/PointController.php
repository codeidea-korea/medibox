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
        
        $user_phone = $request->get('id');
        $user_name = $request->get('name');

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
            array_push($whereUser, ['user_info.user_phone', '=', $user_phone]);
        }
        if(! empty($user_name) && $user_name != ''){
            array_push($whereUser, ['user_info.user_name', '=', $user_name]);
        }

        $contents = DB::table("user_point_hst")
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                     ->where($whereUser);
            })
            ->leftJoin('product', 'user_point_hst.product_seqno', '=', 'product.product_seqno')
            ->where($where)
            ->orderBy('user_point_hst.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("user_point_hst")->where($where)
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('user_point_hst.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            })
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

    // 포인트 적립
    public function collect(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno', 0); // 대상 상품 식별번호 (포인트는 0번)
        $point_type = $request->post('point_type'); // 적립 구분 (포인트는 P)
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
        $memo = $request->post('memo', '');

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
                        , 'memo' => '추천인 자동 적립 (최초 추천을 한 회원)'
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
                    ['point_type', '=', 'P'],
                    ['delete_yn', '=', 'N']
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
                        , 'memo' => '추천인 자동 적립 (최초 추천을 받은 회원)'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ], 'user_point_hst_seqno'
                );
                DB::table('user_point')->where([
                    ['user_seqno', '=', $recommender->user_seqno],
                    ['point_type', '=', 'P'],
                    ['delete_yn', '=', 'N']
                ])->update(
                    [
                        'point' => $prevPoint->point + $etcPoint
                        , 'update_dt' => date('Y-m-d H:i:s') 
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
                $result['ment'] = '포인트가 환불되지 않았습니다.\r패키지 포인트 적립후 사용한 내역이 있습니다.';
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
        $point_type = $request->post('point_type'); // 사용 구분
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 사용되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['code'] = 'USER-INPUT';
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
            $result['ment'] = '포인트가 사용되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $product = DB::table("product")->where([
            ['product_seqno', '=', $product_seqno]
        ])->first();
        if(empty($product)) {
            $result['code'] = 'SERVICE-NULL';
            return $result;
        }
        $amount = $product->price;
        // 내 포인트에 차감 처리
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

        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => $point_type
                , 'product_seqno' => $product_seqno
                , 'hst_type' => 'U'
                , 'point' => $amount
                , 'memo' => $memo
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
            ->select('service_name')
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
}
