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
    // 나의 포인트 조회 - 일반 고객
    public function myPoint(Request $request)
    {
        $user_seqno = $request->post('user_seqno'); // 대상 고객

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

        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno]
        ])->get();

        $result['ment'] = '성공';
        $result['data'] = $point;
        $result['result'] = true;

        return $result;
    }
    // 나의 결제 내역 (포인트/정액권/ 전체)
    public function myPayments(Request $request)
    {
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $hst_type = $request->post('hst_type', ''); // U: 사용, R: 환불, S: 충전, !U: 사용이 아닌것
        $point_type = $request->post('point_type', '');
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
        if(! empty($point_type) && $point_type != ''){
            array_push($where, ['point_type', '=', $point_type]);
        }

        $points;
        if(! empty($hst_type) && $hst_type == '!U'){
            $points = DB::table('user_point_hst')->where($where)
                ->orWhere(function($query) {
                    $query->where('hst_type', 'R')
                        ->where('hst_type', 'S');
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
        $admin_seqno = $request->post('admin_seqno'); // 담당자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno', 0); // 대상 상품 식별번호 (포인트는 0번)
        $point_type = $request->post('point_type'); // 적립 구분 (포인트는 P)
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 적립되지 않았습니다.\n정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            return $result;
        }

        if($product_seqno != 0 && $point_type != 'P') {
            $product = DB::table("product")->where([
                ['product_seqno', '=', $product_seqno],
                ['point_type', '=', $point_type]
            ])->first();

            if(empty($product)) {
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
        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
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
            ['point_type', '=', $point_type]
        ])->first();

        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', $point_type]
        ])->update(
            [
                'point' => $point->point + $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\n['.$amount.'] point가 적립되었습니다.';
        $result['data'] = $users;
        $result['result'] = true;

        return $result;
    }
    // 포인트 환불
    public function refund(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno', 0); // 대상 상품 식별번호 (포인트는 0번)
        $point_type = $request->post('point_type'); // 적립 구분 (포인트는 P)
        $amount = $request->post('amount'); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 환불되지 않았습니다.\n정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            return $result;
        }

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
                ['refund_point_hst_seqno', 'is', null]
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
        // 내 포인트에 증가 처리
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', $point_type]
        ])->first();

        // 히스토리에 포인트 이력 추가
        $refund_point_hst_seqno = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
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
            ['point_type', '=', $point_type]
        ])->update(
            [
                'point' => $point->point + $amount
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\n['.$amount.'] point가 환불되었습니다.';
        $result['data'] = $users;
        $result['result'] = true;

        return $result;
    }
    // 포인트 사용
    public function use(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 구매 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $product_seqno = $request->post('product_seqno'); // 대상 상품 식별번호
        $point_type = $request->post('point_type'); // 사용 구분
        $memo = $request->post('memo', '');

        $result = [];
        $result['ment'] = '포인트가 사용되지 않았습니다.\n정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($point_type)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            return $result;
        }
        $product = DB::table("product")->where([
            ['product_seqno', '=', $product_seqno]
        ])->first();
        if(empty($product)) {
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
            return $result;
        }

        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'point_type' => $point_type
                , 'product_seqno' => $product_seqno
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

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\n['.$amount.'] point가 사용되었습니다.';
        $result['data'] = $users;
        $result['result'] = true;

        return $result;
    }
}
