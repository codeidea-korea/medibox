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
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
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
            array_push($where, ['start_dt', '<=', $end_dt]);
        }
        if(! empty($type) && $type != ''){
            array_push($where, ['type', '=', $type]);
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
        $allowed_issuance_type = 'A';

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('coupon')->insertGetId(
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
}
