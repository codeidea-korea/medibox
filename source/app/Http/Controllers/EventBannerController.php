<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class EventBannerController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $event_search_type = $request->get('event_search_type', 'name');
        $search_field1 = $request->get('search_field1');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');
        $lend_dt = $request->get('lend_dt');
        $status = $request->get('status');
        $used_coupon = $request->get('used_coupon');
        
        $partner_seqno = $request->get('partner_seqno');
        $coupon_search_type = $request->get('coupon_search_type', 'name');
        $search_field2 = $request->get('search_field2');
        $coupon_start_dt = $request->get('coupon_start_dt');
        $coupon_end_dt = $request->get('coupon_end_dt');
        $type = $request->get('type');
        $include_discontinued = $request->get('include_discontinued', 'N');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(empty($include_discontinued) || $include_discontinued == 'N') {
            array_push($where, ['even_banner.deleted', '=', 'N']);
        }
        if(! empty($search_field1) && $search_field1 != ''){
            if($event_search_type == 'name') {
                array_push($where, ['even_banner.name', 'like', '%'.$search_field1.'%']);
            } else if($event_search_type == 'context') {
                array_push($where, ['even_banner.context', 'like', '%'.$search_field1.'%']);
            }
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($where, ['even_banner.start_dt', '>=', $start_dt]);
        }
        if(! empty($end_dt) && $end_dt != ''){
            array_push($where, ['even_banner.start_dt', '<=', $end_dt]);
        }
        if(! empty($lend_dt) && $lend_dt != ''){
            array_push($where, ['even_banner.end_dt', '>', $lend_dt]);
        }
        if(! empty($status) && $status != ''){
            array_push($where, ['status', '=', $status]);
        }
        if(! empty($used_coupon) && $used_coupon != ''){
            array_push($where, ['used_coupon', '=', $used_coupon]);
        }

        $whereCoupon = [];
        $useCouponCause = false;
        array_push($whereCoupon, ['coupon.deleted', '=', 'N']);
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($whereCoupon, ['coupon_partner_grp_seqno', 'like', '%|'.$partner_seqno.'|%']);
            $useCouponCause = true;
        }
        if(! empty($search_field2) && $search_field2 != ''){
            if($coupon_search_type == 'name') {
                array_push($where, ['coupon.name', 'like', '%'.$search_field2.'%']);
                array_push($whereCoupon, ['coupon.name', 'like', '%'.$search_field2.'%']);
                $useCouponCause = true;
            } else if($coupon_search_type == 'seqno') {
                array_push($where, ['coupon.seqno', '=', $search_field2]);
                array_push($whereCoupon, ['coupon.seqno', '=', $search_field2]);
                $useCouponCause = true;
            }
        }
        if(! empty($coupon_start_dt) && $coupon_start_dt != ''){
            array_push($whereCoupon, ['coupon.start_dt', '>=', $coupon_start_dt]);
            $useCouponCause = true;
        }
        if(! empty($coupon_end_dt) && $coupon_end_dt != ''){
            array_push($whereCoupon, ['coupon.start_dt', '<=', $coupon_end_dt]);
            $useCouponCause = true;
        }
        if(! empty($type) && $type != ''){
            array_push($whereCoupon, ['coupon.type', '=', $type]);
            $useCouponCause = true;
        }
        
        $contents = DB::table("even_banner")->where($where);
        $count = DB::table("even_banner")->where($where);

        if($useCouponCause) {
            // 쿠폰 조회 조건
            $contents = $contents
                ->join('coupon', function ($join) use ($whereCoupon) {
                    $join->on('even_banner.event_coupon_seqno', '=', 'coupon.seqno')
                        ->where($whereCoupon);
                })
                ->select(DB::raw('even_banner.*, coupon.name as coupon_name, coupon.context as coupon_context,'
                                .'coupon.coupon_partner_grp_seqno as coupon_partner_grp_seqno, coupon.start_dt as coupon_start_dt,'
                                .'coupon.end_dt as coupon_end_dt, type, discount_price, max_discount_price, limit_base_price, allowed_issuance_type'));
            
            $count = $count
                ->join('coupon', function ($join) use ($whereCoupon) {
                    $join->on('even_banner.event_coupon_seqno', '=', 'coupon.seqno')
                        ->where($whereCoupon);
                });
        } else {
            $contents = $contents
                ->leftJoin('coupon', 'even_banner.event_coupon_seqno', '=', 'coupon.seqno')
                ->select(DB::raw('even_banner.*, coupon.name as coupon_name, coupon.context as coupon_context,'
                                .'coupon.coupon_partner_grp_seqno as coupon_partner_grp_seqno, coupon.start_dt as coupon_start_dt,'
                                .'coupon.end_dt as coupon_end_dt, type, discount_price, max_discount_price, limit_base_price, allowed_issuance_type'));
        }
        $contents = $contents
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = $count
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

        $contents = DB::table("even_banner")->where([
            ['seqno', '=', $id]
        ])->first();

        $coupon = DB::table('coupon')->where([
            ['seqno', '=', $contents->event_coupon_seqno]
        ])->first();

        $contents->coupon = $coupon;

        if(!empty($contents->coupon)) {
            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $contents->coupon->coupon_partner_grp_seqno)));
            $partners = DB::table("partner")
