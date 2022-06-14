<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function getAll(Request $request){
        $partner_seqno = $request->get('partner_seqno');
        $id = $request->get('id');
        $partner_ids = $request->get('partner_ids');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['partner_seqno', '=', $partner_seqno]);
        }
        if(! empty($id) && $id != ''){
            array_push($where, ['seqno', '=', $id]);
        }

        $contents = DB::table("store")->where($where)
            ->orderBy('create_dt', 'desc')
            ->get();
        $count = DB::table("store")->where($where)
            ->count();

        if(! empty($partner_ids) && $partner_ids != ''){
            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $partner_ids)));

            $contents = DB::table("store")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->orderBy('create_dt', 'desc')
                ->get();
            $count = DB::table("store")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->count();
        }
        // 매장에 소속된 디자이너 데이터
        for($inx = 0; $inx < count($contents); $inx++){
            $managerInfo = DB::table("store_manager")
                ->where([['store_seqno', '=', $contents[$inx]->seqno]])->get();
            $serviceInfo = DB::table("store_service")
                ->where([['store_seqno', '=', $contents[$inx]->seqno]])->get();
                
            $contents[$inx]->managerInfo = $managerInfo;
            $contents[$inx]->serviceInfo = $serviceInfo;
        }

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function list(Request $request){
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $name = $request->get('name');
        $partner_seqno = $request->get('partner_seqno');
        $partner_ids = $request->get('partner_ids');
        $store_seqno = $request->get('store_seqno');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($name) && $name != ''){
            array_push($where, ['name', '=', $name]);
        }
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['partner_seqno', '=', $partner_seqno]);
        }
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['seqno', '=', $store_seqno]);
        }

        $contents = DB::table("store")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("store")->where($where)
            ->count();

        if(! empty($partner_ids) && $partner_ids != ''){
            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $partner_ids)));

            $contents = DB::table("store")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->orderBy('create_dt', 'desc')
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
                ->get();
            $count = DB::table("store")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->count();
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

        $contents = DB::table("store")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');

        $partner_seqno = $request->post('partner_seqno', '0');
        $name = $request->post('name');
        $phone = $request->post('phone', '');
        $address = $request->post('address', '');
        $address_detail = $request->post('address_detail', '');
        $zipcode = $request->post('zipcode', '');
        
        $info = $request->post('info', '');
        
        $img1 = $request->post('img1', '');
        $img2 = $request->post('img2', '');
        $img3 = $request->post('img3', '');
        $img4 = $request->post('img4', '');
        $img5 = $request->post('img5', '');
        $icon = $request->post('icon', '');
        
        $in_manager = $request->post('in_manager', 'N');
        $manager_type = $request->post('manager_type', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;
        if(!empty($start_dt) && !empty($end_dt)) {
            if($end_dt < $start_dt) {
                $result['ment'] = '시작시간이 종료시간보다 나중일 수 없습니다.';
                return $result;
            }
        }

        $id = DB::table('store')->insertGetId(
            [
                'admin_seqno' => $admin_seqno

                , 'partner_seqno' => $partner_seqno
                , 'name' => $name
                , 'phone' => $phone
                , 'address' => $address
                , 'address_detail' => $address_detail
                , 'zipcode' => $zipcode
                
                , 'info' => $info
                
                , 'img1' => $img1
                , 'img2' => $img2
                , 'img3' => $img3
                , 'img4' => $img4
                , 'img5' => $img5
                , 'icon' => $icon
                
                , 'in_manager' => $in_manager
                , 'manager_type' => $manager_type

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
        $name = $request->post('name');
        $phone = $request->post('phone', '');
        $address = $request->post('address', '');
        $address_detail = $request->post('address_detail', '');
        $zipcode = $request->post('zipcode', '');
        
        $info = $request->post('info', '');
        
        $img1 = $request->post('img1', '');
        $img2 = $request->post('img2', '');
        $img3 = $request->post('img3', '');
        $img4 = $request->post('img4', '');
        $img5 = $request->post('img5', '');
        $icon = $request->post('icon', '');
        
        $in_manager = $request->post('in_manager', 'N');
        $manager_type = $request->post('manager_type', '');
        
        $start_dt = $request->post('start_dt', '');
        $end_dt = $request->post('end_dt', '');
        $due_day = $request->post('due_day', '');
        
        $lunch_start_dt = $request->post('lunch_start_dt', '');
        $lunch_end_dt = $request->post('lunch_end_dt', '');
        $allow_lunch_reservate = $request->post('allow_lunch_reservate', '');
        
        $allow_ext_holiday = $request->post('allow_ext_holiday', '');
        $ext_holiday_weekly = $request->post('ext_holiday_weekly', '');
        $ext_holiday_weekend_day = $request->post('ext_holiday_weekend_day', '');
        $ext_holiday_montly = $request->post('ext_holiday_montly', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        if(!empty($allow_ext_holiday) && $allow_ext_holiday != '') {
            if($allow_ext_holiday == 'N') {
                // 지정 없음
                $ext_holiday_weekly = '';
                $ext_holiday_weekend_day = '';
                $ext_holiday_montly = '';
            } else if($allow_ext_holiday == 'W') {
                $ext_holiday_weekend_day = '';
                $ext_holiday_montly = '';
            } else if($allow_ext_holiday == 'M') {
                $ext_holiday_weekly = '';
                $ext_holiday_montly = '';
            } else if($allow_ext_holiday == 'D') {
                $ext_holiday_weekly = '';
                $ext_holiday_weekend_day = '';
            }
        }
        if(!empty($start_dt) && !empty($end_dt)) {
            if($end_dt < $start_dt) {
                $result['ment'] = '시작시간이 종료시간보다 나중일 수 없습니다.';
                return $result;
            }
        }

        DB::table('store')->where('seqno', '=', $id)->update(
            [
                'admin_seqno' => $admin_seqno

                , 'partner_seqno' => $partner_seqno
                , 'name' => $name
                , 'phone' => $phone
                , 'address' => $address
                , 'address_detail' => $address_detail
                , 'zipcode' => $zipcode
                
                , 'info' => $info
                
                , 'img1' => $img1
                , 'img2' => $img2
                , 'img3' => $img3
                , 'img4' => $img4
                , 'img5' => $img5
                , 'icon' => $icon
                
                , 'in_manager' => $in_manager
                , 'manager_type' => $manager_type
                
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'due_day' => $due_day
                
                , 'lunch_start_dt' => $lunch_start_dt
                , 'lunch_end_dt' => $lunch_end_dt
                , 'allow_lunch_reservate' => $allow_lunch_reservate
                
                , 'allow_ext_holiday' => $allow_ext_holiday
                , 'ext_holiday_weekly' => $ext_holiday_weekly
                , 'ext_holiday_weekend_day' => $ext_holiday_weekend_day
                , 'ext_holiday_montly' => $ext_holiday_montly

                , 'update_dt' => date('Y-m-d H:i:s')
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

        DB::table('store')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
}
