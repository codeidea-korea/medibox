<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function getListInStore(Request $request){
        $store_seqno = $request->get('store_seqno');
        $manager_seqno = $request->get('manager_seqno');
        $start_dt = $request->get('start_dt');
        $end_dt = $request->get('end_dt');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }
        if(! empty($manager_seqno) && $manager_seqno != ''){
            array_push($where, ['manager_seqno', '=', $manager_seqno]);
        }
        if(! empty($start_dt) && $start_dt != ''){
            array_push($where, ['holiday_dt', '>=', $start_dt]);
            array_push($where, ['holiday_dt', '<=', $end_dt]);
        }

        $contents = DB::table("holiday")->where($where)
            ->orderBy('create_dt', 'desc')
            ->get();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $store_seqno = $request->post('store_seqno', '0');
        $manager_seqno = $request->post('manager_seqno', '0');
        $holiday_dt = $request->post('holiday_dt', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('holiday')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'store_seqno' => $store_seqno
                , 'manager_seqno' => $manager_seqno
                , 'holiday_dt' => $holiday_dt
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
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

        DB::table('holiday')->where('seqno', '=', $id)->update(
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
