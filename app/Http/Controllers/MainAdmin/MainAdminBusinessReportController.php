<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainAdminBusinessReportController extends Controller
{
    // Function For Show Main Admin Commission List
    function MainCommissionList(){
        $MainAdminCommissionList = DB::select('SELECT * FROM `dist_commission` GROUP BY distributor_id HAVING COUNT(*)');
        if(count($MainAdminCommissionList) == 0){
            return view('main_admin.pages.MainAdminBusinessReport.MainAdminCommissionList',['data'=>0]);
        }else{
            return view('main_admin.pages.MainAdminBusinessReport.MainAdminCommissionList',array('data'=>1,'commission_list'=>$MainAdminCommissionList));
        }
    }

    // Function For Get Main Admin Commission List
    function GetMainAdminCommissionList($id){
        $list['data'] = DB::select('SELECT * FROM `dist_commission` WHERE distributor_id = ?',[$id]);

        $total_commission = DB::table('dist_commission')->where('distributor_id', $id)->sum('commission');

        $total_points = DB::table('dist_commission')->where('distributor_id', $id)->sum('end_point');

        $list['total_commission'] = $total_commission;
        $list['total_points'] = $total_points;
        echo json_encode($list);
        exit;
    }
}
