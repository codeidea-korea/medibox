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
        $store_seqno = $request->get('store_seqno');
        $include_discontinued = $request->get('include_discontinued', 'N');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(empty($include_discontinued) || $include_discontinued == 'N') {
            array_push($where, ['deleted', '=', 'N']);
        }

        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }
        
        $contents = DB::table("product_voucher")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        for($inx = 0; $inx < count($contents); $inx++){
            $storeInfo = DB::table("store")
                ->where([['seqno', '=', $contents[$inx]->store_seqno]])
                ->first();
            $contents[$inx]->storeInfo = $storeInfo;
        }
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
            ['seqno', '=', $id]
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
        $price = $request->post('price', 0);

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
                , 'price' => $price
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
        $deleted = $request->post('deleted', 'N');
        $price = $request->post('price', 0);

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
                , 'price' => $price
                , 'deleted' => $deleted
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

    // 나의 바우처 목록
    public function myVouchers(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        // 기간
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');
        // 
        $user_seqno = $request->get('user_seqno');
        $voucher_seqno = $request->get('voucher_seqno');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['voucher_user.deleted', '=', 'N']);
        if(! empty($voucher_seqno) && $voucher_seqno != ''){
            array_push($where, ['voucher_user.seqno', '=', $voucher_seqno]);
        }
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['voucher_user.user_seqno', '=', $user_seqno]);
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($where, ['voucher_user.create_dt', '>=', $start_dt]);
        }
        if(! empty($end_dt) && $end_dt != ''){
            array_push($where, ['voucher_user.create_dt', '<=', $end_dt]);
        }
        
        $contents = DB::table("voucher_user")
            ->leftJoin('product_membership', 'product_membership.seqno', '=', 'voucher_user.membership_seqno')
            ->join('product_voucher', 'product_voucher.seqno', '=', 'voucher_user.voucher_seqno')
            ->join('user_info', 'user_info.user_seqno', '=', 'voucher_user.user_seqno')
            ->where($where)
            ->orderBy('voucher_user.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->select(DB::raw('voucher_user.*, product_membership.name as membership_name, '
                .' product_voucher.seqno as product_seqno, product_voucher.name as voucher_name, product_voucher.unit_count as unit_count, product_voucher.price as voucher_price, product_voucher.date_use as date_use,'
                .' user_info.user_phone as user_phone, user_info.user_name as user_name, user_info.memo as memo, user_info.memo as memo'))->get();
                // 
        $count = DB::table("voucher_user")
            ->leftJoin('product_membership', 'product_membership.seqno', '=', 'voucher_user.membership_seqno')
            ->join('product_voucher', 'product_voucher.seqno', '=', 'voucher_user.voucher_seqno')
            ->join('user_info', 'user_info.user_seqno', '=', 'voucher_user.user_seqno')
            ->where($where)
            ->select(DB::raw('voucher_user.*, product_membership.name as membership_name, '
                .' product_voucher.seqno as product_seqno, product_voucher.name as voucher_name, product_voucher.date_use as date_use,'
                .' user_info.user_phone as user_phone, user_info.user_name as user_name, user_info.memo as memo, user_info.memo as memo'))
            ->count();
        
        
        for($inx = 0; $inx < count($contents); $inx++){
            $voucher = DB::table("product_voucher")->where([
                ['seqno', '=', $contents[$inx]->voucher_seqno],
                ['deleted', '=', 'N']
            ])->first();
            $remaindCount = 1;
            if(!empty($contents[$inx]->membership_seqno) && $contents[$inx]->membership_seqno > 0) {
                // 수량 파악            
                $etcVoucher = DB::table('membership_etc_voucher_grp')->where([
                    ['membership_seqno', '=', $contents[$inx]->membership_seqno],
                    ['etc_voucher_seqno', '=', $contents[$inx]->voucher_seqno],
                    ['deleted', '=', 'N']
                ])->first();
                $usedCnt = DB::table('voucher_user_history')->where([
                    ['voucher_user_seqno', '=', $contents[$inx]->seqno],
                    ['hst_type', '=', 'U']
                ])->count();
                $refundCnt = DB::table('voucher_user_history')->where([
                    ['voucher_user_seqno', '=', $contents[$inx]->seqno],
                    ['hst_type', '=', 'R']
                ])->count();
    
                $remaindCount = empty($etcVoucher->unit_count) ? 1 : $etcVoucher->unit_count - ($usedCnt - $refundCnt);
            }
            $contents[$inx]->remaindCount = $remaindCount;
        }

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }
    // 바우처 적립
    public function collect(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 식별자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $voucher_seqno = $request->post('voucher_seqno'); // 대상 바우처
        $memo = $request->post('memo', '');
        
        $result = [];
        $result['ment'] = '바우처가 적립되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($voucher_seqno)) {
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
            $result['ment'] = '바우처가 적립되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        $voucher = DB::table("product_voucher")->where([
            ['seqno', '=', $voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();
        
        if(empty($voucher)) {
            $result['ment'] = '바우처가 적립되지 않았습니다.\r없는 바우처 정보입니다.';
            return $result;
        }
        // 구매 가능한지
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->first();
        if($point->point - $voucher->price < 0){
            $result['ment'] = '바우처가 적립되지 않았습니다.\r구매에 사용할 포인트가 부족합니다.';
            return $result;
        }

        // 히스토리에 포인트 이력 추가
        $id = DB::table('user_point_hst')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'user_seqno' => $user_seqno
                , 'admin_name' => $admin_name // empty($admin) ? '' : $admin->admin_name
                , 'point_type' => 'P'
                , 'hst_type' => 'U'
                , 'point' => $voucher->price
                , 'memo' => '[바우처 구매] ' . $voucher->name
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $voucher_user_seqno = DB::table('voucher_user')->insertGetId(
            [
                'membership_seqno' => 0 // 멤버쉽 아님
                , 'voucher_seqno' => $voucher_seqno
                , 'user_seqno' => $user_seqno
                , 'used' => 'N'
                , 'approved' => 'Y'
                , 'hst_type' => 'S'
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s')
            ], 'seqno'
        );
        DB::table('voucher_user_history')->insertGetId(
            [
                'voucher_user_seqno' => $voucher_user_seqno
                , 'hst_type' => 'S'
                , 'canceled' => 'N'
                , 'approved' => 'Y'
                , 'memo' => '바우처 구매로 인한 충전'
                , 'create_dt' => date('Y-m-d H:i:s')
            ], 'seqno'
        );
        DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->update(
            [
                'point' => $point->point - $voucher->price
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $price = $voucher->price;
        
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
                        'point' => $point->point + $etcPoint
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

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원에게 ['.$voucher->name.'] 바우처가 추가되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
    // 바우처 환불
    public function refund(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 식별자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $voucher_seqno = $request->post('voucher_seqno'); // 대상 바우처
        $memo = $request->post('memo', '');
        
        $result = [];
        $result['ment'] = '바우처가 환불되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($admin_seqno) || empty($user_seqno) || empty($voucher_seqno)) {
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
            $result['ment'] = '바우처가 환불되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        $voucher = DB::table("voucher_user")->where([
            ['seqno', '=', $voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();
        
        if(empty($voucher)) {
            $result['ment'] = '바우처가 환불되지 않았습니다.\r없는 바우처 정보입니다.';
            return $result;
        }
        $point = DB::table('user_point')->where([
            ['user_seqno', '=', $user_seqno],
            ['point_type', '=', 'P']
        ])->first();

        // 3. 바우처를 사용한 경우
        $voucherHistoryCount = DB::table("voucher_user_history")
        ->where([
            ['voucher_user_history.voucher_user_seqno', '=', $voucher->seqno],
//            ['membership_etc_voucher_grp.membership_seqno', '=', 0],
            ['voucher_user_history.hst_type', '=', 'U'],
            ['voucher_user_history.create_dt', '>', $voucher->create_dt]
        ])->count();
        if($voucherHistoryCount > 0) {
            $result['ment'] = '바우처가 환불되지 않았습니다.\r이미 바우처를 사용하였습니다.';
            return $result;
        }
        // 바우처를 모두 삭제
        $voucherInfo = DB::table("product_voucher")->where([
            ['seqno', '=', $voucher->voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();
        {
            DB::table('voucher_user')->where('seqno', '=', $voucher_seqno)->update(
                [
                    'deleted' => 'Y', 
                    'update_dt' => date('Y-m-d H:i:s') 
                ]
            );

            DB::table('voucher_user_history')->insertGetId(
                [
                    'voucher_user_seqno' => $voucher_seqno
                    , 'hst_type' => 'R'
                    , 'canceled' => 'N'
                    , 'approved' => 'Y'
                    , 'memo' => '바우처 환불로 인한 삭제'
                    , 'create_dt' => date('Y-m-d H:i:s')
                ], 'seqno'
            );
        }
        // 포인트를 반환 처리
        {
            DB::table('user_point_hst')->insertGetId(
                [
                    'admin_seqno' => $admin_seqno
                    , 'user_seqno' => $user_seqno
                    , 'admin_name' => $admin_name
                    , 'point_type' => 'P'
                    , 'product_seqno' => 0
                    , 'hst_type' => 'R'
                    , 'point' => $voucherInfo->price
                    , 'memo' => '바우처 환불로 인한 포인트 반환'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'user_point_hst_seqno'
            );
            DB::table('user_point')->where([
                ['user_seqno', '=', $user_seqno],
                ['point_type', '=', 'P']
            ])->update(
                [
                    'point' => $point->point - $voucherInfo->price
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의\r['.$voucherInfo->name.'] 바우처가 환불되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }

    // 바우처 사용 1회
    public function use(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno'); // 담당자 식별자
        $admin_name = $request->post('admin_name', ''); // 담당자 식별자
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $voucher_seqno = $request->post('voucher_seqno'); // 대상 바우처
        $memo = $request->post('memo', '');
        
        $result = [];
        $result['ment'] = '바우처가 사용되지 않았습니다.\r정보를 다시 한번 확인해주세요.';
        $result['result'] = false;

        if(empty($user_seqno) || empty($voucher_seqno)) {
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
            $result['ment'] = '바우처가 사용되지 않았습니다.\r없는 고객 정보이거나 이미 탈퇴한 고객입니다.';
            return $result;
        }
        $voucher = DB::table("voucher_user")->where([
            ['seqno', '=', $voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();
        
        if(empty($voucher)) {
            $result['ment'] = '바우처가 사용되지 않았습니다.\r없는 바우처 정보입니다.';
            return $result;
        }
        if($voucher->used == 'Y') {
            $result['ment'] = '바우처가 사용되지 않았습니다.\r이미 모두 사용한 바우처 정보입니다.';
            return $result;
        }

        // membership_seqno 이 있으면 멤버쉽이고, 수량이 존재한다.
        $remaindCount = 1;
        if(!empty($voucher->membership_seqno) && $voucher->membership_seqno > 0) {
            // 수량 파악            
            $etcVoucher = DB::table('membership_etc_voucher_grp')->where([
                ['membership_seqno', '=', $voucher->membership_seqno],
                ['etc_voucher_seqno', '=', $voucher->voucher_seqno],
                ['deleted', '=', 'N']
            ])->first();
            $voucherHistory = DB::table('voucher_user_history')->where([
                ['voucher_user_seqno', '=', $voucher->voucher_seqno]
            ])->get();
            $usedCnt = DB::table('voucher_user_history')->where([
                ['voucher_user_seqno', '=', $voucher->seqno],
                ['hst_type', '=', 'U']
            ])->count();
            $refundCnt = DB::table('voucher_user_history')->where([
                ['voucher_user_seqno', '=', $voucher->seqno],
                ['hst_type', '=', 'R']
            ])->count();

            $remaindCount = $etcVoucher->unit_count - ($usedCnt - $refundCnt);
        }
        // 모두 썼다면 used 를 Y 로 바꿔준다.
        if($remaindCount == 1) {
            DB::table('voucher_user')->where('seqno', '=', $voucher_seqno)->update(
                [
                    'used' => 'Y', 
                    'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }
        // 사용 히스토리를 쌓는다.
        DB::table('voucher_user_history')->insertGetId(
            [
                'voucher_user_seqno' => $voucher_seqno
                , 'hst_type' => 'U'
                , 'canceled' => 'N'
                , 'approved' => 'Y'
                , 'memo' => '사용자 화면 -> 바우처 사용'
                , 'create_dt' => date('Y-m-d H:i:s')
            ], 'seqno'
        );

        $result['ment'] = '[('.$user->user_phone.') '.$user->user_name.']회원의 바우처가 사용되었습니다.';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
}