//                ->where([['deleted', '=', 'N']])
                ->whereIn('seqno', $partnerNos)
                ->get();
            $contents->partners = $partners;
        }

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
        $thumbnail = $request->post('thumbnail');
        $img = $request->post('img');
        $start_dt = $request->post('start_dt');
        $end_dt = $request->post('end_dt');
        $used_coupon = $request->post('used_coupon', 'N');

        $coupon_partner_grp_seqno = $request->post('coupon_partner_grp_seqno', 0);
        $coupon_name = $request->post('coupon_name');
        $coupon_context = $request->post('coupon_context');
        $coupon_start_dt = $request->post('coupon_start_dt');
        $coupon_end_dt = $request->post('coupon_end_dt');
        $coupon_type = $request->post('coupon_type', 'F');
        $coupon_discount_price = $request->post('coupon_discount_price');
        $coupon_max_discount_price = $request->post('coupon_max_discount_price');
        $coupon_limit_base_price = $request->post('coupon_limit_base_price');
        $allowed_issuance_type = 'A';

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $coupon_seqno = 0;
        if(!empty($used_coupon) && $used_coupon == 'Y') {
            // 쿠폰 생성
            $coupon_seqno = DB::table('coupon')->insertGetId(
                [
                    'coupon_partner_grp_seqno' => $coupon_partner_grp_seqno
                    , 'name' => $coupon_name
                    , 'context' => $coupon_context
                    , 'issuance_type' => 'A'
                    , 'start_dt' => $coupon_start_dt
                    , 'end_dt' => $coupon_end_dt
                    , 'type' => $coupon_type
                    , 'issuance_condition_type' => 'A'
                    , 'discount_price' => $coupon_discount_price
                    , 'max_discount_price' => $coupon_max_discount_price
                    , 'limit_base_price' => $coupon_limit_base_price
                    , 'allowed_issuance_type' => $allowed_issuance_type
                    , 'date_use' => 0
                    , 'deleted' => 'N'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'seqno'
            );
        }

        $banner_seqno = DB::table('even_banner')->insertGetId(
            [
                'name' => $name
                , 'context' => $context
                , 'thumbnail' => $thumbnail
                , 'img' => $img
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'used_coupon' => $used_coupon
                , 'event_coupon_seqno' => $coupon_seqno
                , 'status' => 'A'
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
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
        $thumbnail = $request->post('thumbnail');
        $img = $request->post('img');
        $start_dt = $request->post('start_dt');
        $end_dt = $request->post('end_dt');
        $used_coupon = $request->post('used_coupon', 'N');

        $coupon_partner_grp_seqno = $request->post('coupon_partner_grp_seqno', 0);
        $coupon_name = $request->post('coupon_name');
        $coupon_context = $request->post('coupon_context');
        $coupon_start_dt = $request->post('coupon_start_dt');
        $coupon_end_dt = $request->post('coupon_end_dt');
        $coupon_type = $request->post('coupon_type', 'F');
        $coupon_discount_price = $request->post('coupon_discount_price', 0);
        $coupon_max_discount_price = $request->post('coupon_max_discount_price', 0);
        $coupon_limit_base_price = $request->post('coupon_limit_base_price', 0);
        $deleted = $request->post('deleted', 'N');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $event_banner = DB::table('even_banner')->where('seqno', '=', $id)->first();
        $event_coupon = DB::table('coupon')->where([
            ['seqno', '=', $event_banner->event_coupon_seqno],
            ['deleted', '=', 'N']
        ])->first();

        $coupon_seqno = 0;
        if(empty($event_coupon) && $used_coupon == 'Y') {
            // 쿠폰 생성
            $coupon_seqno = DB::table('coupon')->insertGetId(
                [
                    'coupon_partner_grp_seqno' => $coupon_partner_grp_seqno
                    , 'name' => $coupon_name
                    , 'context' => $coupon_context
                    , 'issuance_type' => 'A'
                    , 'issuance_condition_type' => 'A'
                    , 'start_dt' => $coupon_start_dt
                    , 'end_dt' => $coupon_end_dt
                    , 'type' => $coupon_type
                    , 'discount_price' => $coupon_discount_price
                    , 'max_discount_price' => $coupon_max_discount_price
                    , 'limit_base_price' => $coupon_limit_base_price
                    , 'allowed_issuance_type' => 'A'
                    , 'date_use' => 0
                    , 'deleted' => $deleted
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'seqno'
            );
        } else if(!empty($event_coupon) && $used_coupon == 'Y') {
            // 쿠폰 수정
            DB::table('coupon')->where('seqno', '=', $event_coupon->seqno)->update(
                [
                    'coupon_partner_grp_seqno' => $coupon_partner_grp_seqno
                    , 'name' => $coupon_name
                    , 'context' => $coupon_context
                    , 'start_dt' => $coupon_start_dt
                    , 'end_dt' => $coupon_end_dt
                    , 'type' => $coupon_type
                    , 'discount_price' => $coupon_discount_price
                    , 'max_discount_price' => $coupon_max_discount_price
                    , 'limit_base_price' => $coupon_limit_base_price
                    , 'deleted' => $deleted
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
            $coupon_seqno = $event_coupon->seqno;
        } else if(!empty($event_coupon) && $used_coupon == 'N') {
            // 쿠폰 삭제
            DB::table('coupon')->where('seqno', '=', $event_coupon->seqno)->update(
                [
                    'deleted' => 'Y', 
                    'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        DB::table('even_banner')->where('seqno', '=', $id)->update(
            [
                'name' => $name
                , 'context' => $context
                , 'thumbnail' => $thumbnail
                , 'img' => $img
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'used_coupon' => $used_coupon
                , 'event_coupon_seqno' => $coupon_seqno
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

        DB::table('even_banner')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        // 이벤트 배너는 삭제 되더라도 기 발급 쿠폰, 이미 비노출된 쿠폰정보는 삭제되지 않는다.

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function join(Request $request, $id)
    {
        $user_seqno = $request->post('user_seqno');

        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        $user_info = DB::table('user_info')->where([
            ['user_seqno', '=', $id],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user_info)) {
            $result['ment'] = '로그인을 해주세요.';
            return $result;
        }

        $event_banner = DB::table('even_banner')->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        if(empty($event_banner)) {
            $result['ment'] = '존재하지 않는 이벤트 입니다.';
            return $result;
        }
        if($event_banner->status == 'C') {
            $result['ment'] = '중지된 이벤트 입니다.';
            return $result;
        }
        if($event_banner->status == 'E') {
            $result['ment'] = '종료된 이벤트 입니다.';
            return $result;
        }
        if(strtotime($event_banner->end_dt) < strtotime(date("Y-m-d H:i:s"))) {
            $result['ment'] = '이벤트 기간이 아닙니다.';
            return $result;
        }
        // 이벤트 배너는 삭제 되더라도 기 발급 쿠폰, 이미 비노출된 쿠폰정보는 삭제되지 않는다.
        DB::table('even_banner_user')->insertGetId(
            [
                'even_banner_seqno' => $event_banner->seqno
                , 'user_seqno' => $user_seqno
                , 'used' => 'N'
                , 'real_start_dt' => date("Y-m-d H:i:s")
                , 'real_end_dt' => $event_banner->end_dt
                , 'real_discount_price' => 0
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modifyStatus(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');
        $status = $request->post('status', 'A');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('even_banner')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'status' => $status
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
}
