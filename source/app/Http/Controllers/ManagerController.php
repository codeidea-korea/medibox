<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function getListInStore(Request $request){
        $partner_seqno = $request->get('partner_seqno');
        $store_seqno = $request->get('store_seqno');
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 100);

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['partner_seqno', '=', $partner_seqno]);
        }

        $contents = DB::table("store_manager")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("store_manager")->where($where)
            ->count();

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

        $contents = DB::table("store_manager")->where([
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
        $store_seqno = $request->post('store_seqno', '0');
        
        $manager_type = $request->post('manager_type', '');
        $name = $request->post('name', '');
        $use_img = $request->post('use_img', '');

        $img1 = $request->post('img1');
        $img2 = $request->post('img2');
        $img3 = $request->post('img3');
        $img4 = $request->post('img4');
        $img5 = $request->post('img5');

        $memo = $request->post('memo', '');
        $start_dt = $request->post('start_dt', '');
        $end_dt = $request->post('end_dt', '');
        $join_dt = $request->post('join_dt', '');
        $unjoin_dt = $request->post('unjoin_dt', '');
        
        $holiday_type = $request->post('holiday_type', '');
        $visible = $request->post('visible', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('store_manager')->insertGetId(
            [
                'admin_seqno' => $admin_seqno

                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno

                , 'manager_type' => $manager_type
                , 'name' => $name
                , 'use_img' => $use_img

                , 'img1' => $img1
                , 'img2' => $img2
                , 'img3' => $img3
                , 'img4' => $img4
                , 'img5' => $img5

                , 'memo' => $memo
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'join_dt' => $join_dt
                , 'unjoin_dt' => $unjoin_dt
                , 'holiday_type' => $holiday_type
                , 'visible' => $visible

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
        
        $manager_type = $request->post('manager_type', '');
        $name = $request->post('name', '');
        $use_img = $request->post('use_img', '');

        $img1 = $request->post('img1');
        $img2 = $request->post('img2');
        $img3 = $request->post('img3');
        $img4 = $request->post('img4');
        $img5 = $request->post('img5');

        $memo = $request->post('memo', '');
        $start_dt = $request->post('start_dt', '');
        $end_dt = $request->post('end_dt', '');
        $join_dt = $request->post('join_dt', '');
        $unjoin_dt = $request->post('unjoin_dt', '');
        
        $holiday_type = $request->post('holiday_type', '');
        $visible = $request->post('visible', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('store_manager')->where('seqno', '=', $id)->update(
            [
                'admin_seqno' => $admin_seqno

                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno

                , 'manager_type' => $manager_type
                , 'name' => $name
                , 'use_img' => $use_img

                , 'img1' => $img1
                , 'img2' => $img2
                , 'img3' => $img3
                , 'img4' => $img4
                , 'img5' => $img5

                , 'memo' => $memo
                , 'start_dt' => $start_dt
                , 'end_dt' => $end_dt
                , 'join_dt' => $join_dt
                , 'unjoin_dt' => $unjoin_dt
                , 'holiday_type' => $holiday_type
                , 'visible' => $visible

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

        DB::table('store_manager')->where('seqno', '=', $id)->update(
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
