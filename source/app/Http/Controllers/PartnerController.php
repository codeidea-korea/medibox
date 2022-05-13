<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function getAll(Request $request){
        $id = $request->get('id');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($id) && $id != ''){
            array_push($where, ['seqno', '=', $id]);
        }

        $contents = DB::table("partner")->where($where)
            ->orderBy('create_dt', 'desc')
            ->get();
        $count = DB::table("partner")->where($where)
            ->count();

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

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['deleted', '=', 'N']);
        if(! empty($name) && $name != ''){
            array_push($where, ['cop_name', '=', $name]);
        }

        $contents = DB::table("partner")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("partner")->where($where)
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

        $contents = DB::table("partner")->where([
            ['seqno', '=', $id],
            ['deleted', '=', 'N']
        ])->first();

        $adminInfo = DB::table('admin_info')->where([
            ['delete_yn', '=', 'N'],
            ['partner_seqno', '=', $id]
        ])->first();

        $contents->adminInfo = $adminInfo;

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');

        // 회사명 cop_name
        $cop_name = $request->post('cop_name', '');
        $cop_no = $request->post('cop_no', '');
        $cop_file = $request->post('cop_file', '');
        $cop_phone = $request->post('cop_phone', '');
        $online_order_business_no = $request->post('online_order_business_no', '');
        $online_order_business_file = $request->post('online_order_business_file', '');
        
        $director_name = $request->post('director_name', '');
        $director_phone = $request->post('director_phone', '');
        $director_email = $request->post('director_email', '');
        
        $admin_id = $request->post('admin_id');
        $admin_pw = $request->post('admin_pw');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $adminInfo = DB::table('admin_info')->where('admin_id', '=', $admin_id)->first();
        if(!empty($adminInfo)) {
            $result['ment'] = '이미 존재하는 관리자 아이디입니다. 다른 아이디로 다시 시도해주세요.';
            return $result;
        }

        // 먼저 어드민을 등록
        $director_seqno = DB::table('admin_info')->insertGetId(
            [
                'admin_id' => $admin_id
                , 'admin_pw' => $admin_pw
                , 'admin_name' => $director_name
                , 'partner_seqno' => $partner_seqno
                , 'delete_yn' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'admin_seqno'
        );

        $partner_seqno = DB::table('partner')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'cop_name' => $cop_name

                , 'cop_no' => $cop_no
                , 'cop_file' => $cop_file
                , 'cop_phone' => $cop_phone
                , 'online_order_business_no' => $online_order_business_no
                , 'online_order_business_file' => $online_order_business_file

                , 'director_name' => $director_name
                , 'director_phone' => $director_phone
                , 'director_email' => $director_email
                , 'director_seqno' => $director_seqno

                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
        );

        DB::table('admin_info')->where('admin_seqno', '=', $director_seqno)->update(
            [
                'partner_seqno' => $partner_seqno
            ]
        );

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modify(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');

        // 회사명 cop_name
        $cop_name = $request->post('cop_name', '');
        $cop_no = $request->post('cop_no', '');
        $cop_file = $request->post('cop_file', '');
        $cop_phone = $request->post('cop_phone', '');
        $online_order_business_no = $request->post('online_order_business_no', '');
        $online_order_business_file = $request->post('online_order_business_file', '');
        
        $director_name = $request->post('director_name', '');
        $director_phone = $request->post('director_phone', '');
        $director_email = $request->post('director_email', '');
        
        $admin_id = $request->post('admin_id');
        $admin_pw = $request->post('admin_pw');
        $admin_new_pw = $request->post('admin_new_pw');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $adminInfo = DB::table('admin_info')->where([
            ['admin_id', '=', $admin_id],
            ['partner_seqno', '=', $id]
        ])->first();
        if(empty($adminInfo)) {
            if(!empty($admin_id))
            $director_seqno = DB::table('admin_info')->insertGetId(
                [
                    'admin_id' => $admin_id
                    , 'admin_pw' => $admin_pw
                    , 'admin_name' => $director_name
                    , 'partner_seqno' => $id
                    , 'delete_yn' => 'N'
                    , 'create_dt' => date('Y-m-d H:i:s')
                    , 'update_dt' => date('Y-m-d H:i:s') 
                ], 'admin_seqno'
            );
        } else {
            if(!empty($admin_new_pw) && $admin_new_pw != '') {
                DB::table('admin_info')->where('admin_id', '=', $admin_id)->update(
                    [
                        'admin_pw' => $admin_new_pw
                        , 'admin_name' => $director_name
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        DB::table('partner')->where('seqno', '=', $id)->update(
            [
                'admin_seqno' => $admin_seqno
                , 'cop_name' => $cop_name

                , 'cop_no' => $cop_no
                , 'cop_file' => $cop_file
                , 'cop_phone' => $cop_phone
                , 'online_order_business_no' => $online_order_business_no
                , 'online_order_business_file' => $online_order_business_file

                , 'director_name' => $director_name
                , 'director_phone' => $director_phone
                , 'director_email' => $director_email

                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('admin_info')->where('admin_id', '=', $admin_id)->update(
            [
                'partner_seqno' => $id
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

        DB::table('partner')->where('seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('admin_info')->where('partner_seqno', '=', $id)->update(
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
