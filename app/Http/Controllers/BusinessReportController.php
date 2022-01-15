<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\DateTime;
use DateTime;
use Illuminate\Support\Facades\Date;
use SebastianBergmann\Environment\Console;

class BusinessReportController extends Controller
{
    // Function For Display DisplayBusinessReports
    function DisplayBusinessReports(Request $request)
    {
        $dist_id = $request->session()->get('user');
        $dateParam = date('Y-m-d');
        $week = date('w', strtotime($dateParam));
        $date = new DateTime($dateParam);
        $strat_Week = $date->modify("-" . $week . " day")->format("Y-m-d");
        $endWeek = $date->modify("-7 day")->format("Y-m-d");

        $strat_Week;
        $start = $strat_Week . ' ' . date('H:i:s');
        $end = $endWeek . ' ' . date('H:i:s');
        $endWeek;

        //     $data =  (new Carbon($strat_Week))->addDays(7);
        //     $add_comm = explode(' ',$data);
        //    $add_comm_date = $add_comm[0];

        $abc = date('Y-m-d');
        $flag = 0;

        if ($strat_Week == $abc) {
            $check_date = DB::select('SELECT `start_date` FROM `dist_commission` where distributor_id =?', [$dist_id]);
            foreach ($check_date as $date_check) {
                $date = explode(" ", $date_check->start_date);
                if ($abc == $date[0]) {
                    $flag = 1;
                }
            }
            if ($flag == 1) {
                $commission_list = DB::select('SELECT * FROM `dist_commission` WHERE distributor_id = ?', [$dist_id]);
                if ($commission_list) {
                    return view('admin.pages.Reports.BusinessReports.Commission_List', array('commission' => $commission_list, 'data' => '1'));
                } else {
                    return view('admin.pages.Reports.BusinessReports.Commission_List', ['data' => '0']);
                }
            } else {
                $get_dist_id = DB::select('SELECT id FROM `user_points` WHERE distributor_id = ?', [$dist_id]);
                $all_sum = null;
                foreach ($get_dist_id as $get_data) {
                    $data = DB::select('SELECT * FROM `user_points_history` WHERE created_at BETWEEN ? AND ? AND user_points_id = ?', ["$endWeek", "$strat_Week", $get_data->id]);
                    $all_sum = $all_sum + collect($data)->sum('points');
                }
                $dist_data = DB::select('SELECT `percentage` FROM `distributor` WHERE distributor_id = ?', [$dist_id]);
                $commission = null;
                foreach ($dist_data as $per) {
                    $commission = $all_sum / 100 * $per->percentage;
                }
                $commission_data = array('distributor_id' => $dist_id, 'start_date' => $start, 'end_date' => $end, 'end_point' => $all_sum, 'commission' => $commission, 'payable' => $commission);
                $check = DB::table('dist_commission')->insert($commission_data);

                $commission_list = DB::select('SELECT * FROM `dist_commission` WHERE distributor_id = ?', [$dist_id]);
                if ($commission_list) {
                    return view('admin.pages.Reports.BusinessReports.Commission_List', array('commission' => $commission_list, 'data' => '1'));
                } else {
                    return view('admin.pages.Reports.BusinessReports.Commission_List', ['data' => '0']);
                }
            }
        } else {
            $commission_list = DB::select('SELECT * FROM `dist_commission` WHERE distributor_id = ?', [$dist_id]);
            if ($commission_list) {
                return view('admin.pages.Reports.BusinessReports.Commission_List', array('commission' => $commission_list, 'data' => '1'));
            } else {
                return view('admin.pages.Reports.BusinessReports.Commission_List', ['data' => '0']);
            }
        }
    }

