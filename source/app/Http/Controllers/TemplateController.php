<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);

        $contents = DB::table("template")->where($where)
            ->orderBy('create_dt', 'asc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("template")->where($where)
            ->count();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['count'] = $count;
        $result['result'] = true;

        return $result;
    }

    public function choose(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $id = $request->post('id', '1');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('template')->where([
            ['deleted', '=', 'N']
        ])->update(
            [
                'choosed' => 'N'
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('template')->where([
            ['deleted', '=', 'N'],
            ['seqno', '=', $id]
        ])->update(
            [
                'choosed' => 'Y'
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function choosen(Request $request)
    {
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $contents = DB::table("template")->where([
            ['choosed', '=', 'Y'],
            ['deleted', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }
}
