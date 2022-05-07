<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // 예약 조회 (제휴사, 매장, 기간)
    public function getListInStore(Request $request){
        $partner_seqno = $request->get('partner_seqno');
        $store_seqno = $request->get('store_seqno');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        array_push($where, ['status', '!=', 'C']);
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['partner_seqno', '=', $partner_seqno]);
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($where, ['start_dt', '>=', $start_dt]);
            array_push($where, ['start_dt', '<=', $end_dt]);
        }

        $contents = DB::table("reservation")->where($where)
            ->orderBy('create_dt', 'desc')
            ->get();
        for($inx = 0; $inx < count($contents); $inx++){
            $userInfo = DB::table("user_info")
                ->where([['user_seqno', '=', $contents[$inx]->user_seqno]])->first();
            $partnerInfo = DB::table("partner")
                ->where([['seqno', '=', $contents[$inx]->partner_seqno]])->first();
            $storeInfo = DB::table("store")
                ->where([['seqno', '=', $contents[$inx]->store_seqno]])->first();
            $managerInfo = DB::table("store_manager")
                ->where([['seqno', '=', $contents[$inx]->manager_seqno]])->first();
            $serviceInfo = DB::table("store_service")
                ->where([['seqno', '=', $contents[$inx]->service_seqno]])->first();
                
            $contents[$inx]->userInfo = $userInfo;
            $contents[$inx]->partnerInfo = $partnerInfo;
            $contents[$inx]->storeInfo = $storeInfo;
            $contents[$inx]->managerInfo = $managerInfo;
            $contents[$inx]->serviceInfo = $serviceInfo;
        }

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }
    // 예약 삭제
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $user_seqno = $request->get('user_seqno');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['user_seqno', '=', $user_seqno]);
        }

        $contents = DB::table("reservation")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("reservation")->where($where)
            ->count();

        // 고객(n:1), 제휴사(n:1), 매장(n:1), 디자이너(n:1)
        for($inx = 0; $inx < count($contents); $inx++){
            $userInfo = DB::table("user_info")
                ->where([['user_seqno', '=', $contents[$inx]->user_seqno]])->first();
            $partnerInfo = DB::table("partner")
                ->where([['seqno', '=', $contents[$inx]->partner_seqno]])->first();
            $storeInfo = DB::table("store")
                ->where([['seqno', '=', $contents[$inx]->store_seqno]])->first();
            $managerInfo = DB::table("store_manager")
                ->where([['seqno', '=', $contents[$inx]->manager_seqno]])->first();
            $serviceInfo = DB::table("store_service")
                ->where([['seqno', '=', $contents[$inx]->service_seqno]])->first();
                
            $contents[$inx]->userInfo = $userInfo;
            $contents[$inx]->partnerInfo = $partnerInfo;
            $contents[$inx]->storeInfo = $storeInfo;
            $contents[$inx]->managerInfo = $managerInfo;
            $contents[$inx]->serviceInfo = $serviceInfo;
        }

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function find(Request $request, $id)
    {
        $id = $request->get('id');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $contents = DB::table("reservation")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();
        $userInfo = DB::table("user_info")
            ->where([['user_seqno', '=', $contents->user_seqno]])->first();
        $partnerInfo = DB::table("partner")
            ->where([['seqno', '=', $contents->partner_seqno]])->first();
        $storeInfo = DB::table("store")
            ->where([['seqno', '=', $contents->store_seqno]])->first();
        $managerInfo = DB::table("store_manager")
            ->where([['seqno', '=', $contents->manager_seqno]])->first();
        $serviceInfo = DB::table("store_service")
            ->where([['seqno', '=', $contents->service_seqno]])->first();
            
        $contents->userInfo = $userInfo;
        $contents->partnerInfo = $partnerInfo;
        $contents->storeInfo = $storeInfo;
        $contents->managerInfo = $managerInfo;
        $contents->serviceInfo = $serviceInfo;

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');

        $partner_seqno = $request->post('partner_seqno', '0');
        $store_seqno = $request->post('store_seqno', '0');
        $manager_seqno = $request->post('manager_seqno', '0');
        $user_seqno = $request->post('user_seqno', '0');
        $service_seqno = $request->post('service_seqno', '0');

        $status = $request->post('status', '');
        $use_icon_important = $request->post('use_icon_important', '');
        $use_icon_phone = $request->post('use_icon_phone', '');
        $use_custom_color = $request->post('use_custom_color', '');
        
        $custom_color = $request->post('custom_color', '');
        $estimated_time = $request->post('estimated_time', '');
        $start_dt = $request->post('start_dt', '');
        
        $memo = $request->post('memo', '');
        $apply_on_mobile = $request->post('apply_on_mobile', '');
        $user_name = $request->post('user_name', '');
        $user_phone = $request->post('user_phone', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        if(empty($estimated_time) || $estimated_time == '') {
            $estimatedService = DB::table("store_service")->where([
                ['seqno', '=', $service_seqno],
                ['deleted', '=', 'N']
            ])->first();
            if(!empty($estimatedService)) {
                $estimated_time = $estimatedService->estimated_time;
            }
        }

        $id = DB::table('reservation')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'manager_seqno' => $manager_seqno
                , 'user_seqno' => $user_seqno
                , 'service_seqno' => $service_seqno
                
                , 'status' => $status
                , 'use_icon_important' => $use_icon_important
                , 'use_icon_phone' => $use_icon_phone
                , 'use_custom_color' => $use_custom_color
                
                , 'custom_color' => $custom_color
                , 'estimated_time' => $estimated_time
                , 'start_dt' => $start_dt
                
                , 'memo' => $memo
                , 'apply_on_mobile' => $apply_on_mobile
                , 'user_name' => $user_name
                , 'user_phone' => $user_phone

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

        $partner_seqno = $request->post('partner_seqno', '0');
        $store_seqno = $request->post('store_seqno', '0');
        $manager_seqno = $request->post('manager_seqno', '0');
        $user_seqno = $request->post('user_seqno', '0');
        $service_seqno = $request->post('service_seqno', '0');

        $status = $request->post('status', '');
        $use_icon_important = $request->post('use_icon_important', '');
        $use_icon_phone = $request->post('use_icon_phone', '');
        $use_custom_color = $request->post('use_custom_color', '');
        
        $custom_color = $request->post('custom_color', '');
        $estimated_time = $request->post('estimated_time', '');
        $start_dt = $request->post('start_dt', '');
        
        $memo = $request->post('memo', '');
        $apply_on_mobile = $request->post('apply_on_mobile', '');
        $user_name = $request->post('user_name', '');
        $user_phone = $request->post('user_phone', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('reservation')->where('seqno', '=', $id)->update(
            [
                'admin_seqno' => $admin_seqno
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'manager_seqno' => $manager_seqno
                , 'user_seqno' => $user_seqno
                , 'service_seqno' => $service_seqno
                
                , 'status' => $status
                , 'use_icon_important' => $use_icon_important
                , 'use_icon_phone' => $use_icon_phone
                , 'use_custom_color' => $use_custom_color
                
                , 'custom_color' => $custom_color
                , 'estimated_time' => $estimated_time
                , 'start_dt' => $start_dt
                
                , 'memo' => $memo
                , 'apply_on_mobile' => $apply_on_mobile
                , 'user_name' => $user_name
                , 'user_phone' => $user_phone

                , 'update_dt' => date('Y-m-d H:i:s')
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modifyStatus(Request $request, $id)
    {
        $status = $request->post('status');

        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        DB::table('reservation')->where('seqno', '=', $id)->update(
            [
                'status' => $status, 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function remove(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        DB::table('reservation')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    // 매장
    // 매장별 예약 가능 시간 설정
}
