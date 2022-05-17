<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $offline_type = $request->get('offline_type');
        $type_name = $request->get('type_name');
        $revers_type_condition = $request->get('revers_type_condition', 'N');
        $point_type = $request->get('point_type');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['delete_yn', '=', 'N']);
        if(! empty($offline_type) && $offline_type != ''){
            array_push($where, ['offline_type', '=', $offline_type]);
        }
        if(! empty($type_name) && $type_name != ''){
            array_push($where, ['type_name', 'like', '%'.$type_name.'%']);
        }
        if(! empty($point_type) && $point_type != ''){
            if($revers_type_condition == 'Y') {
                array_push($where, ['point_type', '!=', $point_type]);
            } else {
                array_push($where, ['point_type', '=', $point_type]);
            }
        }
        
        $contents = DB::table("product")->where($where)
//            ->orderBy('orders', 'desc')
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("product")->where($where)
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

        $contents = DB::table("product")->where([
            ['product_seqno', '=', $id],
            ['delete_yn', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $point_type = $request->post('point_type');
        $type_name = $request->post('type_name');
        
        $service_name = $request->post('service_name');
        $service_sub_name = $request->post('service_sub_name');
        $price = $request->post('price');
        $offline_type = $request->post('offline_type');
        $step_type = $request->post('step_type');
        $info = $request->post('info');
        $add_rate = $request->post('add_rate');
        $date_use = $request->post('date_use');
        $return_point = $request->post('return_point');

        $ordered = $request->post('ordered', '1');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('product')->insertGetId(
            [
                'point_type' => $point_type
                , 'type_name' => $type_name
                , 'service_name' => $service_name
                , 'service_sub_name' => $service_sub_name
                , 'price' => $price
                , 'offline_type' => $offline_type
                , 'step_type' => $step_type
                , 'return_point' => $return_point
                , 'orders' => $ordered
                , 'info' => $info
                , 'add_rate' => $add_rate
                , 'date_use' => $date_use
                , 'delete_yn' => 'N'
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
        $point_type = $request->post('point_type');
        $type_name = $request->post('type_name');
        
        $service_name = $request->post('service_name');
        $service_sub_name = $request->post('service_sub_name');
        $price = $request->post('price');
        $offline_type = $request->post('offline_type');
        $step_type = $request->post('step_type');
        $return_point = $request->post('return_point');
        $info = $request->post('info');
        $add_rate = $request->post('add_rate');
        $date_use = $request->post('date_use');

        $ordered = $request->post('ordered', '1');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('product')->where([
            ['product_seqno', '=', $id]
        ])->update(
            [
                'point_type' => $point_type
                , 'type_name' => $type_name
                , 'service_name' => $service_name
                , 'service_sub_name' => $service_sub_name
                , 'price' => $price
                , 'offline_type' => $offline_type
                , 'step_type' => $step_type
                , 'return_point' => $return_point
                , 'orders' => $ordered
                , 'info' => $info
                , 'add_rate' => $add_rate
                , 'date_use' => $date_use
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

        DB::table('product')->where('product_seqno', '=', $id)->update(
            [
                'delete_yn' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
}
