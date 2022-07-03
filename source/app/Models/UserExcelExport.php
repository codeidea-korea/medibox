<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserExcelExport implements FromArray
{
    public static $userInfos = [];

    public function array(): array
    {
        $num = 1;
        $sheet = [];

        // 헤더 세팅
        array_push($sheet, [
            '번호', '회원번호', '아이디', '이름', '회원가입일', '포인트', '통합정액권', '네일정액권', '발몽정액권', '포레스타정액권', '패키지', '메모'
        ]);
        // 내용 출력
        foreach(self::$userInfos as $user) {
            $packagePoint = empty($user['packageHistory']) ? 0 : $user['packageHistory']['point'];
            
            $user['point_val'] = '0';
            $user['package_val'] = '0';
            $user['integrated_val'] = '0';
            $user['nail_val'] = '0';
            $user['valmot_val'] = '0';
            $user['foresta_val'] = '0';
            $user['deepfocus_val'] = '0';
            $user['minishspa_val'] = '0';
            $user['minishtherapy_val'] = '0';
            
            foreach($user['points'] as $point){
                if(empty($point['point']) || $point['point'] < 1) continue;

                if($point['point_type'] == 'P') $user['point_val'] = $point['point'];
                if($point['point_type'] == 'K') $user['package_val'] = $point['point'];
                if($point['point_type'] == 'S1') $user['integrated_val'] = $point['point'];
                if($point['point_type'] == 'S2') $user['nail_val'] = $point['point'];
                if($point['point_type'] == 'S3') $user['valmot_val'] = $point['point'];
                if($point['point_type'] == 'S4') $user['foresta_val'] = $point['point'];
                if($point['point_type'] == 'S5') $user['deepfocus_val'] = $point['point'];
                if($point['point_type'] == 'S6') $user['minishspa_val'] = $point['point'];
                if($point['point_type'] == 'S7') $user['minishtherapy_val'] = $point['point'];
            }

            $create_dt = ($user['delete_yn'] == 'N') ? $user['create_dt'] : '탈퇴';

            array_push($sheet, [
                $num, $user['user_seqno'], $user['user_phone'], $user['user_name'], $create_dt,
                $user['point_val'], $user['integrated_val'], $user['nail_val'], $user['valmot_val'], $user['foresta_val'], $packagePoint,
                $user['memo']
            ]);
            $num = $num + 1;
        }

        return $sheet;
    }
}