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

// 제휴사 데이터 6개 강제 insert 쿼리 만들고 실행
// 제휴사 조회/목록 화면 만들기
    public function partners(Request $request){
        // 제휴사 목록
    }

// 매장 정보 등록/목록 화면 만들기


    public function myPoint(Request $request)
    {
        $user_seqno = $request->post('user_seqno'); // 대상 고객
        $point_type = $request->post('point_type', ''); // 

        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        if(empty($user_seqno)) {
            return $result;
        }

        $user = DB::table("user_info")->where([
            ['user_seqno', '=', $user_seqno],
            ['delete_yn', '=', 'N']
        ])->first();
        if(empty($user)) {
            return $result;
        }

        $where = [];
        array_push($where, ['user_seqno', '=', $user_seqno]);
        if(! empty($point_type) && $point_type != ''){
            array_push($where, ['point_type', '=', $point_type]);
        }
        $point = DB::table('user_point')->where($where)->get();

        $package = DB::table("user_package")->where([
            ['user_seqno', '=', $user_seqno],
            ['deleted', '=', 'N']
        ])->first();

        $result['ment'] = '성공';
        $result['data'] = $point;
        $result['package'] = $package;
        $result['result'] = true;

        return $result;
    }
}