    // // Function for Create BusinessReport
    // function BusinessReport(Request $request)
    // {
    //     $dist_id = $request->session()->get('user');
    //     $get_user_id = DB::select('SELECT `id` FROM `user_points` WHERE distributor_id = ?', [$dist_id]);
    //     if (count($get_user_id) == 0) {
    //         return view('admin.pages.Reports.BusinessReports.BusinessReport', array('data' => '0'));
    //     } else {
    //         $all_points = null;
    //         // $user_id=null;
    //         foreach ($get_user_id as $getid) {
    //             $get_point_data = DB::select('SELECT * FROM `user_points_history` WHERE user_points_id = ?', [$getid->id]);
    //             $all_points = $all_points + collect($get_point_data)->sum('points');
    //         }
    //         // echo$all_points;
    //         return view('admin.pages.Reports.BusinessReports.BusinessReport', array('sum' => $all_points, 'data' => '1'));
    //     }
    // }
    
    // Function for Create BusinessReport
    function BusinessReport(Request $request)
    {
        $dist_id = $request->session()->get('user');
        $get_user_id = DB::select('SELECT `points` FROM `distributor_points` WHERE  distributor_id = ?', [$dist_id]);
        if (count($get_user_id) == 0) {
            return view('admin.pages.Reports.BusinessReports.BusinessReport', array('data' => '0'));
        } else {

            foreach ($get_user_id as $getid) {
               
                $all_points = $getid->points;
            }
            // echo$all_points;
            return view('admin.pages.Reports.BusinessReports.BusinessReport', array('sum' => $all_points, 'data' => '1'));
        }
    }

    // Function For CasionGameReport
    function CasionGameReport(Request $request)
    {
        $dist_id = $request->session()->get('user');
        $round_data = DB::select('SELECT round_report.id,round_report.distributor_id,round_report.round_count,round_report.player_id,round_report.win_X,round_report.win_no,round_report.no_0,round_report.no_1,round_report.no_2,round_report.no_3,round_report.no_4,round_report.no_5,round_report.no_6,round_report.no_7,round_report.no_8,round_report.no_9,game_name.game_name,round_report.created_at FROM round_report LEFT JOIN game_name ON round_report.game=game_name.id WHERE round_report.distributor_id = ? GROUP BY id HAVING COUNT(*) ORDER BY id DESC LIMIT ?', [$dist_id, 25000]);
        if (count($round_data) == 0) {
            return view('admin.pages.Reports.BusinessReports.CasinoGameReport', ['data12' => '0']);
        } else {
            return view('admin.pages.Reports.BusinessReports.CasinoGameReport', array('data12' => '1', 'round_data' => $round_data));
        }
    }

    // Function For Getting Round History By Round Count
    function GetRoundData(Request $request)
    {
        $round_count = request('round_count');
        $user_id = request('user_id');
        $dist_id = $request->session()->get('user');
        $data['data'] = DB::select('SELECT round_report.round_count,round_report.player_id,round_report.win_X,round_report.win_no,round_report.no_0,round_report.no_1,round_report.no_2,round_report.no_3,round_report.no_4,round_report.no_5,round_report.no_6,round_report.no_7,round_report.no_8,round_report.no_9,game_name.game_name,round_report.created_at FROM round_report LEFT JOIN game_name ON round_report.game=game_name.id WHERE round_report.round_count=? AND round_report.player_id=? AND round_report.distributor_id = ?', [$round_count, "$user_id", $dist_id]);
        echo json_encode($data);
        exit;
    }

    // Function For Getting Round History By user Id
    function GetDataByUserId(Request $request)
    {
        $user_id = request('user_id');
        $dist_id = $request->session()->get('user');
        $data['data'] = DB::select('SELECT round_report.round_count,round_report.player_id,round_report.win_X,round_report.win_no,round_report.no_0,round_report.no_1,round_report.no_2,round_report.no_3,round_report.no_4,round_report.no_5,round_report.no_6,round_report.no_7,round_report.no_8,round_report.no_9,game_name.game_name,round_report.created_at FROM round_report LEFT JOIN game_name ON round_report.game=game_name.id WHERE round_report.player_id=? AND round_report.distributor_id = ?', [$user_id, $dist_id]);
        echo json_encode($data);
        exit;
    }
}
