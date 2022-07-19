<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class EvenBannerUsedController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $event_search_type = $request->get('event_search_type', 'name');
        $search_field1 = $request->get('search_field1');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');
        $status = $request->get('status');
        $used_coupon = $request->get('used_coupon');
        
        $partner_seqno = $request->get('partner_seqno');
        $coupon_search_type = $request->get('coupon_search_type', 'name');
        $search_field2 = $request->get('search_field2');
        $coupon_start_dt = $request->get('coupon_start_dt');
        $coupon_end_dt = $request->get('coupon_end_dt');
        $type = $request->get('type');

        $user_search_type = $request->get('user_search_type', 'id');
        $search_field3 = $request->get('search_field3');
        $issued_start_dt = $request->get('issued_start_dt');
        $issued_end_dt = $request->get('issued_end_dt');
        $used = $request->get('used'); // 만료 상태 조회 조건 추가 X
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(! empty($used) && $used != ''){
            array_push($where, ['used', '>=', $used]);
        }

        $whereBanner = [];
        if(! empty($search_field1) && $search_field1 != ''){
            if($event_search_type == 'name') {
                array_push($whereBanner, ['even_banner.name', 'like', '%'.$search_field1.'%']);
            } else if($event_search_type == 'context') {
                array_push($whereBanner, ['even_banner.context', 'like', '%'.$search_field1.'%']);
            }
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($whereBanner, ['even_banner.start_dt', '>=', $start_dt]);
        }
        if(! empty($end_dt) && $end_dt != ''){
            array_push($whereBanner, ['even_banner.start_dt', '<=', $end_dt]);
        }
        if(! empty($status) && $status != ''){
            array_push($whereBanner, ['even_banner.status', '=', $status]);
        }
        if(! empty($used_coupon) && $used_coupon != ''){
            array_push($whereBanner, ['even_banner.used_coupon', '=', $used_coupon]);
        }

        $whereCoupon = [];
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($whereCoupon, ['coupon.coupon_partner_grp_seqno', 'like', '%|'.$partner_seqno.'|%']);
        }
        if(! empty($search_field2) && $search_field2 != ''){
            if($coupon_search_type == 'name') {
                array_push($whereCoupon, ['coupon.name', 'like', '%'.$search_field2.'%']);
            } else if($coupon_search_type == 'seqno') {
                array_push($whereCoupon, ['coupon.seqno', '=', $search_field2]);
            }
        }
        if(! empty($coupon_start_dt) && $coupon_start_dt != ''){
            array_push($whereCoupon, ['coupon.start_dt', '>=', $coupon_start_dt]);
        }
        if(! empty($coupon_end_dt) && $coupon_end_dt != ''){
            array_push($whereCoupon, ['coupon.start_dt', '<=', $coupon_end_dt]);
        }
        if(! empty($type) && $type != ''){
            array_push($whereCoupon, ['coupon.type', '=', $type]);
        }
        $whereUser = [];
        if(! empty($search_field3) && $search_field3 != ''){
            if($user_search_type == 'id') {
                array_push($whereUser, ['user_info.user_phone', 'like', '%'.$search_field3.'%']);
            } else if($user_search_type == 'name') {
                array_push($whereUser, ['user_info.user_name', 'like', '%'.$search_field3.'%']);
            } else if($user_search_type == 'seq') {
                array_push($whereUser, ['user_info.user_seqno', '=', $search_field3]);
            }
        }
        if(! empty($issued_start_dt) && $issued_start_dt != ''){
            array_push($whereUser, ['real_start_dt', '>=', $issued_start_dt]);
        }
        if(! empty($issued_end_dt) && $issued_end_dt != ''){
            array_push($whereUser, ['real_end_dt', '<=', $issued_end_dt]);
        }
        
        $contents = DB::table("even_banner_user")->where($where)
            ->join('even_banner', function ($join) use ($whereBanner) {
                $join->on('even_banner_user.even_banner_seqno', '=', 'even_banner.seqno')
                    ->where($whereBanner);
            })
            // 쿠폰 미사용의 경우 존재하지 않을 수 있음
            ->leftJoin('coupon', function ($join) use ($whereCoupon) {
                $join->on('even_banner.event_coupon_seqno', '=', 'coupon.seqno')
                    ->where($whereCoupon);
            })
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('even_banner_user.user_seqno', '=', 'user_info.user_seqno')
                    ->where($whereUser);
            })
            ->select(DB::raw('even_banner_user.*, even_banner.name as even_banner_name, even_banner.start_dt as even_banner_start_dt, even_banner.end_dt as even_banner_end_dt, even_banner.context as even_banner_context, coupon.name as coupon_name, coupon.context as coupon_context,'
                            .'coupon.coupon_partner_grp_seqno as coupon_partner_grp_seqno, coupon.start_dt as coupon_start_dt,'
                            .'coupon.end_dt as coupon_end_dt, coupon.type, discount_price, max_discount_price, limit_base_price, allowed_issuance_type,'
                            .'user_info.user_phone as user_id, user_info.user_name as user_name'))
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("even_banner_user")->where($where)
            ->join('even_banner', function ($join) use ($whereBanner) {
                $join->on('even_banner_user.even_banner_seqno', '=', 'even_banner.seqno')
                    ->where($whereBanner);
            })
            ->join('user_info', function ($join) use ($whereUser) {
                $join->on('even_banner_user.user_seqno', '=', 'user_info.user_seqno')
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
    
    // 이벤트 쿠폰 발급 여부
    private function checkIssuedEventCoupon($user_seqno, $couponId)
    {        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $user_info = DB::table('user_info')->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user_info)) {
            $result['ment'] = '로그인을 해주세요.';
            return $result;
        }
        $event_banner = DB::table('even_banner')->where([
            ['seqno', '=', $couponId],
            ['deleted', '=', 'N']
        ])->first();

        if(empty($event_banner)) {
            $result['ment'] = '존재하지 않는 쿠폰입니다.';
            return $result;
        }
        if(strtotime($event_banner->end_dt) < strtotime(date("Y-m-d H:i:s"))) {
            $result['ment'] = '이벤트 기간이 아닙니다.';
            return $result;
        }

        $even_banner_user = DB::table('even_banner_user')->where([
            ['even_banner_seqno', '=', $couponId],
            ['user_seqno', '=', $user_info->user_seqno],
            ['deleted', '=', 'N']
        ])->first();

        if(!empty($even_banner_user)) {
            $result['ment'] = '이미 참여한 이벤트입니다.';
            return $result;
        }

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
    public function confirmIssuedEventCoupon(Request $request, $couponId)
    {
        $user_id = $request->get('user_id');
        $result = $this->checkIssuedEventCoupon($user_id, $couponId);
        return $result;
    }
    // 나의 이벤트 쿠폰 발급
    public function addEventCoupon(Request $request, $couponId)
    {
        $user_id = $request->post('user_id');

        $result = $this->checkIssuedEventCoupon($user_id, $couponId);

        if(empty($result) || !$result['result']) {
            return $result;
        }

        $user_info = DB::table('user_info')->where([
            ['user_seqno', '=', $user_id],
            ['delete_yn', '=', 'N']
        ])->first();
        $event_banner = DB::table('even_banner')->where([
            ['seqno', '=', $couponId],
            ['deleted', '=', 'N']
        ])->first();
        $even_banner_seqno = DB::table('even_banner_user')->insertGetId(
            [
                'even_banner_seqno' => $event_banner->seqno
                , 'user_seqno' => $user_info->user_seqno
                , 'used' => 'N'
                , 'real_start_dt' => $event_banner->start_dt
                , 'real_end_dt' => $event_banner->end_dt
                , 'real_discount_price' => 0
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
        );
        
        if(!empty($event_banner->event_coupon_seqno) && $event_banner->used_coupon == 'Y') {
            $coupon = DB::table('coupon')->where('seqno', '=', $event_banner->event_coupon_seqno)->first();
            
            $coupon_user_seqno = DB::table('coupon_user')->insertGetId(
                [
                    'coupon_seqno' => $event_banner->event_coupon_seqno
                    , 'user_seqno' => $user_id
                    , 'used' => 'N'
                    , 'real_start_dt' => $event_banner->start_dt
                    , 'real_end_dt' => $event_banner->end_dt
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
                    , 'memo' => '이벤트 쿠폰 다운로드로 인한 충전'
                    , 'create_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );
        }

        $result['ment'] = '성공';
        $result['even_banner_seqno'] = $even_banner_seqno;
        $result['result'] = true;

        return $result;
    }
}
