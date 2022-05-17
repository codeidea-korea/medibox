<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class AdminHistoryController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $menu = $request->get('menu');
        $action = $request->get('action');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(! empty($menu) && $menu != ''){
            array_push($where, ['menu', 'like', '%'.$menu.'%']);
        }
        if(! empty($action) && $action != ''){
            array_push($where, ['action', 'like', '%'.$action.'%']);
        }

        $contents = DB::table("admin_action_history")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("admin_action_history")->where($where)
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $admin_id = $request->post('admin_id');
        $menu = $request->post('menu');
        $action = $request->post('action');
        $params = $request->post('params');        
        $request_ip = $request->ip();

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('admin_action_history')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'admin_id' => $admin_id
                , 'menu' => $menu
                , 'action' => $action
                , 'request_ip' => $request_ip
                , 'params' => $params
                , 'create_dt' => date('Y-m-d H:i:s')
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }
}
