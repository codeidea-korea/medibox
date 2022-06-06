<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $name = $request->get('name');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        
        $contents = DB::table("product_voucher")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("product_voucher")->where($where)
            ->count();

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

        $contents = DB::table("product_voucher")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $name = $request->post('name');
        
        $context = $request->post('context');
        $unit_count = $request->post('unit_count', 0);
        $date_use = $request->post('date_use', 0);
        $use_partner = $request->post('use_partner', 'N');
        $partner_seqno = $request->post('partner_seqno');
        $store_seqno = $request->post('store_seqno');
        $service_seqno = $request->post('service_seqno');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        if($use_partner == 'Y') {
            if(empty($partner_seqno) || empty($store_seqno) || empty($service_seqno)) {
                $result['ment'] = '제휴사 서비스 연결을 선택하시면 바우처의 제휴사, 매장, 서비스를 연결해주셔야 합니다.';
                return $result;
            }
        }

        $id = DB::table('product_voucher')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'context' => $context
                , 'unit_count' => $unit_count
                , 'date_use' => $date_use
                , 'use_partner' => $use_partner
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'service_seqno' => $service_seqno
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modify(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');
        $name = $request->post('name');
        
        $context = $request->post('context');
        $unit_count = $request->post('unit_count', 0);
        $date_use = $request->post('date_use', 0);
        $use_partner = $request->post('use_partner', 'N');
        $partner_seqno = $request->post('partner_seqno');
        $store_seqno = $request->post('store_seqno');
        $service_seqno = $request->post('service_seqno');

        if($use_partner == 'Y') {
            if(empty($partner_seqno) || empty($store_seqno) || empty($service_seqno)) {
                $result['ment'] = '제휴사 서비스 연결을 선택하시면 바우처의 제휴사, 매장, 서비스를 연결해주셔야 합니다.';
                return $result;
            }
        }

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('product_voucher')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'context' => $context
                , 'unit_count' => $unit_count
                , 'date_use' => $date_use
                , 'use_partner' => $use_partner
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'service_seqno' => $service_seqno
                , 'update_dt' => date('Y-m-d H:i:s') 
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
        $result['ment'] = '바우처가 승인되지 않았습니다.';
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
            $result['ment'] = '바우처가 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("voucher_user")->where([
            ['seqno', '=', $hst_seqno],
            ['used', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '바우처가 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
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

    
    public function cancel(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno', 0); // 담당자 - 없이 고객도 취소 가능
        $admin_name = $request->post('admin_name', ''); // 담당자 - 없이 고객도 취소 가능
        $user_seqno = $request->post('user_seqno'); // 대상 고객

        $hst_type = $request->post('hst_type', 'U'); // 사용 구분
        $hst_seqno = $request->post('hst_seqno'); // 대상 히스토리 번호

        $result = [];
        $result['ment'] = '바우처가 취소되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
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
            $result['ment'] = '바우처가 취소되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("voucher_user")->where([
            ['seqno', '=', $hst_seqno],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '바우처가 취소되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '바우처가 취소되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        DB::table('voucher_user')->where([
            ['seqno', '=', $hst_seqno]
        ])->update(
            [
                'canceled' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('voucher_user_history')->insertGetId(
            [
                'voucher_user_seqno' => $hst_seqno,
                'hst_type' => '',
                'canceled' => 'Y',
                'approved' => 'N',
                'memo' => '[바우처] 사용 취소',
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
        $result['ment'] = '바우처가 승인되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
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
            $result['ment'] = '바우처가 승인되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            $result['code'] = 'USER-NULL';
            return $result;
        }
        $history = DB::table("voucher_user")->where([
            ['seqno', '=', $hst_seqno],
            ['approved', '=', 'N'],
            ['canceled', '=', 'N']
        ])->first();
        if(empty($history)) {
            $result['ment'] = '바우처가 승인되지 않았습니다.\r없는 사용 정보이거나 이미 취소된 정보입니다.';
            $result['code'] = 'HISTORY-NULL';
            return $result;
        }
        if($history->user_seqno != $user_seqno) {
            $result['ment'] = '바우처가 승인되지 않았습니다.\r수정할 고객정보와 이력의 고객정보가 상이합니다.';
            $result['code'] = 'HISTORY-UNMATCHED';
            return $result;
        }
        DB::table('voucher_user')->where([
            ['seqno', '=', $hst_seqno]
        ])->update(
            [
                'approved' => 'Y', 
                'used' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('voucher_user_history')->insertGetId(
            [
                'voucher_user_seqno' => $hst_seqno,
                'hst_type' => '',
                'canceled' => 'N',
                'approved' => 'Y',
                'memo' => '[바우처] 사용 승인',
                'create_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '사용되었습니다.';
        $result['data'] = $user;
        $result['code'] = 'S';
        $result['result'] = true;

        return $result;
    }

    public function remove(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        DB::table('product_voucher')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
}
