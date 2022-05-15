<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $id = $request->get('id');
        $admin_type = $request->get('admin_type');
        $partner_seqno = $request->get('partner_seqno');
        $store_seqno = $request->get('store_seqno');

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        array_push($where, ['delete_yn', '=', 'N']);
        if(! empty($id) && $id != ''){
            array_push($where, ['admin_id', '=', $id]);
        }
        if(! empty($admin_type) && $admin_type != ''){
            array_push($where, ['admin_type', '=', $admin_type]);

            if($admin_type == 'P' || $admin_type == 'S'){
            }
        }
        if(! empty($partner_seqno) && $partner_seqno != ''){
            array_push($where, ['level_partner_grp_seqno', 'like', '%'.$partner_seqno.'%']);
        }
        if(! empty($store_seqno) && $store_seqno != ''){
            array_push($where, ['store_seqno', '=', $store_seqno]);
        }

        $contents = DB::table("admin_info")->where($where)
            ->leftJoin('partner', function ($join) {
                $join->on('admin_info.partner_seqno', '=', 'partner.seqno');
            })
            ->leftJoin('store', function ($join) {
                $join->on('admin_info.store_seqno', '=', 'store.seqno');
            })
            ->select(DB::raw('admin_info.*, partner.cop_name as partner_name, store.name as store_name'))
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("admin_info")->where($where)
            ->count();

        for($inx = 0; $inx < count($contents); $inx++){
            $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $contents[$inx]->level_partner_grp_seqno)));

            $partners = DB::table("partner")
                ->where([['deleted', '=', 'N']])
                ->whereIn('seqno', $partnerNos)
                ->get();
                
            $contents[$inx]->partners = $partners;
        }

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

        $contents = DB::table("admin_info")
        ->leftJoin('partner', function ($join) {
            $join->on('admin_info.partner_seqno', '=', 'partner.seqno');
        })
        ->leftJoin('store', function ($join) {
            $join->on('admin_info.store_seqno', '=', 'store.seqno');
        })
        ->where([
            ['admin_info.admin_seqno', '=', $id],
            ['delete_yn', '=', 'N']
        ])
        ->select(DB::raw('admin_info.*, partner.cop_name as partner_name, partner.seqno as partner_seqno,'
            .' store.name as store_name, store.seqno as store_seqno'))->first();

        $partnerNos = explode(',', str_replace('|', '', str_replace('||' , ',', $contents->level_partner_grp_seqno)));
        $partners = DB::table("partner")
            ->where([['deleted', '=', 'N']])
            ->whereIn('seqno', $partnerNos)
            ->get();
        $contents->partners = $partners;

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function add(Request $request)
    {
        $admin_id = $request->post('admin_id');
        $admin_pw = $request->post('admin_pw');
        $admin_name = $request->post('admin_name');
        $admin_type = $request->post('admin_type');
        $partner_seqno = $request->post('partner_seqno', 0);
        $store_seqno = $request->post('store_seqno', 0);
        $level_partner_grp_seqno = $request->post('level_partner_grp_seqno');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $admin_info = DB::table("admin_info")->where([
            ['admin_id', '=', $admin_id],
            ['delete_yn', '=', 'N']
        ])->first();

        if(!empty($admin_info)) {
            $result['ment'] = '아이디가 이미 존재합니다. 다른 아이디로 시도해주세요.';
            return $result;
        }

        $id = DB::table('admin_info')->insertGetId(
            [
                'admin_id' => $admin_id
                , 'admin_pw' => $admin_pw
                , 'admin_name' => $admin_name
                , 'admin_type' => $admin_type
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'level_partner_grp_seqno' => $level_partner_grp_seqno
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
        $admin_id = $request->post('admin_id');
        $admin_pw = $request->post('admin_pw');
        $admin_old_pw = $request->post('admin_old_pw');
        $admin_name = $request->post('admin_name');
        $admin_type = $request->post('admin_type');
        $partner_seqno = $request->post('partner_seqno', 0);
        $store_seqno = $request->post('store_seqno', 0);
        $level_partner_grp_seqno = $request->post('level_partner_grp_seqno');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $admin_info = DB::table("admin_info")->where([
            ['admin_id', '=', $admin_id],
            ['delete_yn', '=', 'N']
        ])->first();

        if(empty($admin_info)) {
            $result['ment'] = '탈퇴되었거나 존재하지 않는 아이디입니다.';
            return $result;
        }
        if($admin_info->admin_pw != $admin_old_pw) {
            $result['ment'] = '비밀번호가 일치하지 않습니다.';
            return $result;
        }

        DB::table('admin_info')->where('admin_seqno', '=', $id)->update(
            [
                'admin_pw' => $admin_pw
                , 'admin_name' => $admin_name
                , 'admin_type' => $admin_type
                , 'partner_seqno' => $partner_seqno
                , 'store_seqno' => $store_seqno
                , 'level_partner_grp_seqno' => $level_partner_grp_seqno
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

        DB::table('admin_info')->where('admin_seqno', '=', $id)->update(
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
