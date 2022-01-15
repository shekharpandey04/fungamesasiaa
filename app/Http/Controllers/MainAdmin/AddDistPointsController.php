<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddDistPointsController extends Controller
{
     // Function For Add Points Distributor Notification
    public function AddDistNotification($ma_notify_id,$getdist_id, $points)
    {
        $NotificationArray = array('ma_notify_id' => $ma_notify_id, 'sender' => 'Main Admin', 'reciever' => $getdist_id, 'points' => $points, 'status' => 1,'dist_read'=>1);
        $NotificationPoints = DB::table('distributor_notification')->insert($NotificationArray);
        if ($NotificationPoints) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Add Dist Points
    function AddDistPoints(Request $request)
    {
        $dist_id = $request->input('dist_id');
        $points = $request->input('points');
        $pin = $request->input('pin');
        // dd($request->all());
        try {
                $pin_data = DB::select('SELECT * FROM `admin`');
                foreach ($pin_data as $data_pin) {
                    if ($data_pin->pin == $pin) {
                        $check_distId = DB::select('SELECT * FROM `distributor` WHERE distributor_id = ?', [$dist_id]);
                        if (count($check_distId) != 0) {
                            $NotificationArray = array('distributor_id' => $dist_id, 'points' => $points, 'status' => 1);
                            $id = DB::table('admin_notification')->insertGetId($NotificationArray);
                            if ($id) {
                                if ($this->AddDistNotification($id,$dist_id, $points)) {
                                    return back()->with('message', 'Point Transfer Successfully...');
                                } else {
                                    return back()->with('error', 'Something Went Wrong.....Point Not Added In Notification');
                                }
                            } else {
                                return back()->with('error', 'Something Went Wrong.....Point Not Transfer');
                            }
                        } else {
                            return back()->with('error', 'Distributor Not Found');
                        }
                    } else {
                        return back()->with('error', 'Pin Not Match');
                    }
                }
           
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Function For Distributor Send Point
    function DistributorSendPoint()
    {
        $points_data = DB::select('SELECT * FROM `distributor_points`');
        if (count($points_data) == 0) {
            return view('main_admin.pages.SendPoints.DistSendPoints', array('data' => '0'));
        } else {
            $sum = collect($points_data)->sum('points');
            return view('main_admin.pages.SendPoints.DistSendPoints', array('PointData' => $points_data, 'data' => '1', 'total_points' => $sum));
        }
    }

    // Function For Dist Point Report
    function DistPointReport()
    {
        $points_data = DB::select('SELECT * FROM `distributor_points`');
        if (count($points_data) == 0) {
            return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('data' => '0'));
        } else {
            $sum = collect($points_data)->sum('points');
            return view('main_admin.pages.SendPoints.DistSendPointsHistory', array('PointData' => $points_data, 'data' => '1', 'total_points' => $sum));
        }
    }

    // Function For Display Distributor List
    function DistributorList()
    {
        $dist_list = DB::select('SELECT `id`, `distributor_id`, `username`, `percentage`, `pin`, `IsBlocked`, `LastLoggedIn`, `LastLoggedOut`, `active`, `created_at` FROM `distributor`');
        if(count($dist_list) == 0){
            return view('main_admin.pages.AddDist.DisplayAllDistributor',array('data'=>"0"));
        }else{
           return view('main_admin.pages.AddDist.DisplayAllDistributor',array('dist_list'=>$dist_list,'data'=>"1"));
        }
    }

    // Route For Get History Data By Dist Id
    function GetHistoryByDistId($dist_id)
    {
        $dist_history['data'] = DB::select('SELECT distributor_points.id AS user_main_id, distributor_points_history.points,distributor_points_history.status,distributor_points_history.created_at,distributor_points.distributor_id FROM distributor_points LEFT JOIN distributor_points_history ON distributor_points_history.distributor_points_id=distributor_points.id WHERE distributor_points.distributor_id = ?', [$dist_id]);
        $sum_points = null;
        $data = DB::select('SELECT id FROM `distributor_points` WHERE distributor_id=?', [$dist_id]);
        foreach ($data as $sum_data) {
            // $sum_points = DB::table('distributor_points_history')->where('distributor_points_id', '1')->sum('points');
            $abc= DB::select('SELECT * FROM `distributor_points_history` WHERE distributor_points_id=?',[$sum_data->id]);
        }
        $sum_points = collect($abc)->sum('points');

        $dist_history['sum_points'] = $sum_points;
        echo json_encode($dist_history);
        exit;
    }
}
