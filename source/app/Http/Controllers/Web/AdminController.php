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
            $result['ment'] = '아이디나 비밀번호가 잘못되었습니다.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        $request->session()->put('admin_id', $admin->admin_id);
        $request->session()->put('admin_seqno', $admin->admin_seqno);
        $request->session()->put('admin_type', $admin->admin_type);
        $request->session()->put('partner_seqno', $admin->partner_seqno);
        $request->session()->put('store_seqno', $admin->store_seqno);
        $request->session()->put('level_partner_grp_seqno', $admin->level_partner_grp_seqno);

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
    
    // 공지사항 유저
    public function notices(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.notice.list')->with('seqno', $userSeqno);
    }
    public function notice(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.notice.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 공지사항 파트너
    public function partnerNotices(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.partnernotice.list')->with('seqno', $userSeqno);
    }
    public function partnerNotice(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.partnernotice.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 공지사항 파트너 메인
    public function partnerHome(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.main.partner.list')->with('seqno', $userSeqno);
    }
    public function partnerNoticeDetail(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.main.partner.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 자주묻는질문
    public function faqs(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.faq.list')->with('seqno', $userSeqno);
    }
    public function faq(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.faq.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 도움말
    public function helps(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.help.list')->with('seqno', $userSeqno);
    }
    public function help(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.help.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 이용약관
    public function usages(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.usage.list')->with('seqno', $userSeqno);
    }
    public function usage(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.usage.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 개인정보처리약관
    public function privacies(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.privacy.list')->with('seqno', $userSeqno);
    }
    public function privacy(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.privacy.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 메인화면 디자인 선택
    public function template(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.contents.template.main')->with('seqno', $userSeqno);
    }
    
    // 제휴사 관리
    public function partners(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.list')->with('seqno', $userSeqno);
    }
    public function partner(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 매장 관리
    public function stores(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.list')->with('seqno', $userSeqno);
    }
    public function store(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 디자이너 관리
    public function managers(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.manager.list')->with('seqno', $userSeqno);
    }
    public function manager(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.manager.detail')->with('seqno', $userSeqno)->with('id', $id);
    }
    // 서비스 관리
    public function services(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.service.list')->with('seqno', $userSeqno);
    }
    public function service(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.service.detail')->with('seqno', $userSeqno)->with('id', $id);
    }

    public function reservations(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.reservations.list')->with('seqno', $userSeqno);
    }
    public function reservationsCondition(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.reservations.condition')->with('seqno', $userSeqno);
    }

    public function businessHours(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.partners.stores.business_hours')->with('seqno', $userSeqno);
    }
    
    public function pointHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.point.list')->with('seqno', $userSeqno);
    }
    public function pointHistoryDetail(Request $request, $historyNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $hst = DB::table("user_point_hst")->where([
            ['user_point_hst_seqno', '=', $historyNo]
        ])->first();
        $userInfo = DB::table("user_info")->where([
            ['user_seqno', '=', $hst->user_seqno]
        ])->first();
        $hst->userInfo = $userInfo;

        return view('admin.service.point.detail', ['seqno' => $userSeqno, 'historyNo' => $historyNo, 'history' => $hst]);
    }
    public function pointConf(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $conf = DB::table("conf_auto_point")->first();

        return view('admin.service.point.conf', ['seqno' => $userSeqno, 'conf' => $conf]);
    }

    public function flatRateTickets(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.flatRateTickets.list')->with('seqno', $userSeqno);
    }
    public function flatRateTicket(Request $request, $tiketNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $product = DB::table("product")->where([
            ['product_seqno', '=', $tiketNo],
            ['offline_type', '=', 'N'],
            ['point_type', '!=', 'K'],
            ['delete_yn', '=', 'N']
        ])->first();

        if ($tiketNo > 0 && empty($product)) {
            $request->session()->put('error', '없는 정보입니다.');
            return redirect('/admin/service/tickets');
        }

        return view('admin.service.flatRateTickets.detail', ['seqno' => $userSeqno, 'tiketNo' => $tiketNo, 'product' => $product]);
    }

    public function packages(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.package.list')->with('seqno', $userSeqno);
    }
    public function package(Request $request, $packageNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $product = DB::table("product")->where([
            ['product_seqno', '=', $packageNo],
            ['offline_type', '=', 'N'],
            ['point_type', '=', 'K'],
            ['delete_yn', '=', 'N']
        ])->first();

        if ($packageNo > 0 && empty($product)) {
            $request->session()->put('error', '없는 정보입니다.');
            return redirect('/admin/service/packages');
        }

        return view('admin.service.package.detail', ['seqno' => $userSeqno, 'packageNo' => $packageNo, 'product' => $product]);
    }

    public function vouchers(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.voucher.list')->with('seqno', $userSeqno);
    }
    public function voucher(Request $request, $voucherNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $product = DB::table("product_voucher")->where([
            ['seqno', '=', $voucherNo],
            ['deleted', '=', 'N']
        ])->first();

        if ($voucherNo > 0 && empty($product)) {
            $request->session()->put('error', '없는 정보입니다.');
            return redirect('/admin/service/vouchers');
        }

        return view('admin.service.voucher.detail', ['seqno' => $userSeqno, 'voucherNo' => $voucherNo, 'product' => $product]);
    }

    public function coupons(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.coupon.list')->with('seqno', $userSeqno);
    }
    public function coupon(Request $request, $couponNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.coupon.detail', ['seqno' => $userSeqno, 'couponNo' => $couponNo]);
    }

    public function couponHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.coupon.history.list')->with('seqno', $userSeqno);
    }
    public function couponHistoryDetail(Request $request, $historyNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');
        
        $contents = DB::table("coupon_user")->where([
            ['product_seqno', '=', $historyNo],
            ['deleted', '=', 'N']
        ])
        ->join('coupon', function ($join) {
            $join->on('coupon_user.coupon_seqno', '=', 'coupon.coupon_seqno');
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

        return view('admin.service.coupon.history.detail', ['seqno' => $userSeqno, 'history' => $contents, 'historyNo' => $historyNo]);
    }

    public function memberships(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.membership.list')->with('seqno', $userSeqno);
    }
    public function membership(Request $request, $membershipNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.service.membership.detail', ['seqno' => $userSeqno, 'membershipNo' => $membershipNo]);
    }
    public function membershipHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $contents = DB::table("product_membership")->where([
            ['deleted', '=', 'N']
        ])->get();

        return view('admin.service.membership.history.list', ['seqno' => $userSeqno, 'contents' => $contents]);
    }

    
    public function paymentsMembership(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        $contents = DB::table("product_membership")->where([
            ['deleted', '=', 'N']
        ])->get();

        return view('admin.payments.memberships', ['seqno' => $userSeqno, 'contents' => $contents]);
    }
    public function paymentsPoints(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.payments.points', ['seqno' => $userSeqno]);
    }
    
    public function eventCoupons(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.event.coupon.list')->with('seqno', $userSeqno);
    }
    public function eventCoupon(Request $request, $couponNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.event.coupon.detail', ['seqno' => $userSeqno, 'couponNo' => $couponNo]);
    }

    public function eventCouponHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.event.coupon.history.list')->with('seqno', $userSeqno);
    }
    
    
    public function adminLevels(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.admin.list')->with('seqno', $userSeqno);
    }
    public function adminLevel(Request $request, $id)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.admin.detail', ['seqno' => $userSeqno, 'id' => $id]);
    }

    public function adminActionHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/admin/login');
        }
        $userSeqno = $request->session()->get('admin_seqno');

        return view('admin.admin.history.list')->with('seqno', $userSeqno);
    }
}
