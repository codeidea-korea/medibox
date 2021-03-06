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
            $recommended_code = $request->post('recommended_code', '');
            $recommended_shop = $request->post('recommended_shop');
            
                
            return view('user.agreement')->with('id', $id)->with('pw', $pw)->with('name', $name)
                ->with('recommended_code', $recommended_code)->with('recommended_shop', $recommended_shop);
        }
    
        return view('user.agreement');
    }
    public function approval(Request $request, $result_code)
    {
        $userSeqno = $request->session()->get('user_seqno');
        $id = $request->get('id', '');

        return view('user.approval')->with('code', $result_code)->with('id', $id)->with('userSeqno', $userSeqno);
    }
    public function brand(Request $request)
    {
        return view('user.brand.list');
    }
    public function brandDetail(Request $request, $partnerNo)
    {
        $brandInfo = DB::table("partner")->where([
            ['seqno', '=', $partnerNo],
            ['deleted', '=', 'N']
        ])->first();

        return view('user.brand.detail', ['brandInfo' => $brandInfo]);
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
    public function changePassword(Request $request)
    {
        $userID = $request->get('userID', '');

        $userInfo = DB::table("user_info")->where([
            ['user_phone', '=', $userID],
            ['delete_yn', '=', 'N']
        ])->first();

        return view('user.login.change_pw', ['userInfo' => $userInfo]);
    }
    public function findId(Request $request)
    {
        return view('user.login.find_id');
    }
    public function findPassword(Request $request)
    {
        return view('user.login.find_pw');
    }
    
    public function main(Request $request)
    {
        $isLogin = false;
        if ($request->session()->has('user_seqno')) {
            $isLogin = true;
        }

        $contents = DB::table("template")->where([
            ['choosed', '=', 'Y'],
            ['deleted', '=', 'N']
        ])->first();
        
        $brands = DB::table("partner")->where([
            ['deleted', '=', 'N']
        ])->get();

//        return view('user.main')->with('isLogin', $isLogin);
        return view('user.'.$contents->file_name, ['isLogin' => $isLogin, 'brands' => $brands]);
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
    public function profile(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
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

        // 멤버쉽 membership
        $today = date("Y-m-d", time());
        $smembership = '';
        $membership = DB::table("membership_user")->where([
            ['user_seqno', '=', $user->user_seqno],
            ['used', '=', 'N'],
            ['real_start_dt', '<=', date("Y-m-d H:i:s", time())],
            ['real_end_dt', '>=', date("Y-m-d H:i:s", time())],
            ['deleted', '=', 'N']
        ])->first();
        if(!empty($membership)) {
            $pmembership = DB::table("product_membership")->where([
                ['seqno', '=', $membership->membership_seqno]
            ])->first();
            $smembership = $pmembership->name . ' 멤버쉽';
        }

        return view('user.profile')->with('id', $user->user_phone)
            ->with('pw', $user->user_pw)->with('name', $user->user_name)->with('receive', $user->event_yn)->with('smembership', $smembership);
    }
    public function profile_edit(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
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

        return view('user.profile_edit', ['user' => $user, 'seqno' => $userSeqno]);
    }
    public function mypage_edit(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
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

        return view('user.mypage_edit', ['user' => $user, 'seqno' => $userSeqno]);
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

    private function checkInvalidSession(Request $request) {
        if (! $request->session()->has('user_seqno')) {
            return true;
        }
        return false;
    }
    public function payhistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        return view('user.payhistory')->with('seqno', $userSeqno);
    }
    public function services(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        return view('user.services')->with('seqno', $userSeqno);
    }
    public function payhistoryType(Request $request, $type)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        return view('user.payhistory')->with('seqno', $userSeqno)->with('type', $type);
    }
    public function pointhome(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        return view('user.pointhome')->with('seqno', $userSeqno);
    }
    public function pointpayment(Request $request, $type)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        return view('user.pointpayment')->with('seqno', $userSeqno)->with('type', $type);
    }
    
    public function reservationCart(Request $request, $brandNo, $shopNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');

        return view('user.reservation.cart')
            ->with('seqno', $userSeqno)
            ->with('brandNo', $brandNo)
            ->with('shopNo', $shopNo);
    }
    public function reservationModifyCart(Request $request, $historyNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        
        $reservationInfo = DB::table("reservation")->where([
            ['seqno', '=', $historyNo],
            ['deleted', '=', 'N']
        ])->first();

        if (empty($reservationInfo)) {
            $request->session()->put('error', '존재하지 않는 예약정보입니다.');
            return redirect('/index');
        }

        /*
        return view('user.reservation.modify.cart')
            ->with('seqno', $userSeqno)
            ->with('reservationInfo', $reservationInfo);
            */

        return view('user.reservation.modify')
            ->with('seqno', $userSeqno)
            ->with('historyNo', $historyNo);
    }
    public function reservationModifyPayment(Request $request, $historyNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $userSeqno]
        ])->first();
        
        $reservationInfo = DB::table("reservation")->where([
            ['seqno', '=', $historyNo],
            ['deleted', '=', 'N']
        ])->first();

        if (empty($reservationInfo)) {
            $request->session()->put('error', '존재하지 않는 예약정보입니다.');
            return redirect('/index');
        }
        $date = $request->get('date', '');
        $time = $request->get('time', '');
        $serviceId = $request->get('serviceId', '');

        $oldServiceInfo = DB::table("store_service")->where([
            ['seqno', '=', $reservationInfo->service_seqno],
            ['deleted', '=', 'N']
        ])->first();
        $reservation_old_price = $oldServiceInfo->price;

        $shopInfo = DB::table("store")->where([
            ['seqno', '=', $reservationInfo->store_seqno],
            ['deleted', '=', 'N']
        ])->first();
        $serviceInfo = DB::table("store_service")->where([
            ['seqno', '=', $serviceId],
            ['deleted', '=', 'N']
        ])->first();
        $pointInfo = DB::table("user_point")->where([
            ['user_seqno', '=', $userSeqno],
            ['point_type', '=', 'P']
        ])->first();
        
        $reservation_shop = $shopInfo->name; 
        $reservation_service = $serviceInfo->name;
        $reservation_price = $serviceInfo->price;

        $remain_point = $pointInfo->point;
        $remain_point2 = 0;

        return view('user.reservation.modify.payment')
            ->with('seqno', $userSeqno)
            ->with('user', $user) 
            ->with('date', $date)
            ->with('time', $time)
            ->with('serviceId', $serviceId)
            ->with('reservation_shop', $reservation_shop)
            ->with('reservation_service', $reservation_service)
            ->with('reservation_price', $reservation_price)
            ->with('reservation_old_price', $reservation_old_price)
            ->with('remain_point', $remain_point)
            ->with('remain_point2', $remain_point2)
            ->with('reservationInfo', $reservationInfo);
    }
    public function reservationPayment(Request $request, $brandNo, $shopNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        $date = $request->get('date', '');
        $time = $request->get('time', '');
        $serviceId = $request->get('serviceId', '');

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $userSeqno]
        ])->first();
        $shopInfo = DB::table("store")->where([
            ['seqno', '=', $shopNo],
            ['deleted', '=', 'N']
        ])->first();
        $serviceInfo = DB::table("store_service")->where([
            ['seqno', '=', $serviceId],
            ['deleted', '=', 'N']
        ])->first();
        // 포인트
        $pointInfo = DB::table("user_point")->where([
            ['user_seqno', '=', $userSeqno],
            ['point_type', '=', 'P']
        ])->first();

        // 서비스를 진행하는 파트너사의 정액권
        $partner = DB::table("partner")->where([
            ['seqno', '=', $serviceInfo->partner_seqno]
        ])->first();
        $passInfo = DB::table("user_point")->where([
            ['user_seqno', '=', $userSeqno],
            ['point_type', '=', $partner->type_code]
        ])->first();
        
        $reservation_shop = $shopInfo->name; 
        $reservation_service = $serviceInfo->name;
        $reservation_price = $serviceInfo->price;

        return view('user.reservation.payment', ['seqno' => $userSeqno, 'user' => $user, 'brandNo' => $brandNo, 'shopNo' => $shopNo, 
        'date' => $date, 'time' => $time, 'serviceId' => $serviceId, 'reservation_shop' => $reservation_shop, 'reservation_service' => $reservation_service, 
        'reservation_price' => $reservation_price, 'pointInfo' => $pointInfo, 'passInfo' => $passInfo, 'shopNo' => $shopNo, 'shopNo' => $shopNo, 'point_type' => $partner->type_code]);
    }
    public function reservationHistory(Request $request)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');

        $stores = DB::table("store")->where([
            ['deleted', '=', 'N']
        ])->orderBy('orders', 'asc')->get();

        for($inx = 0; $inx < count($stores); $inx++){
            $partnerInfo = DB::table("partner")
                ->where([['seqno', '=', $stores[$inx]->partner_seqno]])->first();
                
            $stores[$inx]->partnerInfo = $partnerInfo;
        }

        return view('user.reservation.history.list', ['stores' => $stores, 'seqno' => $userSeqno]);
    }
    public function reservationHistoryView(Request $request, $historyNo)
    {
        $reservationInfo = DB::table("reservation")->where([
            ['seqno', '=', $historyNo],
            ['deleted', '=', 'N']
        ])->first();

        return view('user.reservation.history.view')
            ->with('seqno', $reservationInfo->user_seqno)
            ->with('historyNo', $historyNo);
    }

    public function policy(Request $request)
    {
        return view('user.policy');
    }
    public function privacy(Request $request)
    {
        $contents = DB::table("cont_privacy")->where([
            ['deleted', '=', 'N']
        ])->orderBy('create_dt', 'desc')->first();

        return view('user.privacy', ['contents' => $contents]);
    }
    
    public function tos(Request $request)
    {
        $contents = DB::table("cont_usage")->where([
            ['deleted', '=', 'N']
        ])->orderBy('create_dt', 'desc')->first();

        return view('user.tos', ['contents' => $contents]);
    }
    public function thirdparty(Request $request)
    {
        return view('user.thirdparty');
    }
    public function marketing(Request $request)
    {
        return view('user.marketing');
    }

    public function reservation(Request $request)
    {
        $stores = DB::table("store")->where([
            ['deleted', '=', 'N']
        ])->orderBy('create_dt', 'desc')->get();

        for($inx = 0; $inx < count($stores); $inx++){
            $partnerInfo = DB::table("partner")
                ->where([['seqno', '=', $stores[$inx]->partner_seqno]])->first();
                
            $stores[$inx]->partnerInfo = $partnerInfo;
        }

        return view('user.store.list', ['stores' => $stores]);
    }
    public function reservationDetail(Request $request, $storeNo)
    {
        $storeInfo = DB::table("store")->where([
            ['seqno', '=', $storeNo],
            ['deleted', '=', 'N']
        ])->first();
        $services = DB::table("store_service")->where([
            ['store_seqno', '=', $storeNo],
            ['deleted', '=', 'N']
        ])->orderBy('orders', 'asc')->orderBy('create_dt', 'desc')->get();
        $managers = DB::table("store_manager")->where([
            ['store_seqno', '=', $storeNo],
            ['deleted', '=', 'N']
        ])->orderBy('create_dt', 'desc')->get();

        return view('user.store.detail', ['storeInfo' => $storeInfo, 'services' => $services, 'managers' => $managers]);
    }
    public function signup1(Request $request)
    {
        return view('user.signup1');
    }
    public function signup2(Request $request)
    {
        return view('user.signup2');
    }
    public function signup3(Request $request)
    {
        return view('user.signup3');
    }
    public function valmontspa(Request $request)
    {
        return view('user.valmontspa');
    }
    public function valmontspa_reservation(Request $request)
    {
        return view('user.valmontspa_reservation');
    }

    public function voucher(Request $request)
    {
        $userSeqno = $request->session()->get('user_seqno');

        return view('user.voucher', ['userSeqno' => $userSeqno]);
    }
    public function reservationByVoucher(Request $request, $voucherNo)
    {
        if ($this->checkInvalidSession($request)) {
            $request->session()->put('error', '세션이 만료되었습니다. 다시 로그인하여 주세요.');
            return redirect('/index');
        }
        $userSeqno = $request->session()->get('user_seqno');
        
        $voucher = DB::table("voucher_user")->where([
            ['seqno', '=', $voucherNo],
            ['deleted', '=', 'N']
        ])->first();
        $voucherInfo = DB::table("product_voucher")->where([
            ['seqno', '=', $voucher->voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $userSeqno]
        ])->first();
        $shopInfo = DB::table("store")->where([
            ['seqno', '=', $voucherInfo->store_seqno],
            ['deleted', '=', 'N']
        ])->first();
        $serviceInfo = DB::table("store_service")->where([
            ['seqno', '=', $voucherInfo->service_seqno],
            ['deleted', '=', 'N']
        ])->first();
        // 포인트
        $pointInfo = DB::table("user_point")->where([
            ['user_seqno', '=', $userSeqno],
            ['point_type', '=', 'P']
        ])->first();

        // 서비스를 진행하는 파트너사의 정액권
        $partner = DB::table("partner")->where([
            ['seqno', '=', $serviceInfo->partner_seqno]
        ])->first();
        $passInfo = DB::table("user_point")->where([
            ['user_seqno', '=', $userSeqno],
            ['point_type', '=', $partner->type_code]
        ])->first();
        
        $reservation_shop = $shopInfo->name; 
        $reservation_service = $serviceInfo->name;
        $reservation_price = $serviceInfo->price;

        return view('user.reservation.voucher', ['seqno' => $userSeqno, 'userSeqno' => $userSeqno, 'user' => $user, 'brandNo' => $partner->seqno, 'shopNo' => $shopInfo->seqno, 
        'serviceId' => $serviceInfo->seqno, 'reservation_shop' => $reservation_shop, 'reservation_service' => $reservation_service, 
        'reservation_price' => $reservation_price, 'pointInfo' => $pointInfo, 'passInfo' => $passInfo, 'point_type' => $partner->type_code, 'voucherNo' => $voucherNo]);
    }
    public function voucher_confirm(Request $request, $id)
    {
        $userSeqno = $request->session()->get('user_seqno');

        // 서비스의 경우 이벤트 예약으로 이동
        $voucher = DB::table("voucher_user")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();
        $voucherInfo = DB::table("product_voucher")->where([
            ['seqno', '=', $voucher->voucher_seqno],
            ['deleted', '=', 'N']
        ])->first();
        if(!empty($voucherInfo) && $voucherInfo->service_seqno > 0){
            return redirect('/reservation-voucher/'.$id);
        }

        return view('user.voucher_confirm', ['userSeqno' => $userSeqno, 'id' => $id]);
    }

    public function coupon(Request $request)
    {
        $userSeqno = $request->session()->get('user_seqno');

        return view('user.coupon', ['userSeqno' => $userSeqno]);
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
        $user = DB::table("user_info")->whereRaw('replace(user_phone, \'-\', \'\') = replace(?, \'-\', \'\')', [$id])
        ->where([
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($user)) {
            $result['ment'] = '없는 계정입니다.';
            $request->session()->put('error', $result['ment']);
            return back()->withInput();
        }
        if($user->user_pw != $pw) {
            $result['ment'] = '비밀번호가 다릅니다.';
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

    public function barcode(Request $request)
    {
        return view('user.barcode');
    }
    
    
    public function notices(Request $request)
    {
        return view('user.contents.notice.list');
    }
    public function notice(Request $request, $id)
    {
        return view('user.contents.notice.detail')->with('id', $id);
    }
    public function faqs(Request $request)
    {
        return view('user.contents.faq.list');
    }
    public function faq(Request $request, $id)
    {
        return view('user.contents.faq.detail')->with('id', $id);
    }
    public function helps(Request $request)
    {
        return view('user.contents.help.list');
    }
    public function help(Request $request, $id)
    {
        return view('user.contents.help.detail')->with('id', $id);
    }
    public function events(Request $request)
    {
        return view('user.contents.event.list');
    }
    public function event(Request $request, $id)
    {
        $userSeqno = $request->session()->get('user_seqno');
        $event_coupon = DB::table('even_banner')->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        $even_banner_user = DB::table('even_banner_user')->where([
            ['even_banner_seqno', '=', $id],
            ['user_seqno', '=', $userSeqno],
            ['deleted', '=', 'N']
        ])->first();

        return view('user.contents.event.detail', ['id' => $id, 'userSeqno' => $userSeqno, 'event_coupon' => $event_coupon, 'even_banner_user' => $even_banner_user]);
    }
    public function version(Request $request)
    {
        return view('user.contents.version');
    }
    
    public function approvalCoupon(Request $request, $result_code)
    {
        $userSeqno = $request->session()->get('user_seqno');
        $id = $request->get('id', '');

        return view('user.approval.coupon')->with('code', $result_code)->with('id', $id)->with('userSeqno', $userSeqno);
    }
    public function approvalVoucher(Request $request, $result_code)
    {
        $userSeqno = $request->session()->get('user_seqno');
        $id = $request->get('id', '');

        return view('user.approval.voucher')->with('code', $result_code)->with('id', $id)->with('userSeqno', $userSeqno);
    }
}
