<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $id = $request->post('id');
        $pw = $request->post('pw');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($id) || empty($pw)) {
            $result['ment'] = '계정을 확인해주세요.';
            return $result;
        }
        $user = DB::table("user_info")->where([
            ['user_phone', '=', $id],
            ['user_pw', '=', $pw],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            return $result;
        }
        if($user->approve_yn == 'N') {
            $result['ment'] = '아직 승인 대기중입니다. 관리자 승인후 이용이 가능합니다.';
            return $result;
        }

        $request->session()->put('user_seqno', $user->user_seqno);

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_seqno');
        $request->session()->forget('user_id');
        $request->session()->forget('user_name');

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
    // 아이디 중복 확인
    public function isDupplicated(Request $request)
    {
        $user_phone = $request->get('id');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        $user = DB::table("user_info")->whereRaw('replace(user_phone, \'-\', \'\') = replace(?, \'-\', \'\')', [$user_phone])
        ->where([
            ['delete_yn', '=', 'N']
        ])->first();

        if (! empty($user)) {
            $result['ment'] = '이미 가입된 계정입니다.';
            return $result;
        }
        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
    // 비밀번호 변경
    public function changePassword(Request $request)
    {
        $seqno = $request->post('seqno');
        $user_phone = $request->post('user_phone');
        $user_password = $request->post('user_password');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        $user = DB::table("user_info")
        ->where([
            ['user_seqno', '=', $seqno],
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $result['ment'] = '가입되지 않은 계정입니다.';
            return $result;
        }
        if ($user->user_pw == $user_password) {
            $result['ment'] = '기존 비밀번호와 같은 비밀번호입니다.';
            return $result;
        }

        DB::table('user_info')->where('user_seqno', '=', $seqno)->update(
            [
                'user_pw' => $user_password, 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
    
    // 가입 신청
    public function add(Request $request)
    {
        $user_phone = $request->post('id');
        $user_pw = $request->post('pw', '');
        $user_name = $request->post('name');
        $recommended_code = $request->post('recommended_code', '');
        $recommended_shop = $request->post('recommended_shop');
        $event_yn = $request->post('event_yn', 'N');
        
        $gender = $request->post('gender', '');
        $email = $request->post('email', '');
        $address = $request->post('address', '');
        $address_detail = $request->post('address_detail', '');
        $grade = $request->post('grade', '');
        $type = $request->post('type', '');
        $memo = $request->post('memo', '');
        $memo2 = $request->post('memo2', '');
        $join_path = $request->post('join_path', '');

        $approve_yn = 'Y';
        $delete_yn = 'N';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($user_phone) || strlen($user_phone) < 10) {
            $result['ment'] = '올바른 핸드폰 번호를 입력해주세요.';
            return $result;
        }
        if (empty($user_pw) || strlen($user_pw) < 4) {
            $result['ment'] = '비밀번호를 입력해주세요.';
            return $result;
        }
        $user_phone = str_replace('-', '', $user_phone);

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (! empty($user)) {
            $result['ment'] = '이미 가입된 계정입니다.';
            return $result;
        }

        $id = DB::table('user_info')->insertGetId(
            [
                'user_phone' => $user_phone
                , 'user_pw' => $user_pw
                , 'user_name' => $user_name
                , 'event_yn' => $event_yn
                , 'approve_yn' => $approve_yn
                , 'delete_yn' => $delete_yn
                , 'recommended_shop' => $recommended_shop
                , 'recommended_code' => $recommended_code
                
                , 'gender' => $gender
                , 'email' => $email
                , 'address' => $address
                , 'address_detail' => $address_detail
                , 'grade' => $grade
                , 'type' => $type
                , 'memo' => $memo
                , 'join_path' => $join_path

                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();
        // 포인트 기본 세팅 point_info
        $pointTypes = DB::table("point_info")->where([
            ['delete_yn', '=', 'N']
        ])->select('point_type')->get();
        $arrayPoint = $pointTypes;

        for($inx=0; $inx < count($arrayPoint); $inx++){
            $seq = DB::table('user_point')->insertGetId(
                [
                    'user_seqno' => $user->user_seqno
                    , 'point_type' => $arrayPoint[$inx]->point_type
                    , 'point' => 0
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        // 회원가입시 포인트 지급 처리
        $conf = DB::table("conf_auto_point")->first();
        if(!empty($conf) && $conf->join_bonus == 'Y') {
            $point = DB::table('user_point')->where([
                ['user_seqno', '=', $user->user_seqno],
                ['point_type', '=', 'P']
            ])->first();
            DB::table('user_point')->where([
                ['user_seqno', '=', $point->point + $user->user_seqno],
                ['point_type', '=', 'P']
            ])->update(
                [
                    'point' => $conf->join_bonus_point
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
            // 지급을 했으면 이력을 남기자.
            DB::table('user_point_hst')->insertGetId(
                [
                    'admin_seqno' => 0
                    , 'user_seqno' => $user->user_seqno
                    , 'admin_name' => ''
                    , 'point_type' => 'P'
                    , 'product_seqno' => 0
                    , 'hst_type' => 'S'
                    , 'point' => $conf->join_bonus_point
                    , 'memo' => '회원가입 포인트 자동 지급'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }
        if(!empty($conf) && $conf->recommand_bonus == 'Y' && !empty($recommended_code)) {
            // 추천인 보너스 포인트 지급

            $recommended_user = DB::table("user_info")->where([
                ['user_phone', '=', $recommended_code],
                ['delete_yn', '=', 'N']
            ])->first();
            $point = DB::table('user_point')->where([
                ['user_seqno', '=', $recommended_user->user_seqno],
                ['point_type', '=', 'P']
            ])->first();
            DB::table('user_point')->where([
                ['user_seqno', '=', $recommended_user->user_seqno],
                ['point_type', '=', 'P']
            ])->update(
                [
                    'point' => $point->point + $conf->recommand_bonus_point
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
            // 지급을 했으면 이력을 남기자.
            DB::table('user_point_hst')->insertGetId(
                [
                    'admin_seqno' => 0
                    , 'user_seqno' => $recommended_user->user_seqno
                    , 'admin_name' => ''
                    , 'point_type' => 'P'
                    , 'product_seqno' => 0
                    , 'hst_type' => 'S'
                    , 'point' => $conf->recommand_bonus_point
                    , 'memo' => '추천인 회원가입 포인트 자동 지급 [추천인 고객명/아이디: '.$user->user_name.' / '.$user->user_phone.']'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ]
            );
        }

        // 회원 가입시 쿠폰 발급 전부 지급
        {
            $coupons = DB::table("coupon")->where([
                ['issuance_type', '=', 'A'],
                ['issuance_condition_type', '=', 'J'],
                ['allowed_issuance_type', '=', 'A'],
                ['deleted', '=', 'N']
            ])->get();

            for($inx = 0; $inx < count($coupons); $inx++){
                $hst_seqno = DB::table('coupon_user')->insertGetId(
                    [
                        'coupon_seqno' => $coupons[$inx]->seqno,
                        'user_seqno' => $user->user_seqno,
                        'used' => 'N',
                        'real_start_dt' => $coupons[$inx]->start_dt,
                        'real_end_dt' => $coupons[$inx]->end_dt,
                        'real_discount_price' => 0,
                        'deleted' => 'N',
                        'hst_type' => 'S'
                    ], 'seqno'
                );
                DB::table('coupon_user_history')->insertGetId(
                    [
                        'coupon_user_seqno' => $hst_seqno,
                        'hst_type' => 'S',
                        'canceled' => 'N',
                        'approved' => 'N',
                        'memo' => '[쿠폰] 자동 지급 - 회원 가입 쿠폰',
                        'create_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        $result['ment'] = '성공';
        $result['data'] = $user_name;
        $result['result'] = true;

        return $result;
    }
    // 관리자 또는 본인
    // 회원 수정
    public function modify(Request $request)
    {
        $user_phone = $request->post('id');
        $user_pw = $request->post('pw', '');
        $user_pw2 = $request->post('pw2', '');
        $user_name = $request->post('name');
        $event_yn = $request->post('event_yn', 'N');
        $recommended_code = $request->post('recommended_code', '');
        $recommended_shop = $request->post('recommended_shop');
        $approve_yn = 'N';
        $delete_yn = 'N';
        $push_yn = $request->post('push_yn', 'N');
        $email_yn = $request->post('email_yn', 'N');
        $sns_yn = $request->post('sns_yn', 'N');
        
        $gender = $request->post('gender', '');
        $email = $request->post('email', '');
        $address = $request->post('address', '');
        $address_detail = $request->post('address_detail', '');
        $grade = $request->post('grade', '');
        $type = $request->post('type', '');
        $memo = $request->post('memo', '');
        $memo2 = $request->post('memo2', '');
        $join_path = $request->post('join_path', '');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($user_phone) || strlen($user_phone) < 10) {
            $result['ment'] = '올바른 핸드폰 번호를 입력해주세요.';
            return $result;
        }
        if (empty($user_pw) || strlen($user_pw) < 4) {
            $result['ment'] = '비밀번호를 입력해주세요.';
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            return $result;
        }

        if ($user->user_pw != $user_pw) {
            $result['ment'] = '기존 비밀번호가 일치하지 않습니다.';
            return $result;
        }
        // NOTE: 포인트 데이터가 추가될 경우 세팅 필요

        DB::table('user_info')->where('user_seqno', '=', $user->user_seqno)->update(
            [
                'user_pw' => $user_pw2
                , 'user_name' => $user_name
                , 'event_yn' => $event_yn
                , 'recommended_shop' => $recommended_shop
                , 'recommended_code' => $recommended_code
                , 'gender' => $gender
                , 'push_yn' => $push_yn
                , 'email_yn' => $email_yn
                , 'sns_yn' => $sns_yn
                
                , 'gender' => $gender
                , 'email' => $email
                , 'address' => $address
                , 'address_detail' => $address_detail
                , 'grade' => $grade
                , 'type' => $type
                , 'memo' => $memo
                , 'memo2' => $memo2
                , 'join_path' => $join_path

                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user_name;
        $result['result'] = true;

        return $result;
    }
    public function modifyMemo(Request $request)
    {
        $user_seqno = $request->post('user_seqno');
        $memo = $request->post('memo');
        $type = $request->post('type', 1);

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        DB::table('user_info')->where('user_seqno', '=', $user_seqno)->update(
            (
                $type != 1 
                ? ['memo2' => $memo, 'update_dt' => date('Y-m-d H:i:s')]
                : ['memo' => $memo, 'update_dt' => date('Y-m-d H:i:s')]
            )
            
        );

        $result['ment'] = '성공';
        $result['data'] = $memo;
        $result['result'] = true;

        return $result;
    }
    // 관리자
    // 승인 
    public function approve(Request $request)
    {
        $user_phone = $request->post('id');
        $approve_yn = 'Y';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($user_phone) || strlen($user_phone) < 10) {
            $result['ment'] = '올바른 핸드폰 번호를 입력해주세요.';
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            return $result;
        }

        DB::table('user_info')->where('user_seqno', '=', $user->user_seqno)->update(
            [
                'user_pw' => $user_pw
                , 'approve_yn' => $approve_yn
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user_name;
        $result['result'] = true;

        return $result;
    }
    // 관리자 또는 본인
    // 회원 탈퇴 <- 소프트
    public function delete(Request $request)
    {
        $user_phone = $request->post('id');
        $delete_yn = 'Y';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($user_phone) || strlen($user_phone) < 10) {
            $result['ment'] = '올바른 핸드폰 번호를 입력해주세요.';
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            return $result;
        }

        DB::table('user_info')->where('user_seqno', '=', $user->user_seqno)->update(
            [
                'delete_yn' => $delete_yn
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
    // 멤버쉽 카드 정보 수정 
    public function updateMembershipCardNo(Request $request)
    {
        $user_phone = $request->post('id');
        $membership_card_no = $request->post('membership_card_no');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($user_phone) || strlen($user_phone) < 10) {
            $result['ment'] = '올바른 핸드폰 번호를 입력해주세요.';
            return $result;
        }
        if (empty($membership_card_no) || strlen($membership_card_no) < 1) {
            $result['ment'] = '올바른 카드 번호를 입력해주세요.';
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            return $result;
        }

        DB::table('user_info')->where('user_seqno', '=', $user->user_seqno)->update(
            [
                'membership_card_no' => $membership_card_no
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user_phone;
        $result['result'] = true;

        return $result;
    }

    // 관리자만
    // 회원 조회 - 단건/다건 - 전화번호/이름 검색
    public function list(Request $request)
    {
        $search_field = $request->get('search');
        $start_day = $request->get('start_day');
        $end_day = $request->get('end_day');
        
        $memo = $request->get('memo');
        $memo2 = $request->get('memo2');
        $type = $request->get('type');
        $join_path = $request->get('join_path');
        
        $recommended_shop = $request->get('recommended_shop');
        $searchFieldRecommand = $request->get('searchFieldRecommand');
        $startReservateDay = $request->get('startReservateDay');
        $endReservateDay = $request->get('endReservateDay');
        
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $delete_yn = 'Y';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        $where = [];
        if (!empty($start_day) && $start_day != '') {
            array_push($where, ['user_info.create_dt', '>=', $start_day]);
        }
        if (!empty($end_day) && $end_day != '') {
            array_push($where, ['user_info.create_dt', '<=', $end_day]);
        }
        if (!empty($memo) && $memo != '') {
            array_push($where, ['user_info.memo', 'like', '%'.$memo.'%']);
        }
        if (!empty($memo2) && $memo2 != '') {
            array_push($where, ['user_info.memo2', 'like', '%'.$memo2.'%']);
        }
        if (!empty($type) && $type != '') {
            array_push($where, ['user_info.type', '=', $type]);
        }
        if (!empty($join_path) && $join_path != '') {
            array_push($where, ['user_info.join_path', '=', $join_path]);
        }
        if (!empty($recommended_shop) && $recommended_shop != '') {
            array_push($where, ['user_info.recommended_shop', '=', $recommended_shop]);
        }
        $reservationWhere = [];
        if (!empty($startReservateDay) && $startReservateDay != '') {
            array_push($reservationWhere, ['latest_reservation.last_start_dt', '>=', $startReservateDay]);
        }
        if (!empty($endReservateDay) && $endReservateDay != '') {
            array_push($reservationWhere, ['latest_reservation.last_start_dt', '<=', $endReservateDay]);
        }

        $users;
        $userCount;
        if (!empty($search_field) && $search_field != '') {
            $users = DB::table("user_info")->where($where)
                ->where(function($query) use ($search_field){
                    $query->orWhere('user_phone', 'like', '%'.$search_field.'%')
                        ->orWhere('user_name', 'like', '%'.$search_field.'%');
                })
                ->orderBy('create_dt', 'desc')
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
                ->get();
            $userCount = DB::table("user_info")->where($where)
                ->where(function($query) use ($search_field){
                    $query->orWhere('user_phone', 'like', '%'.$search_field.'%')
                        ->orWhere('user_name', 'like', '%'.$search_field.'%');
                })
                ->count();
        } else {
        }

        $users = DB::table("user_info")->where($where);
        $userCount = DB::table("user_info")->where($where);

        if (!empty($search_field) && $search_field != '') {
            $users = $users
                ->where(function($query) use ($search_field){
                    $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                        ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                });
            $userCount = $userCount
                ->where(function($query) use ($search_field){
                    $query->orWhere('user_info.user_phone', 'like', '%'.$search_field.'%')
                        ->orWhere('user_info.user_name', 'like', '%'.$search_field.'%');
                });
        }
        if (!empty($searchFieldRecommand) && $searchFieldRecommand != '') {
            $users = $users
                ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                ->where(function($query) use ($searchFieldRecommand){
                    $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$searchFieldRecommand.'%')
                        ->orWhere('recommand_user_info.user_name', 'like', '%'.$searchFieldRecommand.'%');
                });
            $userCount = $userCount
                ->join('user_info as recommand_user_info', 'recommand_user_info.user_phone', '=', 'user_info.recommended_code')
                ->where(function($query) use ($searchFieldRecommand){
                    $query->orWhere('recommand_user_info.user_phone', 'like', '%'.$searchFieldRecommand.'%')
                        ->orWhere('recommand_user_info.user_name', 'like', '%'.$searchFieldRecommand.'%');
                });
        }
        if (count($reservationWhere) > 0) {
            $latestReservation = DB::table('reservation')
                ->select('user_seqno', DB::raw('MAX(start_dt) as last_start_dt'))
                ->where([
                    ['status', '!=', 'C'],
                    ['deleted', '=', 'N']
                ])
                ->groupBy('user_seqno');

            $users = $users
                ->joinSub($latestReservation, 'latest_reservation', function ($join) use ($reservationWhere) {
                    $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno')
                        ->where($reservationWhere);
                });
            $userCount = $userCount
                ->joinSub($latestReservation, 'latest_reservation', function ($join) use ($reservationWhere) {
                    $join->on('user_info.user_seqno', '=', 'latest_reservation.user_seqno')
                        ->where($reservationWhere);
                });
        }
        $users = $users
            ->select('user_info.*')
            ->orderBy('user_info.create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $userCount = $userCount
            ->count();

        // 매칭되는 정액권, 포인트를 리턴
        for($inx = 0; $inx < count($users); $inx++){
            $points = DB::table("user_point")
                ->where([['user_seqno', '=', $users[$inx]->user_seqno]])->get();
            $users[$inx]->points = $points;

            $packageHistory = DB::table("user_package")->where([
                ['user_seqno', '=', $users[$inx]->user_seqno],
                ['deleted', '=', 'N']
            ])->first();
            $users[$inx]->packageHistory = $packageHistory;

            // 추천인 정보
            if(!empty($users[$inx]->recommended_code) && $users[$inx]->recommended_code != '') {
                $recommendedUser = DB::table("user_info")->where([
                    ['user_phone', '=', $users[$inx]->recommended_code]
                ])->first();
                $users[$inx]->recommendedUser = $recommendedUser;
            }

            // 마지막 예약 일시
            $lastReservation = DB::table("reservation")->where([
                ['user_seqno', '=', $users[$inx]->user_seqno],
                ['status', '!=', 'C'],
                ['deleted', '=', 'N']
            ])->orderBy('start_dt', 'desc')->first();
            $users[$inx]->lastReservation = $lastReservation;
        }

        $result['ment'] = '성공';
        $result['data'] = $users;
        $result['count'] = $userCount;
        $result['result'] = true;

        return $result;
    }
    // 관리자만
    public function find(Request $request)
    {
        $user_seqno = $request->get('user_seqno');
        
        $rpageNo = $request->get('rpageNo', 1);
        $rpageSize = $request->get('rpageSize', 10);
        
        $upageNo = $request->get('upageNo', 1);
        $upageSize = $request->get('upageSize', 10);
        
        $vpageNo = $request->get('vpageNo', 1);
        $vpageSize = $request->get('vpageSize', 10);
        
        $mpageNo = $request->get('mpageNo', 1);
        $mpageSize = $request->get('mpageSize', 10);
        $delete_yn = 'Y';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        $user = DB::table("user_info")->where([
                ['user_seqno', '=', $user_seqno]
            ])
            ->orderBy('create_dt', 'desc')
            ->first();

        // 매칭되는 정액권, 포인트를 리턴 
        if(!empty($user)) {
            $points = DB::table("user_point")
                ->where([['user_seqno', '=', $user->user_seqno]])->get();
            $user->points = $points;

            // 사용 내역
            $pointPaidHistory = DB::table("user_point_hst")
                ->leftJoin('product', 'product.product_seqno', '=', 'user_point_hst.product_seqno')
                ->select('user_point_hst.*'
                    , 'product.type_name'
                    , 'product.service_name'
                    , 'product.service_sub_name'
                    , 'product.price'
                    , 'product.return_point')
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '!=', 'U']])
                ->orderBy('create_dt', 'desc')
                ->offset(($rpageSize * ($rpageNo-1)))->limit($rpageSize)
                ->get();
            $pointPaidHistoryCount = DB::table("user_point_hst")
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '!=', 'U']])
                ->count();
            $user->pointPaidHistory = $pointPaidHistory;
            $user->pointPaidHistoryCount = $pointPaidHistoryCount;
            $pointUseHistory = DB::table("user_point_hst")
                ->leftJoin('product', 'product.product_seqno', '=', 'user_point_hst.product_seqno')
                ->select('user_point_hst.*'
                    , 'product.type_name'
                    , 'product.service_name'
                    , 'product.service_sub_name'
                    , 'product.price'
                    , 'product.return_point')
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '!=', 'S']])
                ->orderBy('create_dt', 'desc')
                ->offset(($upageSize * ($upageNo-1)))->limit($upageSize)
                ->get();
            // 예약 정보의 경우, 예약 정보도 같이 보내줘야함
            for($inx = 0; $inx < count($pointUseHistory); $inx++){
                if($pointUseHistory[$inx]->service_seqno < 1) {
                    continue;
                }
                $reservation = DB::table("reservation")
                    ->where([
                        ['user_seqno', '=', $pointUseHistory[$inx]->user_seqno],
                        ['service_seqno', '=', $pointUseHistory[$inx]->service_seqno],
                        ['create_dt', '>=', $pointUseHistory[$inx]->create_dt],
                        ['create_dt', '<', date("Y-m-d H:i:s", strtotime($pointUseHistory[$inx]->create_dt . ' +4 seconds'))]
                    ])->first();
                $pointUseHistory[$inx]->reservation = $reservation;
                $pointUseHistory[$inx]->reservation_ti = date("Y-m-d H:i:s", strtotime($pointUseHistory[$inx]->create_dt . ' +4 seconds'));
            }
            $pointUseHistoryCount = DB::table("user_point_hst")
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '=', 'U']])
                ->count();
            // 상품이 아닌 서비스인 경우
            for($inx = 0; $inx < count($pointUseHistory); $inx++){
                if(empty($pointUseHistory[$inx]->service_seqno) || $pointUseHistory[$inx]->service_seqno == 0) {
                    continue;
                }
                $detail = DB::table("store_service")
                    ->leftJoin('partner', 'partner.seqno', '=', 'store_service.partner_seqno')
                    ->select('store_service.*'
                        , 'partner.cop_name')
                    ->where([
                        ['store_service.seqno', '=', $pointUseHistory[$inx]->service_seqno]
                    ])->first();

                $pointUseHistory[$inx]->service_name = $detail->cop_name; // 제휴사명
                $pointUseHistory[$inx]->type_name = $detail->name; // 서비스명
                $pointUseHistory[$inx]->service_sub_name = '(' . $detail->estimated_time . ')'; // 소요시간
                $pointUseHistory[$inx]->price = $detail->price; // 가격
            }

            $user->pointUseHistory = $pointUseHistory;
            $user->pointUseHistoryCount = $pointUseHistoryCount;

            // 패키지 어떤 상품을 구매했는지 표현
            $collectPackage = DB::table("user_point_hst")
                ->leftJoin('product', 'product.product_seqno', '=', 'user_point_hst.product_seqno')
                ->select('user_point_hst.*'
                    , 'product.type_name'
                    , 'product.price'
                    , 'product.return_point')
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '=', 'S'], ['user_point_hst.point_type', '=', 'K']])
                ->first();
            if(empty($collectPackage)) {
                $user->used_package = '';
            } else {
                $user->used_package = $collectPackage->type_name;
            }
            $user->collectPackage = $collectPackage;

            $packageHistory = DB::table("user_package")->where([
                ['user_seqno', '=', $user_seqno],
                ['deleted', '=', 'N']
            ])->first();
            $user->packageHistory = $packageHistory;


            // 무슨 멤버쉽을 사용중인지
            $today = date("Y-m-d", time());
            $membership = DB::table("membership_user")->where([
                ['user_seqno', '=', $user->user_seqno],
                ['used', '=', 'N'],
                ['real_start_dt', '<=', date("Y-m-d H:i:s", time())],
                ['real_end_dt', '>=', date("Y-m-d H:i:s", time())],
                ['deleted', '=', 'N']
            ])
            ->orderBy('create_dt', 'desc')
            ->first();
            if(!empty($membership)) {
                $pmembership = DB::table("product_membership")->where([
                    ['seqno', '=', $membership->membership_seqno]
                ])->first();
                $membership->membershipInfo = $pmembership;
            }
            $user->membership = $membership;
            // 추천인 정보
            if(!empty($user->recommended_code) && $user->recommended_code != '') {
                $recommendedUser = DB::table("user_info")->where([
                    ['user_phone', '=', $user->recommended_code]
                ])->first();
                $user->recommendedUser = $recommendedUser;
            }

            // 사용했던 모든 멤버쉽
            $membershipHistory = DB::table("membership_user_hst")
                ->join('membership_user', 'membership_user.seqno', '=', 'membership_user_hst.membership_user_seqno')
                ->leftJoin('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
                ->select('membership_user_hst.*'
                    , 'product_membership.name as membership_name')
                ->where([['membership_user_hst.user_seqno', '=', $user->user_seqno]])
                ->whereIn('membership_user_hst.hst_type', ['S', 'R'])
                ->orderBy('membership_user_hst.create_dt', 'desc')
                ->offset(($mpageSize * ($mpageNo-1)))->limit($mpageSize)
                ->get();
            $membershipHistoryCount = DB::table("membership_user_hst")
                ->join('membership_user', 'membership_user.seqno', '=', 'membership_user_hst.membership_user_seqno')
                ->leftJoin('product_membership', 'membership_user.membership_seqno', '=', 'product_membership.seqno')
                ->select('membership_user_hst.*'
                    , 'product_membership.name as membership_name')
                ->where([['membership_user_hst.user_seqno', '=', $user->user_seqno]])
                ->whereIn('membership_user_hst.hst_type', ['S', 'R'])
                ->orderBy('membership_user_hst.create_dt', 'desc')
                ->count();
            $user->membershipHistory = $membershipHistory;
            $user->membershipHistoryCount = $membershipHistoryCount;
            // 사용했던 모든 바우처
            $voucherHistory = DB::table("voucher_user_history")
                ->join('voucher_user', 'voucher_user.seqno', '=', 'voucher_user_history.voucher_user_seqno')
                ->leftJoin('product_voucher', 'voucher_user.voucher_seqno', '=', 'product_voucher.seqno')
                ->select('voucher_user_history.*'
                    , 'product_voucher.name as voucher_name')
                ->where([['voucher_user.user_seqno', '=', $user->user_seqno]])
                ->whereIn('voucher_user_history.hst_type', ['S', 'R'])
                ->orderBy('voucher_user_history.create_dt', 'desc')
                ->offset(($mpageSize * ($mpageNo-1)))->limit($mpageSize)
                ->get();
            $voucherHistoryCount = DB::table("voucher_user_history")
                ->join('voucher_user', 'voucher_user.seqno', '=', 'voucher_user_history.voucher_user_seqno')
                ->leftJoin('product_voucher', 'voucher_user.voucher_seqno', '=', 'product_voucher.seqno')
                ->select('voucher_user_history.*'
                    , 'product_voucher.name as voucher_name')
                ->where([['voucher_user.user_seqno', '=', $user->user_seqno]])
                ->whereIn('voucher_user_history.hst_type', ['S', 'R'])
                ->orderBy('voucher_user_history.create_dt', 'desc')
                ->count();
            $user->voucherHistory = $voucherHistory;
            $user->voucherHistoryCount = $voucherHistoryCount;
        }

        $result['ment'] = '성공';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
}
