<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserExcelExport;

class ExcelController extends Controller
{
    public function getUsers(Request $request)
    {
        $search_field = $request->get('search');
        $start_day = $request->get('start_day');
        $end_day = $request->get('end_day');

        $where = [];
        if (!empty($start_day) && $start_day != '') {
            array_push($where, ['create_dt', '>=', $start_day]);
        }
        if (!empty($end_day) && $end_day != '') {
            array_push($where, ['create_dt', '<=', $end_day]);
        }

        $users;
        if (!empty($search_field) && $search_field != '') {
            $users = DB::table("user_info")->where($where)
                ->where(function($query) use ($search_field){
                    $query->orWhere('user_phone', 'like', '%'.$search_field.'%')
                        ->orWhere('user_name', 'like', '%'.$search_field.'%');
                })
                ->orderBy('create_dt', 'desc')
                ->get();
        } else {
            $users = DB::table("user_info")->where($where)
                ->orderBy('create_dt', 'desc')
                ->get();
        }

        // 매칭되는 정액권, 포인트를 리턴
        for($inx = 0; $inx < count($users); $inx++){
            $points = DB::table("user_point")
                ->where([['user_seqno', '=', $users[$inx]->user_seqno]])->get();
            $users[$inx]->points = $points;

            $packageHistory = DB::table("user_package")->where([
                ['user_seqno', '=', $users[$inx]->user_seqno],
                ['deleted', '=', 'N']
            ])->first();
            $users[$inx]->packageHistory = $packageHistory;
        }

        UserExcelExport::$userInfos = json_decode( json_encode($users), true);
        return Excel::download(new UserExcelExport, 'MEDIBOX-회원 현황 ('.date('y-m-d h:i:s').').xlsx');
    }
}
