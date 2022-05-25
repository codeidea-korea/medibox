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
        $partner_ids = $request->get('partner_ids');
        $store_seqno = $request->get('store_seqno');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($user_seqno) && $user_seqno != ''){
            array_push($where, ['user_seqno', '=', $user_seqno]);
        }
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }

        $contents = DB::table("reservation")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("reservation")->where($where)
            ->count();

        if(! empty($partner_ids) && $partner_ids != ''){
            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $partner_ids)));

            $contents = DB::table("reservation")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->orderBy('create_dt', 'desc')
                ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
                ->get();
            $count = DB::table("reservation")->where($where)
                ->whereIn('partner_seqno', $partnerNos)
                ->count();
        }

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

    public function getEstimatedTimes($start_dt, $estimated_time){
        $estimated_times = explode(':', $estimated_time);
        return date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($start_dt . ' +'. ((int)$estimated_times[0]) .'hours')) . ' +' . ((int)$estimated_times[1]) .'minutes'));
    }
    function get_week_number($time) { $w = date('w', mktime(0,0,0, date('n',$time), 1, date('Y',$time))); return ceil(($w + date('j',$time) -1) / 7); }

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
        // 같은 매장, 같은 디자이너, 시간 중복 확인
        {
            $result['reservate'] = [];
            // 12시 ~ 15시 예약을 잡으려 할때 start_dt + estimated_time
            // 오류 1) 기존 x ~ 13시 2) 기존 14시 ~ x
            $reservateDate = date("Y-m-d", strtotime($start_dt));
            $reservationInfo = DB::table("reservation")->where([
                ['partner_seqno', '=', $partner_seqno],
                ['store_seqno', '=', $store_seqno],
                ['manager_seqno', '=', $manager_seqno],
                ['start_dt', '>', $reservateDate . ' 00:00:00'],
                ['start_dt', '<', $reservateDate . ' 23:59:59'],
                ['deleted', '=', 'N']
            ])->get();
            $storeInfo = DB::table("store")->where([
                ['partner_seqno', '=', $partner_seqno],
                ['seqno', '=', $store_seqno],
                ['deleted', '=', 'N']
            ])->first();

            $resStartTime = strtotime($start_dt);
            $resEndTime = strtotime($this->getEstimatedTimes($start_dt, $estimated_time));
            $result['reservate']['resStartTime'] = $resStartTime;
            $result['reservate']['resEndTime'] = $resEndTime;
            $result['reservate']['reservationInfo'] = $reservationInfo;

            // 매장 정보 확인
            if(!empty($storeInfo)) {
                // due_day 에 있는 요일인가
                if(!empty($storeInfo->due_day) && strpos($storeInfo->due_day, date('w', strtotime($reservateDate))) === false) {
                    $result['ment'] = '해당 요일은 매장 업무 요일이 아닙니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 업무 시간에 예약을 하는 것인가
                if(!empty($storeInfo->start_dt) && !empty($storeInfo->end_dt)) {
                    $due_start_dt = strtotime($reservateDate . ' '. $storeInfo->start_dt . ':00');
                    $due_end_dt = strtotime($reservateDate . ' '. $storeInfo->end_dt . ':00');

                    if($due_start_dt > $resStartTime || $resEndTime > $due_end_dt) {
                        $result['ment'] = '예약하시려는 시간이 매장의 업무 시간을 초과합니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                }

                // 점심 시간을 사용하는 매장의 경우
                if($storeInfo->allow_lunch_reservate == 'N') {
                    $lunch_start_dt = strtotime($reservateDate . ' '. $storeInfo->lunch_start_dt . ':00');
                    $lunch_end_dt = strtotime($reservateDate . ' '. $storeInfo->lunch_end_dt . ':00');

                    if($lunch_start_dt <= $resStartTime && $resStartTime <= $lunch_end_dt) {
                        $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    if($lunch_start_dt <= $resEndTime && $resEndTime <= $lunch_end_dt) {
                        $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    if(($lunch_start_dt >= $resStartTime && $resEndTime >= $lunch_end_dt)
                        || ($resStartTime >= $lunch_start_dt && $lunch_end_dt >= $resEndTime)) {
                            $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                }
                // 특수 휴무 사용할 경우
                if(!empty($storeInfo->allow_ext_holiday) && $storeInfo->allow_ext_holiday == 'Y') {
                    // 특수 요일 휴무일에 예약하는 경우
                    if(!empty($storeInfo->ext_holiday_weekly) && $storeInfo->ext_holiday_weekly == date('w', strtotime($reservateDate))) {
                        $result['ment'] = '해당 요일은 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    // 특수 주차 요일 휴무일에 예약하는 경우 
                    if(!empty($storeInfo->ext_holiday_weekend_day)) {
                        $holidayInfo = explode('-', $storeInfo->ext_holiday_weekend_day);
                        $weeks = ['일','월','화','수','목','금','토'];
                        if($holidayInfo[0] == get_week_number(strtotime($reservateDate)) && $holidayInfo[1] == date('w', strtotime($reservateDate))) {
                            $result['ment'] = '해당 업체의 매월 '.$holidayInfo[0].'번째 '.$weeks[$holidayInfo[1]].'요일은 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                            return $result;
                        }
                    }
                    // 지정일 휴무일에 예약하는 경우
                    if(!empty($storeInfo->ext_holiday_montly)) {
                        $holidays = explode(',', $storeInfo->ext_holiday_montly);
                        for($inx = 0; $inx < count($holidays); $inx++){
                            if(!empty($holidays[$inx]) && $holidays[$inx] == date('d', strtotime($reservateDate))) {
                                $result['ment'] = '해당 날자는 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                                return $result;
                            }
                        }
                    }
                }
            }

            for($inx = 0; $inx < count($reservationInfo); $inx++){
                $targetStartTime = strtotime($reservationInfo[$inx]->start_dt);
                $targetEndTime = strtotime($this->getEstimatedTimes($reservationInfo[$inx]->start_dt, $reservationInfo[$inx]->estimated_time));

                // 1) 기존 14시 ~ x, 10~12. 11~13
                if($targetStartTime <= $resStartTime && $resStartTime <= $targetEndTime) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 2) 기존 x ~ 13시
                if($targetStartTime <= $resEndTime && $resEndTime <= $targetEndTime) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 3) 10~12, 9~15
                if(($targetStartTime >= $resStartTime && $resEndTime >= $targetEndTime)
                    || ($resStartTime >= $targetStartTime && $targetEndTime >= $resEndTime)) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
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
        $user_name = $request->post('user_name');
        $user_phone = $request->post('user_phone');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;
        // 같은 매장, 같은 디자이너, 시간 중복 확인
        {
            $result['reservate'] = [];
            // 12시 ~ 15시 예약을 잡으려 할때 start_dt + estimated_time
            // 오류 1) 기존 x ~ 13시 2) 기존 14시 ~ x
            $reservateDate = date("Y-m-d", strtotime($start_dt));
            $reservationInfo = DB::table("reservation")->where([
                ['partner_seqno', '=', $partner_seqno],
                ['store_seqno', '=', $store_seqno],
                ['manager_seqno', '=', $manager_seqno],
                ['start_dt', '>', $reservateDate . ' 00:00:00'],
                ['start_dt', '<', $reservateDate . ' 23:59:59'],
                ['deleted', '=', 'N']
            ])->get();
            $storeInfo = DB::table("store")->where([
                ['partner_seqno', '=', $partner_seqno],
                ['seqno', '=', $store_seqno],
                ['deleted', '=', 'N']
            ])->first();

            $resStartTime = strtotime($start_dt);
            $resEndTime = strtotime($this->getEstimatedTimes($start_dt, $estimated_time));
            $result['reservate']['resStartTime'] = $resStartTime;
            $result['reservate']['resEndTime'] = $resEndTime;
            $result['reservate']['reservationInfo'] = $reservationInfo;

            // 매장 정보 확인
            if(!empty($storeInfo)) {
                // due_day 에 있는 요일인가
                if(!empty($storeInfo->due_day) && strpos($storeInfo->due_day, date('w', strtotime($reservateDate))) === false) {
                    $result['ment'] = '해당 요일은 매장 업무 요일이 아닙니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 업무 시간에 예약을 하는 것인가
                if(!empty($storeInfo->start_dt) && !empty($storeInfo->end_dt)) {
                    $due_start_dt = strtotime($reservateDate . ' '. $storeInfo->start_dt . ':00');
                    $due_end_dt = strtotime($reservateDate . ' '. $storeInfo->end_dt . ':00');

                    if($due_start_dt > $resStartTime || $resEndTime > $due_end_dt) {
                        $result['ment'] = '예약하시려는 시간이 매장의 업무 시간을 초과합니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                }

                // 점심 시간을 사용하는 매장의 경우
                if($storeInfo->allow_lunch_reservate == 'N') {
                    $lunch_start_dt = strtotime($reservateDate . ' '. $storeInfo->lunch_start_dt . ':00');
                    $lunch_end_dt = strtotime($reservateDate . ' '. $storeInfo->lunch_end_dt . ':00');

                    if($lunch_start_dt <= $resStartTime && $resStartTime <= $lunch_end_dt) {
                        $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    if($lunch_start_dt <= $resEndTime && $resEndTime <= $lunch_end_dt) {
                        $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    if(($lunch_start_dt >= $resStartTime && $resEndTime >= $lunch_end_dt)
                        || ($resStartTime >= $lunch_start_dt && $lunch_end_dt >= $resEndTime)) {
                            $result['ment'] = '해당 시간은 업체 점심시간입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                }
                // 특수 휴무 사용할 경우
                if(!empty($storeInfo->allow_ext_holiday) && $storeInfo->allow_ext_holiday == 'Y') {
                    // 특수 요일 휴무일에 예약하는 경우
                    if(!empty($storeInfo->ext_holiday_weekly) && $storeInfo->ext_holiday_weekly == date('w', strtotime($reservateDate))) {
                        $result['ment'] = '해당 요일은 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                        return $result;
                    }
                    // 특수 주차 요일 휴무일에 예약하는 경우 
                    if(!empty($storeInfo->ext_holiday_weekend_day)) {
                        $holidayInfo = explode('-', $storeInfo->ext_holiday_weekend_day);
                        $weeks = ['일','월','화','수','목','금','토'];
                        if($holidayInfo[0] == get_week_number(strtotime($reservateDate)) && $holidayInfo[1] == date('w', strtotime($reservateDate))) {
                            $result['ment'] = '해당 업체의 매월 '.$holidayInfo[0].'번째 '.$weeks[$holidayInfo[1]].'요일은 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                            return $result;
                        }
                    }
                    // 지정일 휴무일에 예약하는 경우
                    if(!empty($storeInfo->ext_holiday_montly)) {
                        $holidays = explode(',', $storeInfo->ext_holiday_montly);
                        for($inx = 0; $inx < count($holidays); $inx++){
                            if(!empty($holidays[$inx]) && $holidays[$inx] == date('d', strtotime($reservateDate))) {
                                $result['ment'] = '해당 날자는 업체 휴무일입니다. 다른 시간에 예약하여 주세요.';
                                return $result;
                            }
                        }
                    }
                }
            }

            for($inx = 0; $inx < count($reservationInfo); $inx++){
                if($reservationInfo[$inx]->seqno == $id) {
                    continue;
                }
                $targetStartTime = strtotime($reservationInfo[$inx]->start_dt);
                $targetEndTime = strtotime($this->getEstimatedTimes($reservationInfo[$inx]->start_dt, $reservationInfo[$inx]->estimated_time));

                // 1) 기존 14시 ~ x, 10~12. 11~13
                if($targetStartTime <= $resStartTime && $resStartTime <= $targetEndTime) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 2) 기존 x ~ 13시
                if($targetStartTime <= $resEndTime && $resEndTime <= $targetEndTime) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
                // 3) 10~12, 9~15
                if(($targetStartTime >= $resStartTime && $resEndTime >= $targetEndTime)
                    || ($resStartTime >= $targetStartTime && $targetEndTime >= $resEndTime)) {
                    $result['ment'] = '이미 해당 시간에는 예약이 있습니다. 다른 시간에 예약하여 주세요.';
                    return $result;
                }
            }
        }
        {
            $reservationInfo = DB::table("reservation")->where([
                ['seqno', '=', $id]
            ])->first();
            if(empty($user_name)) {
                $user_name = $reservationInfo->user_name;
            }
            if(empty($user_phone)) {
                $user_phone = $reservationInfo->user_phone;
            }
        }

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
