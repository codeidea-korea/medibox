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
    // 가입 신청
    public function add(Request $request)
    {
        $user_phone = $request->post('id');
        $user_pw = $request->post('pw', '');
        $user_name = $request->post('name');
        $event_yn = $request->post('event_yn', 'N');
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
        $approve_yn = 'N';
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
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user_name;
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
    // 관리자만
    // 회원 조회 - 단건/다건 - 전화번호/이름 검색
    public function list(Request $request)
    {
        $search_field = $request->get('search');
        $start_day = $request->get('start_day');
        $end_day = $request->get('end_day');
        
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $delete_yn = 'Y';

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        $where = [];
        if (!empty($start_day) && $start_day != '') {
            array_push($where, ['create_dt', '>=', $start_day]);
        }
        if (!empty($end_day) && $end_day != '') {
            array_push($where, ['create_dt', '<=', $end_day]);
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
            $users = DB::table("user_info")->where($where)
                ->orderBy('create_dt', 'desc')
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
                ->get();
            $userCount = DB::table("user_info")->where($where)
                ->count();
        }

        // 매칭되는 정액권, 포인트를 리턴
        for($inx = 0; $inx < count($users); $inx++){
            $points = DB::table("user_point")
                ->where([['user_seqno', '=', $users[$inx]->user_seqno]])->get();
            $users[$inx]->points = $points;
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
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '=', 'U']])
                ->orderBy('create_dt', 'desc')
                ->offset(($upageSize * ($upageNo-1)))->limit($upageSize)
                ->get();
            $pointUseHistoryCount = DB::table("user_point_hst")
                ->where([['user_seqno', '=', $user->user_seqno], ['hst_type', '=', 'U']])
                ->count();
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
        }

        $result['ment'] = '성공';
        $result['data'] = $user;
        $result['result'] = true;

        return $result;
    }
}
