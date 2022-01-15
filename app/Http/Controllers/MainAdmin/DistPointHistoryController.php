<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistPointHistoryController extends Controller
{
    // Function For Sort Data
    function SortDistPointHistory($SortData){
        try {
            if ($SortData == 'today') {
                $date = Date('Y-m-d');

                $today = DB::select('SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at LIKE ? GROUP BY distributor_points.distributor_id HAVING COUNT(*)', ["%$date%"]);
                if (count($today) == 0) {
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('data' => '0'));
                } else {
                    $sum = collect($today)->sum('points');
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $today, 'data' => '1', 'total_points' => $sum));
                }
            } else if ($SortData == 'yesterday') {
                $yesterday = date('Y-m-d', strtotime("-1 days"));

                $yesterday1 = DB::select('SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at LIKE ? GROUP BY distributor_points.distributor_id HAVING COUNT(*)', ["%$yesterday%"]);
                if (count($yesterday1) == 0) {
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('data' => '0'));
                } else {
                    $sum = collect($yesterday1)->sum('points');
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $yesterday1, 'data' => '1', 'total_points' => $sum));
                }
            } else if ($SortData == 'this_week') {
               $start = Carbon::now()->startOfWeek();
               $this_week_start_date = explode(" ",$start);
               $a= $this_week_start_date[0];
               $end = Carbon::now()->modify("+1 days");
               $this_week_end_date = explode(" ",$end);
               $b = $this_week_end_date [0];

                $sql = "SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at BETWEEN '$a' AND '$b'  GROUP BY distributor_points.distributor_id HAVING COUNT(*)";
                $this_week = DB::select($sql);
                if(count($this_week) == 0){
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                }else{
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $this_week, 'data' => 1,));
                }
            } else if ($SortData == 'last_week') {
                $dateParam = date('Y-m-d');
                $week = date('w', strtotime($dateParam));
                $date = new DateTime($dateParam);
                $strat_Week = $date->modify("-" . $week . " day")->format("Y-m-d");
                $endWeek = $date->modify("-6 day")->format("Y-m-d");
                $strat_Week;
                $endWeek;

                $sql = "SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at BETWEEN '$endWeek' AND '$strat_Week'  GROUP BY distributor_points.distributor_id HAVING COUNT(*)";
                $last_week = DB::select($sql);
                if(count($last_week) == 0){
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                }else{
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $last_week, 'data' => 1,));
                }
            } else if ($SortData == 'this_month') {
                $start = Carbon::now()->startOfMonth('Y-m-d');
                $end = Carbon::now()->modify("+1 days");
                $StartMonth = explode(" ",$start);
                $StartThisMonth = $StartMonth[0];
                $EndMonth = explode(" ", $end);
                $EndThisMonth = $EndMonth[0];

                $sql = "SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at BETWEEN '$StartThisMonth' AND '$EndThisMonth'  GROUP BY distributor_points.distributor_id HAVING COUNT(*)";
                $this_month = DB::select($sql);
                if(count($this_month) == 0){
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                }else{
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $this_month, 'data' => 1,));
                }

            } else if ($SortData == 'last_month') {
               $first_day_of_month_1 = Carbon::now()->startOfMonth()->modify('-1 month')->toDateString();
                $last_day_of_month_1 = Carbon::now()->endOfMonth()->modify('-1 month')->toDateString();

               $sql = "SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at BETWEEN '$first_day_of_month_1' AND '$last_day_of_month_1'  GROUP BY distributor_points.distributor_id HAVING COUNT(*)";
                $last_month = DB::select($sql);
                if(count($last_month) == 0){
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                }else{
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $last_month, 'data' => 1,));
                }
            }
        } catch (Exception $e) {
            // dd('Something Went Wrong');
            dd($e->getMessage());
        }
    }

    // Function For Show Custom Dist Point History
    function CustomDistPointHistory(Request $request){
        $StartDate = $request -> input('StartDate');
        $EndDate = $request -> input('EndDate');
     $current_date = date('Y-m-d');
    $first_day_of_month_3 = Carbon::now()->startOfMonth()->modify('-3 month')->toDateString();

       if($StartDate > $current_date || $EndDate > $current_date){
           return back()->with('error','Select valid Date');
       }else{
           if($StartDate < $first_day_of_month_3 || $current_date < $first_day_of_month_3){
               return back()->with('error','Select valid Date');
           }else{
               $dist_id = $request->session()->get('user');
               $sql = "SELECT distributor_points.id AS user_main_id, distributor_points.distributor_id, distributor_points.points AS main_bal, distributor_points_history.points,distributor_points_history.created_at FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points_history.created_at BETWEEN '$StartDate' AND '$EndDate'  GROUP BY distributor_points.distributor_id HAVING COUNT(*)";
            //    $sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$StartDate' AND '$EndDate'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $cust_date = DB::select($sql);
                if(count($cust_date) == 0){
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                }else{
                    return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $cust_date, 'data' => 1,));
                }
           }
       }
    }
}
