<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function welcome(Request $request)
    {
        return view('user.welcome');
    }
    public function agreement(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = $request->post('id', '');
            $pw = $request->post('pw1', '');
            $name = $request->post('name', '홍길동');
                
            return view('user.agreement')->with('id', $id)->with('pw', $pw)->with('name', $name);
        }
    
        return view('user.agreement');
    }
    public function approval(Request $request)
    {
        return view('user.approval');
    }
    public function brand(Request $request)
    {
        return view('user.brand');
    }
    public function deepfocus(Request $request)
    {
        return view('user.deepfocus');
    }
    public function deepfocus_reservation(Request $request)
    {
        return view('user.deepfocus_reservation');
    }
    public function forestablack(Request $request)
    {
        return view('user.forestablack');
    }
    public function forestablack_reservation(Request $request)
    {
        return view('user.forestablack_reservation');
    }
    public function login(Request $request)
    {
        return view('user.login');
    }
    
    public function main(Request $request)
    {
        $isLogin = false;
        if ($request->session()->has('user_seqno')) {
            $isLogin = true;
        }
        return view('user.main')->with('isLogin', $isLogin);
    }
    public function medibox_list(Request $request)
    {
        return view('user.medibox_list');
    }
    public function minishmanultherapy_reservation(Request $request)
    {
        return view('user.minishmanultherapy_reservation');
    }
    public function minishspa(Request $request)
    {
        return view('user.minishspa');
    }
    public function minishspa_reservation(Request $request)
    {
        return view('user.minishspa_reservation');
    }
    public function minishtherapy(Request $request)
    {
        return view('user.minishtherapy');
    }
    public function mypage(Request $request)
    {
        if (! $request->session()->has('user_seqno')) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $userSeqno],
            ['delete_yn', '=', 'N']
        ])->first();

        if (empty($user)) {
            $request->session()->put('error', '계정을 확인해주세요.');
            return back()->withInput();
        }

        $user->user_name = ($user->user_name == '홍길동' ? '' : $user->user_name);

        return view('user.mypage')->with('id', $user->user_phone)
            ->with('pw', $user->user_pw)->with('name', $user->user_name)->with('receive', $user->event_yn);
    }
    public function mypage_privacy(Request $request)
    {
        return view('user.mypage_privacy');
    }
    public function nail(Request $request)
    {
        return view('user.nail');
    }
    public function nail_reservation(Request $request)
    {
        return view('user.nail_reservation');
    }
    public function payhistory(Request $request)
    {
        return view('user.payhistory');
    }
    public function pointhome(Request $request)
    {
        return view('user.pointhome');
    }
    public function pointpayment(Request $request)
    {
        return view('user.pointpayment');
    }
    public function policy(Request $request)
    {
        return view('user.policy');
    }
    public function privacy(Request $request)
    {
        return view('user.privacy');
    }
    public function reservation(Request $request)
    {
        return view('user.reservation');
    }
    public function signup(Request $request)
    {
        return view('user.signup');
    }
    public function valmontspa(Request $request)
    {
        return view('user.valmontspa');
    }
    public function valmontspa_reservation(Request $request)
    {
        return view('user.valmontspa_reservation');
    }


    
    public function login_main(Request $request)
    {
        $request->session()->put('user_seqno', 1);

        return view('user.login_main');
    }
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
        $user = DB::table("user_info")->where([
            ['user_phone', '=', $id],
            ['user_pw', '=', $pw],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        if($user->approve_yn == 'N') {
            $result['ment'] = '아직 승인 대기중입니다. 관리자 승인후 이용이 가능합니다.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        $request->session()->put('user_seqno', $user->user_seqno);

        return redirect('/index');
    }
    public function logout_proccess(Request $request)
    {
        $request->session()->forget('user_seqno');

        return redirect('/');
    }
}
