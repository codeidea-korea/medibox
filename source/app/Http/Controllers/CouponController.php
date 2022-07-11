<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    // 쿠폰
    /*
    쿠폰 상태 변경 (발급 중지, 발급 종료, 발급재개)
    */
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $partner_seqno = $request->get('partner_seqno');

        $coupon_search_type = $request->get('coupon_search_type', 'name');
        $search_field1 = $request->get('search_field1');
        $name = $request->get('name');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');
        $type = $request->get('type');
        $include_discontinued = $request->get('include_discontinued', 'N');
        $issuance_condition_type = $request->get('issuance_condition_type', '');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(empty($include_discontinued) || $include_discontinued == 'N') {
            array_push($where, ['deleted', '=', 'N']);
        }
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['coupon_partner_grp_seqno', 'like', '%|'.$partner_seqno.'|%']);
        }
        if(! empty($search_field1) && $search_field1 != ''){
            if($coupon_search_type == 'name') {
                array_push($where, ['name', 'like', '%'.$search_field1.'%']);
            } else if($coupon_search_type == 'seqno') {
                array_push($where, ['seqno', '=', $search_field1]);
            }
        }
        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($where, ['start_dt', '>=', $start_dt]);
        }
        if(! empty($end_dt) && $end_dt != ''){
            array_push($where, ['start_dt', '<=', $end_dt]);
        }
        if(! empty($type) && $type != ''){
            array_push($where, ['type', '=', $type]);
        }
        if(! empty($issuance_condition_type) && $issuance_condition_type != ''){
            array_push($where, ['issuance_condition_type', '=', $issuance_condition_type]);
        }
        
        $contents = DB::table("coupon")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("coupon")->where($where)
            ->count();

        for($inx = 0; $inx < count($contents); $inx++){

            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $contents[$inx]->coupon_partner_grp_seqno)));

            $partners = DB::table("partner")
                ->where([['deleted', '=', 'N']])
                ->whereIn('seqno', $partnerNos)
                ->get();
                
            $contents[$inx]->partners = $partners;
        }

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function find(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $contents = DB::table("coupon")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $contents->coupon_partner_grp_seqno)));
        $partners = DB::table("partner")
            ->where([['deleted', '=', 'N']])
            ->whereIn('seqno', $partnerNos)
            ->get();
        $contents->partners = $partners;

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $coupon_partner_grp_seqno = $request->post('coupon_partner_grp_seqno', 0);

        $name = $request->post('name');
        $context = $request->post('context');
        $issuance_type = $request->post('issuance_type', 'A');
        $issuance_condition_type = $request->post('issuance_condition_type', 'A');
        $start_dt = $request->post('start_dt');
        $end_dt = $request->post('end_dt');
        $type = $request->post('type', 'F');
        $discount_price = $request->post('discount_price');
        $max_discount_price = $request->post('max_discount_price');
        $limit_base_price = $request->post('limit_base_price');
        $date_use = $request->post('date_use');
        $allowed_issuance_type = 'A';

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $seqno = DB::table('coupon')->insertGetId(
            [
                'coupon_partner_grp_seqno' => $coupon_partner_grp_seqno
                , 'name' => $name
                , 'context' => $context
                , 'issuance_type' => $issuance_type
                , 'issuance_condition_type' => $issuance_condition_type
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'type' => $type
                , 'discount_price' => $discount_price
                , 'max_discount_price' => $max_discount_price
                , 'limit_base_price' => $limit_base_price
                , 'allowed_issuance_type' => $allowed_issuance_type
                , 'date_use' => $date_use
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
        );

        // 전체 발급 전부 지급
        if($issuance_condition_type == 'A' && $allowed_issuance_type == 'A') {

            $users = DB::table("user_info")->where([
                ['delete_yn', '=', 'N']
            ])->get();

            for($inx = 0; $inx < count($users); $inx++){
                $mpg_seqno = DB::table('coupon_user')->insertGetId(
                    [
                        'coupon_seqno' => $seqno,
                        'user_seqno' => $users[$inx]->user_seqno,
                        'used' => 'N',
                        'real_start_dt' => $start_dt,
                        'real_end_dt' => $end_dt,
                        'real_discount_price' => 0,
                        'deleted' => 'N',
                        'hst_type' => 'S'
                    ], 'seqno'
                );
                DB::table('coupon_user_history')->insertGetId(
                    [
                        'coupon_user_seqno' => $mpg_seqno,
                        'hst_type' => 'S',
                        'canceled' => 'N',
                        'approved' => 'N',
                        'memo' => '[쿠폰] 자동 지급',
                        'create_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modify(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');
        $coupon_partner_grp_seqno = $request->post('coupon_partner_grp_seqno', 0);

        $name = $request->post('name');
        $context = $request->post('context');
        $issuance_type = $request->post('issuance_type', 'A');
        $issuance_condition_type = $request->post('issuance_condition_type', 'A');
        $start_dt = $request->post('start_dt');
        $end_dt = $request->post('end_dt');
        $type = $request->post('type', 'F');
        $discount_price = $request->post('discount_price');
        $max_discount_price = $request->post('max_discount_price');
        $limit_base_price = $request->post('limit_base_price');
        $deleted = $request->post('deleted', 'N');
        $date_use = $request->post('date_use');
        $allowed_issuance_type = 'A';

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('coupon')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'coupon_partner_grp_seqno' => $coupon_partner_grp_seqno
                , 'name' => $name
                , 'context' => $context
                , 'issuance_type' => $issuance_type
                , 'issuance_condition_type' => $issuance_condition_type
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'type' => $type
                , 'discount_price' => $discount_price
                , 'max_discount_price' => $max_discount_price
                , 'limit_base_price' => $limit_base_price
                , 'allowed_issuance_type' => $allowed_issuance_type
                , 'date_use' => $date_use
                , 'deleted' => $deleted
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function remove(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        DB::table('coupon')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
    // 사용 승인 확인
    public function checkApproved(Request $request)
    {
        $user_seqno = $request->get('user_seqno'); // 대상 고객
        $hst_seqno = $request->get('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '쿠폰이 승인되지 않았습니다.';
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
            $result['ment'] = '쿠폰이 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("coupon_user")->where([
            ['seqno', '=', $hst_seqno],
            ['used', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '쿠폰이 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
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

    public function modifyStatus(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');
        $allowed_issuance_type = $request->post('allowed_issuance_type', 'A');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('coupon')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'allowed_issuance_type' => $allowed_issuance_type
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    
    public function cancel(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 취소 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 취소 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $hst_type = $request->post('hst_type', 'U'); // 사용 구분
        $hst_seqno = $request->post('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '쿠폰이 취소되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
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
            $result['ment'] = '쿠폰이 취소되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("coupon_user")->where([
            ['seqno', '=', $hst_seqno],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '쿠폰이 취소되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '쿠폰이 취소되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        DB::table('coupon_user')->where([
            ['seqno', '=', $hst_seqno]
        ])->update(
            [
                'canceled' => 'Y', 
                'approved' => 'N',
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('coupon_user_history')->insertGetId(
            [
                'coupon_user_seqno' => $hst_seqno,
                'hst_type' => '',
                'canceled' => 'Y',
                'approved' => 'N',
                'memo' => '[쿠폰] 사용 취소',
                'create_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '취소되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
    public function approve(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 취소 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 취소 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $hst_seqno = $request->post('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '쿠폰이 승인되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
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
            $result['ment'] = '쿠폰이 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("coupon_user")->where([
            ['seqno', '=', $hst_seqno],
            ['approved', '=', 'N'],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '쿠폰이 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '쿠폰이 승인되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        DB::table('coupon_user')->where([
            ['seqno', '=', $hst_seqno]
        ])->update(
            [
                'approved' => 'Y', 
                'canceled' => 'N',
                'used' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('coupon_user_history')->insertGetId(
            [
                'coupon_user_seqno' => $hst_seqno,
                'hst_type' => '',
                'canceled' => 'N',
                'approved' => 'Y',
                'memo' => '[쿠폰] 사용 승인',
                'create_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '사용되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }
}
