<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class CouponUsedController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $partner_seqno = $request->get('partner_seqno');
        $user_seqno = $request->get('user_seqno');

        $coupon_search_type = $request->get('coupon_search_type', 'name');
        $search_field1 = $request->get('search_field1');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');

        $type = $request->get('type');

        $user_search_type = $request->get('user_search_type', 'id');
        $search_field2 = $request->get('search_field2');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['coupon_user.deleted', '=', 'N']);
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['coupon_partner_grp_seqno', 'like', '%|'.$partner_seqno.'|%']);
        }

        $whereCoupon = [];
        if(! empty($search_field1) && $search_field1 != ''){
            if($coupon_search_type == 'name') {
                array_push($whereCoupon, ['name', 'like', '%'.$search_field1.'%']);
            } else if($coupon_search_type == 'seqno') {
                array_push($whereCoupon, ['seqno', '=', $search_field1]);
            }
        }
        if(! empty($start_dt) && $start_dt != ''){
            // NOTICE: 시작일 기준 검색이라고 기획서 71페이지 4번에 나와 있음
            array_push($whereCoupon, ['start_dt', '>=', $start_dt]);
        }
        if(! empty($end_dt) && $end_dt != ''){
            // NOTICE: 시작일 기준 검색이라고 기획서 71페이지 4번에 나와 있음
            array_push($whereCoupon, ['start_dt', '<=', $end_dt]);
        }
        if(! empty($type) && $type != ''){
            array_push($whereCoupon, ['type', '=', $type]);
        }

        $whereUser = [];
        if(! empty($search_field2) && $search_field2 != ''){
            if($user_search_type == 'id') {
                array_push($whereUser, ['user_phone', 'like', '%'.$search_field2.'%']);
            } else if($user_search_type == 'name') {
                array_push($whereUser, ['user_name', 'like', '%'.$search_field2.'%']);
            }
        }
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($whereUser, ['user_info.user_seqno', '=', $user_seqno]);
        }
        
        
        $contents = DB::table("coupon_user")->where($where)
        /*
            ->join('partner', function ($join) use ($wherePartner) {
                $join->on('coupon_user.partner_seqno', '=', 'partner.partner_seqno')
                    ->where($wherePartner);
            })
            */
            ->join('coupon', function ($join) use ($whereCoupon) {
                $join->on('coupon_user.coupon_seqno', '=', 'coupon.seqno')
                     ->where($whereCoupon);
            })
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('coupon_user.user_seqno', '=', 'user_info.user_seqno')
                     ->where($whereUser);
            })
            ->orderBy('coupon_user.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("coupon_user")->where($where)
        /*
            ->join('partner', function ($join) use ($wherePartner) {
                $join->on('coupon_user.partner_seqno', '=', 'partner.partner_seqno')
                    ->where($wherePartner);
            })
            */
            ->join('coupon', function ($join) use ($whereCoupon) {
                $join->on('coupon_user.coupon_seqno', '=', 'coupon.seqno')
                    ->where($whereCoupon);
            })
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('coupon_user.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            })
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

        $contents = DB::table("coupon_user")->where([
            ['product_seqno', '=', $id],
            ['coupon_user.deleted', '=', 'N']
        ])
        ->join('coupon', function ($join) {
            $join->on('coupon_user.coupon_seqno', '=', 'coupon.seqno');
        })
        ->join('user_info', function ($join) {
            $join->on('coupon_user.user_seqno', '=', 'user_info.user_seqno');
        })->first();

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

    // 나의 미사용 쿠폰
    public function myEnabledCoupons(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $partner_seqno = $request->get('partner_seqno', 0);
        $user_seqno = $request->get('user_seqno');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $thisTime = date("Y-m-d h:i:s", time());

        $where = [];
        array_push($where, ['coupon_user.deleted', '=', 'N']);
        array_push($where, ['coupon_user.used', '=', 'N']);
        array_push($where, ['coupon_user.real_start_dt', '<=', $thisTime]);
        array_push($where, ['coupon_user.real_end_dt', '>=', $thisTime]);

        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['coupon_user.user_seqno', '=', $user_seqno]);
        }

        $whereCoupon = [];
        array_push($whereCoupon, ['type', '!=', 'G']);
        if(! empty($partner_seqno) && $partner_seqno != '' && $partner_seqno != 0){
            array_push($whereCoupon, ['coupon_partner_grp_seqno', 'like', '%|'.$partner_seqno.'|%']);
        }
        
        $contents = DB::table("coupon_user")
            ->join('coupon', 'coupon_user.coupon_seqno', '=', 'coupon.seqno')
            ->orWhere(function($query) use ($where, $whereCoupon) {
                $query
                    ->where($where)
                    ->where($whereCoupon);
            })
            ->orWhere(function($query) use ($where) {
                $query
                    ->where($where)
                    ->where([['coupon_partner_grp_seqno', 'like', '%|0|%']]);
            })
            ->orWhere(function($query) use ($where) {
                $query
                    ->where($where)
                    ->where([['coupon_partner_grp_seqno', '=', '0']]);
            })
            ->select('coupon_user.*', 'coupon.type', 'coupon.name', 'coupon.discount_price', 'coupon.max_discount_price', 'coupon.limit_base_price')
            ->orderBy('coupon_user.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->distinct()
            ->get();

        $count = DB::table("coupon_user")
            ->join('coupon', 'coupon_user.coupon_seqno', '=', 'coupon.seqno')
            ->orWhere(function($query) use ($where, $whereCoupon) {
                $query
                    ->where($where)
                    ->where($whereCoupon);
            })
            ->orWhere(function($query) use ($where) {
                $query
                    ->where($where)
                    ->where([['coupon_partner_grp_seqno', 'like', '%|0|%']]);
            })
            ->orWhere(function($query) use ($where) {
                $query
                    ->where($where)
                    ->where([['coupon_partner_grp_seqno', '=', '0']]);
            })
            ->select('coupon_user.*', 'coupon.type', 'coupon.name', 'coupon.discount_price', 'coupon.max_discount_price', 'coupon.limit_base_price')
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }
}
