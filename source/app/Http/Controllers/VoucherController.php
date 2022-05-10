<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $name = $request->get('name');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        
        $contents = DB::table("product_voucher")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("product_voucher")->where($where)
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function find(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $contents = DB::table("product_voucher")->where([
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
        $name = $request->post('name');
        
        $context = $request->post('context');
        $unit_count = $request->post('unit_count', 0);
        $date_use = $request->post('date_use', 0);
        $use_partner = $request->post('use_partner', 'N');
        $partner_seqno = $request->post('partner_seqno');
        $store_seqno = $request->post('store_seqno');
        $service_seqno = $request->post('service_seqno');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        if($use_partner == 'Y') {
            if(empty($partner_seqno) || empty($store_seqno) || empty($service_seqno)) {
                $result['ment'] = '제휴사 서비스 연결을 선택하시면 바우처의 제휴사, 매장, 서비스를 연결해주셔야 합니다.';
                return $result;
            }
        }

        $id = DB::table('product_voucher')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'context' => $context
                , 'unit_count' => $unit_count
                , 'date_use' => $date_use
                , 'use_partner' => $use_partner
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'service_seqno' => $service_seqno
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
        $name = $request->post('name');
        
        $context = $request->post('context');
        $unit_count = $request->post('unit_count', 0);
        $date_use = $request->post('date_use', 0);
        $use_partner = $request->post('use_partner', 'N');
        $partner_seqno = $request->post('partner_seqno');
        $store_seqno = $request->post('store_seqno');
        $service_seqno = $request->post('service_seqno');

        if($use_partner == 'Y') {
            if(empty($partner_seqno) || empty($store_seqno) || empty($service_seqno)) {
                $result['ment'] = '제휴사 서비스 연결을 선택하시면 바우처의 제휴사, 매장, 서비스를 연결해주셔야 합니다.';
                return $result;
            }
        }

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('product_voucher')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'context' => $context
                , 'unit_count' => $unit_count
                , 'date_use' => $date_use
                , 'use_partner' => $use_partner
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'service_seqno' => $service_seqno
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

        DB::table('product_voucher')->where('seqno', '=', $id)->update(
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
