<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function list(Request $request)
    {
        $pageNo = $request->get('pageNo', 1);
        $pageSize = $request->get('pageSize', 10);
        $name = $request->get('name');
        $include_discontinued = $request->get('include_discontinued', 'N');
        
        $result = [];
        $result['ment'] = '조회 실패';
        $result['result'] = false;

        $where = [];
        if(empty($include_discontinued) || $include_discontinued == 'N') {
            array_push($where, ['deleted', '=', 'N']);
        }
        if(! empty($name) && $name != ''){
            array_push($where, ['name', 'like', '%'.$name.'%']);
        }
        
        $contents = DB::table("product_membership")->where($where)
            ->orderBy('create_dt', 'desc')
            ->offset(($pageSize * ($pageNo-1)))->limit($pageSize)
            ->get();
        $count = DB::table("product_membership")->where($where)
            ->count();

        for($inx = 0; $inx < count($contents); $inx++){
            $services = DB::table("membership_service_grp")
                ->join('store_service', 'membership_service_grp.service_seqno', '=', 'store_service.seqno')
                ->where([
                    ['membership_service_grp.membership_seqno', '=', $contents[$inx]->seqno],
                    ['membership_service_grp.deleted', '=', 'N']
                ])
                ->orderBy('membership_service_grp.create_dt', 'desc')
                ->get();
            $vouchers = DB::table("membership_etc_voucher_grp")
                ->join('product_voucher', 'membership_etc_voucher_grp.etc_voucher_seqno', '=', 'product_voucher.seqno')
                ->where([
                    ['membership_etc_voucher_grp.membership_seqno', '=', $contents[$inx]->seqno],
                    ['membership_etc_voucher_grp.deleted', '=', 'N']
                ])
                ->orderBy('membership_etc_voucher_grp.create_dt', 'desc')
                ->get();
            $coupons = DB::table("membership_coupon_grp")
                ->join('coupon', 'membership_coupon_grp.coupon_seqno', '=', 'coupon.seqno')
                ->where([
                    ['membership_coupon_grp.membership_seqno', '=', $contents[$inx]->seqno],
                    ['membership_coupon_grp.deleted', '=', 'N']
                ])
                ->orderBy('membership_coupon_grp.create_dt', 'desc')
                ->get();

            $contents[$inx]->services = $services;

            for($jnx = 0; $jnx < count($services); $jnx++){
                $partnerInfo = DB::table("partner")
                    ->where([
                        ['seqno', '=', $services[$jnx]->partner_seqno],
                        ['deleted', '=', 'N']
                    ])
                    ->first();
                $storeInfo = DB::table("store")
                    ->where([
                        ['seqno', '=', $services[$jnx]->store_seqno],
                        ['deleted', '=', 'N']
                    ])
                    ->first();
                $contents[$inx]->services[$jnx]->partnerInfo = $partnerInfo;
                $contents[$inx]->services[$jnx]->storeInfo = $storeInfo;
            }

            $contents[$inx]->vouchers = $vouchers;
            $contents[$inx]->coupons = $coupons;
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

        $contents = DB::table("product_membership")->where([
            ['seqno', '=', $id]
        ])->first();
        
        $services = DB::table("membership_service_grp")
            ->leftJoin('store_service', 'membership_service_grp.service_seqno', '=', 'store_service.seqno')
            ->where([
                ['membership_service_grp.membership_seqno', '=', $contents->seqno],
                ['membership_service_grp.deleted', '=', 'N']
            ])
            ->orderBy('membership_service_grp.create_dt', 'desc')
            ->get();

        for($jnx = 0; $jnx < count($services); $jnx++){
            $partnerInfo = DB::table("partner")
                ->where([
                    ['seqno', '=', $services[$jnx]->partner_seqno],
                    ['deleted', '=', 'N']
                ])
                ->first();
            $storeInfo = DB::table("store")
                ->where([
                    ['seqno', '=', $services[$jnx]->store_seqno],
                    ['deleted', '=', 'N']
                ])
                ->first();
            $services[$jnx]->partnerInfo = $partnerInfo;
            $services[$jnx]->storeInfo = $storeInfo;
        }

        $vouchers = DB::table("membership_etc_voucher_grp")
            ->leftJoin('product_voucher', 'membership_etc_voucher_grp.etc_voucher_seqno', '=', 'product_voucher.seqno')
            ->where([
                ['membership_etc_voucher_grp.membership_seqno', '=', $contents->seqno],
                ['membership_etc_voucher_grp.deleted', '=', 'N']
            ])
            ->orderBy('membership_etc_voucher_grp.create_dt', 'desc')
            ->get();
        $coupons = DB::table("membership_coupon_grp")
            ->leftJoin('coupon', 'membership_coupon_grp.coupon_seqno', '=', 'coupon.seqno')
            ->where([
                ['membership_coupon_grp.membership_seqno', '=', $contents->seqno],
                ['membership_coupon_grp.deleted', '=', 'N']
            ])
            ->orderBy('membership_coupon_grp.create_dt', 'desc')
            ->get();

        $contents->services = $services;
        $contents->vouchers = $vouchers;
        $contents->coupons = $coupons;

        $result['ment'] = '성공';
        $result['data'] = $contents;
        $result['result'] = true;

        return $result;
    }

    public function generateGroup($id, $services, $vouchers, $coupons) {

        if(!empty($services) && $services != '') {
            // 서비스 조회해서 존재하면 그룹에 추가하기
            $serviceNos = explode(',', str_replace('|', '', str_replace('||' , ',', $services)));
            for($inx = 0; $inx < count($serviceNos); $inx++){
                $serviceInfo = explode('-', $serviceNos[$inx]);
                
                $contents = DB::table("store_service")->where([
                    ['seqno', '=', $serviceInfo[0]],
                    ['deleted', '=', 'N']
                ])->first();

                /*
                if(empty($contents)) {
                    $result['ment'] = '등록 실패 - 존재하지 않는 서비스입니다.';
                    return $result;
                }
                */

                DB::table('membership_service_grp')->insertGetId(
                    [
                        'membership_seqno' => $id
                        , 'service_seqno' => $serviceInfo[0]
                        , 'unit_count' => $serviceInfo[1] 
                        , 'deleted' => 'N'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        if(!empty($vouchers) && $vouchers != '') {
            // 바우처 조회해서 존재하면 그룹에 추가하기
            $voucherNos = explode(',', str_replace('|', '', str_replace('||' , ',', $vouchers)));
            for($inx = 0; $inx < count($voucherNos); $inx++){
                $contents = DB::table("product_voucher")->where([
                    ['seqno', '=', $voucherNos[$inx]],
                    ['deleted', '=', 'N']
                ])->first();

                /*
                if(empty($contents)) {
                    $result['ment'] = '등록 실패 - 존재하지 않는 바우처입니다.';
                    return $result;
                }
                */

                DB::table('membership_etc_voucher_grp')->insertGetId(
                    [
                        'membership_seqno' => $id
                        , 'etc_voucher_seqno' => $voucherNos[$inx]
                        , 'deleted' => 'N'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }

        if(!empty($coupons) && $coupons != '') {
            // 바우처 조회해서 존재하면 그룹에 추가하기
            $couponNos = explode(',', str_replace('|', '', str_replace('||' , ',', $coupons)));
            for($inx = 0; $inx < count($couponNos); $inx++){
                $contents = DB::table("coupon")->where([
                    ['seqno', '=', $couponNos[$inx]],
                    ['deleted', '=', 'N']
                ])->first();

                /*
                if(empty($contents)) {
                    $result['ment'] = '등록 실패 - 존재하지 않는 쿠폰입니다.';
                    return $result;
                }
                */

                DB::table('membership_coupon_grp')->insertGetId(
                    [
                        'membership_seqno' => $id
                        , 'coupon_seqno' => $couponNos[$inx]
                        , 'deleted' => 'N'
                        , 'create_dt' => date('Y-m-d H:i:s')
                        , 'update_dt' => date('Y-m-d H:i:s') 
                    ]
                );
            }
        }
    }

    public function add(Request $request)
    {
        $admin_seqno = $request->post('admin_seqno');
        $name = $request->post('name');
        $price = $request->post('price', 0);
        $date_use = $request->post('date_use', 0);
        $point = $request->post('point', 0);
        
        $services = $request->post('services'); // |2-1||3-1|11-5|
        $vouchers = $request->post('vouchers'); // 1,2,3,4,
        $coupons = $request->post('coupons'); // 1,2,3,4,

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        $id = DB::table('product_membership')->insertGetId(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'price' => $price
                , 'date_use' => $date_use
                , 'point' => $point                
                , 'deleted' => 'N'
                , 'create_dt' => date('Y-m-d H:i:s')
                , 'update_dt' => date('Y-m-d H:i:s') 
            ], 'seqno'
        );

        $this->generateGroup($id, $services, $vouchers, $coupons);

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function modify(Request $request, $id)
    {
        $admin_seqno = $request->post('admin_seqno');
        $name = $request->post('name');
        $price = $request->post('price', 0);
        $date_use = $request->post('date_use', 0);
        $point = $request->post('point', 0);
        
        $services = $request->post('services'); // |2-1||3-1|11-5|
        $vouchers = $request->post('vouchers'); // 1,2,3,4,
        $coupons = $request->post('coupons'); // 1,2,3,4,
        $deleted = $request->post('deleted', 'N');

        $result = [];
        $result['ment'] = '등록 실패';
        $result['result'] = false;

        DB::table('product_membership')->where([
            ['seqno', '=', $id]
        ])->update(
            [
                'admin_seqno' => $admin_seqno
                , 'name' => $name
                , 'price' => $price
                , 'date_use' => $date_use
                , 'point' => $point                
                , 'deleted' => $deleted                
                , 'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        
        DB::table('membership_service_grp')->where('membership_seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('membership_etc_voucher_grp')->where('membership_seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        DB::table('membership_coupon_grp')->where('membership_seqno', '=', $id)->update(
            [
                'deleted' => 'Y', 
                'update_dt' => date('Y-m-d H:i:s') 
            ]
        );
        $this->generateGroup($id, $services, $vouchers, $coupons);

        $result['ment'] = '성공';
        $result['result'] = true;

        return $result;
    }

    public function remove(Request $request, $id)
    {
        $result = [];
        $result['ment'] = '삭제 실패';
        $result['result'] = false;

        DB::table('product_membership')->where('seqno', '=', $id)->update(
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
