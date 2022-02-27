<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    // 로그인
    public function login_proccess(Request $request)
    {
        $id = $request->post('id');
        $pw = $request->post('pw');

        $result = [];
        $result['ment'] = '실패';
        $result['result'] = false;

        if (empty($id) || empty($pw)) {
            $result['ment'] = '계정을 확인해주세요.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        $admin = DB::table("admin_info")->where([
            ['admin_id', '=', $id],
            ['admin_pw', '=', $pw],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($admin)) {
            $result['ment'] = '없는 계정입니다.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        $request->session()->put('admin_seqno', $admin->admin_seqno);

        return redirect('/admin');
    }
    // 로그아웃
    public function logout_proccess(Request $request)
    {
        $request->session()->forget('admin_seqno');

        return redirect('/admin/login');
    }
    public function login_medibox(Request $request)
    {
        return view('admin.login_medibox');
    }

    private function checkInvalidSession(Request $request) {
        if (! $request->session()->has('admin_seqno')) {
            return true;
        }
        return false;
    }

    public function index(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return redirect('/admin/members');
    }
    public function medibox_member(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.medibox_member')->with('seqno', $userSeqno);
    }
    public function medibox_member_view(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');
        $user = DB::table("admin_info")->where([
            ['admin_seqno', '=', $userSeqno]
        ])
            ->orderBy('create_dt', 'desc')
            ->first();
        if(empty($user)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }

        return view('admin.medibox_member_view')->with('seqno', $userSeqno)->with('id', $id)->with('name', $user->admin_name);
    }
    public function medibox_member_detail(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.medibox_member_detail')->with('seqno', $userSeqno)->with('id', $id);
    }
}
