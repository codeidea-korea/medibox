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
                'user_info.user_seqno', 'user_info.user_phone', 'user_info.user_name',
                'product_membership.name', 'membership_user.real_start_dt', 'membership_user.real_end_dt',
                'store_service.name', 'product_voucher.name', 'coupon.name', 
                'membership_user_hst.hst_type', 'membership_user_hst.create_dt',
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
}
