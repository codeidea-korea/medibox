<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function getListInStore(Request $request){
        $partner_seqno = $request->get('partner_seqno');
        $store_seqno = $request->get('store_seqno');
        $manager_type = $request->get('manager_type');        
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
        if(! empty($manager_type) && $manager_type != ''){
            array_push($where, ['manager_type', '=', $manager_type]);
        }

        $contents = DB::table("store_service")->where($where)
//            ->orderBy('store_seqno', 'desc')
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("store_service")->where($where)
            ->count();

        for($inx = 0; $inx < count($contents); $inx++){
            $partnerInfo = DB::table("partner")
                ->where([['seqno', '=', $contents[$inx]->partner_seqno]])->first();
            $storeInfo = DB::table("store")
                ->where([['seqno', '=', $contents[$inx]->store_seqno]])->first();
                
            $contents[$inx]->partnerInfo = $partnerInfo;
            $contents[$inx]->storeInfo = $storeInfo;
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

        $contents = DB::table("store_service")->where([
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
        $estimated_time = $request->post('estimated_time', '');
        $dept = $request->post('dept', '');
        
        $price = $request->post('price');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('store_service')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'manager_type' => $manager_type
                , 'name' => $name

                , 'estimated_time' => $estimated_time
                , 'dept' => $dept
                , 'price' => $price

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
        $estimated_time = $request->post('estimated_time', '');
        $price = $request->post('price');
        
        $holiday_type = $request->post('holiday_type', '');
        $visible = $request->post('visible', '');
        $dept = $request->post('dept', '');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('store_service')->where('seqno', '=', $id)->update(
            [
                'admin_seqno' => $admin_seqno
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'manager_type' => $manager_type
                , 'dept' => $dept
                , 'name' => $name

                , 'estimated_time' => $estimated_time
                , 'price' => $price

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

        DB::table('store_service')->where('seqno', '=', $id)->update(
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
