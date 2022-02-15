<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

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
        $request->session()->put('user_id', $user->user_phone);
        $request->session()->put('user_name', $user->user_name);

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

        $user = DB::table("user_info")->where([
            ['user_phone', '=', $user_phone],
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
        $result['ment'] = '성공';
        $result['data'] = $user_name;
        $result['result'] = true;

        return $result;
    }
    // 회원 수정
    public function modify(Request $request)
    {
        $user_phone = $request->post('id');
        $user_pw = $request->post('pw', '');
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

        DB::table('user_info')->where('user_seqno', '=', $user->user_seqno)->update(
            [
                'user_pw' => $user_pw
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
                'user_pw' => $user_pw
                , 'delete_yn' => $delete_yn
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['data'] = $user_name;
        $result['result'] = true;

        $request->session()->forget('user_seqno');
        $request->session()->forget('user_id');
        $request->session()->forget('user_name');

        return $result;
    }
}
