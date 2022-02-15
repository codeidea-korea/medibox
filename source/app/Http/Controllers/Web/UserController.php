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
    public function login_main(Request $request)
    {
        return view('user.login_main');
    }
    public function main(Request $request)
    {
        return view('user.main');
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
        return view('user.mypage');
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
}
