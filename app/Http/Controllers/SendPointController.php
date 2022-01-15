<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\Traits\Date;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class SendPointController extends Controller
{
    // Function For Change Status From Notification
    public function ChangeAdminStatus($notify_id, $status)
    {
        $check = DB::update('UPDATE `distributor_notification` SET `status`= ? WHERE id = ?', [$status, $notify_id]);

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Change Status From Notification
    public function ChangeMainAdminStatus($ma_notify_id, $status)
    {
        $check = DB::update('UPDATE `admin_notification` SET `status`= ?,`admin_read`=? WHERE `id` = ? AND `status`=?', [$status,1,$ma_notify_id, 1]);

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Add Dist Points History
    public function AddDistPointsHistory($getdist_id, $points, $status)
    {
        $date = date('Y-m-d h:i:s');
        $historyArray = array('distributor_points_id' => $getdist_id, 'points' => $points, 'status' => $status, 'created_at' => $date);
        $addhistory = DB::table('distributor_points_history')->insert($historyArray);
        if ($addhistory) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Accept Points From Main Admin
    function AcceptPoints($notify_id, Request $request)
    {
        try {
            $notify_data = DB::select('SELECT * FROM `distributor_notification` WHERE id = ?', [$notify_id]);
            if (count($notify_data) != 0) {
                foreach ($notify_data as $data) {
                    $ma_notify_id = $data->ma_notify_id; 
                    $status = $data->status;
                    $dist_id = $data->reciever;
                    $points = $data->points;
                }
                if ($status == 1) {
                    $change_status = 2;
                    if ($this->ChangeAdminStatus($notify_id, $change_status)) {

                        if ($this->ChangeMainAdminStatus($ma_notify_id, $change_status)) {

                            $dist_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id =  ?', [$dist_id]);
                            if (count($dist_data) == 0) {
                                $pointarray = array('distributor_id' => $dist_id, 'points' => $points);
                                $id = DB::table('distributor_points')->insertGetId($pointarray);
                                if ($this->AddDistPointsHistory($id, $points, 'Accepted')) {

                                    return back()->with('message', 'Point Transfer Successfully...');
                                } else {
                                    $error = array('error_massage' => 'transfer point adding in history error error');
                                    DB::table('distributors_error')->insert($error);
                                    return back()->with('message', 'Something Went Wrong.....But Point Transfer Successfully...');
                                }
                            } else {
                                foreach ($dist_data as $data_dist) {
                                    $total_points = $points + $data_dist->points;
                                    DB::update('UPDATE `distributor_points` SET `points`= ? WHERE distributor_id = ?', [$total_points, $dist_id]);
                                    if ($this->AddDistPointsHistory($data_dist->id, $points, 'Accepted')) {

                                        return back()->with('message', 'Point Transfer Successfully...');
                                    } else {
                                        $error = array('error_massage' => 'transfer point adding in history error error');
                                        DB::table('distributors_error')->insert($error);
                                        return back()->with('message', 'Something Went Wrong.....But Point Transfer Successfully...');
                                    }
                                }
                            }
                        } else {
                            $error = array('error' => 'main admin notification Updation error');
                            DB::table('admin_error')->insert($error);
                            return back()->with('error', 'Points Transfer Error');
                        }
                    } else {
                        $error = array('error' => 'distributor notification Updation error');
                        DB::table('distributors_error')->insert($error);
                        return back()->with('error', 'Points Transfer Error');
                    }
                } else {
                    return back()->with('error', 'Notification Is Wrong');
                }
            } else {
                return back()->with('error', 'Distributor Not Found');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Function For Reject Points From Main Admin
    function RejectPoints($notify_id, Request $request)
    {
        try {
            $notify_data = DB::select('SELECT * FROM `distributor_notification` WHERE id = ?', [$notify_id]);
            if (count($notify_data) != 0) {
                foreach ($notify_data as $data) {
                    $ma_notify_id = $data->ma_notify_id;
                    $dist_id = $data->reciever;
                    $points = $data->points;
                    $status = $data->status;
                }
                if ($status == 1) {
                    $dist_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id =  ?', [$dist_id]);
                    if (count($dist_data) != 0) {
                        foreach ($dist_data as $data) {
                            $d_id = $data->id;
                        }
                        $change_status = 3;
                        if ($this->ChangeAdminStatus($notify_id, $change_status)) {

                            if ($this->ChangeMainAdminStatus($ma_notify_id, $change_status)) {

                                if ($this->AddDistPointsHistory($d_id, $points, 'Rejected')) {
                                    return back()->with('message', 'Point Rejected Successfully...');
                                } else {
                                    $error = array('error' => 'main admin History Updation error');
                                    DB::table('admin_error')->insert($error);
                                    return back()->with('error', 'Points Transfer Error');
                                }
                            } else {
                                $error = array('error' => 'main admin notification Updation error');
                                DB::table('admin_error')->insert($error);
                                return back()->with('error', 'Points Transfer Error');
                            }
                        } else {
                            $error = array('error' => 'distributor notification Updation error');
                            DB::table('distributors_error')->insert($error);
                            return back()->with('error', 'Points Transfer Error');
                        }
                    } else {
                        return back()->with('error', 'Distributer Not Found');
                    }
                } else {
                    return back()->with('error', 'Notification Is Wrong');
                }
            } else {
                return back()->with('error', 'Distributor Not Found');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Function For Add Points User Notification
    public function AddUserNotification($dist_notify_id,$getdist_id, $user_id, $points)
    {
        $date = date('Y-m-d h:i:s');
        $NotificationArray = array('dist_notify_id' =>$dist_notify_id, 'sender' => $getdist_id, 'reciever' => $user_id, 'points' => $points, 'status' => 1, 'created_at' => $date);
        $NotificationPoints = DB::table('user_notification')->insert($NotificationArray);
        if ($NotificationPoints) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Sending User Point
    function AddUserPoint(Request $request)
    {
        // dd($request->all());die;
        $dist_id = $request->session()->get('user');
        $user = $request->input('user_id');
        $points = $request->input('points');
        $pin = $request->input('pin');

        $user_id=strtoupper($user);
        
        try {
            $UserExist = DB::select('SELECT `id` FROM `user` WHERE distributor_id =? and user_id=?', [$dist_id, $user_id]);
            if (count($UserExist) != 0) {
                    $pin_data = DB::select('SELECT `pin` FROM `distributor` WHERE distributor_id=?', [$dist_id]);
                    foreach ($pin_data as $data_pin) {
                        if ($data_pin->pin == $pin) {
                            $check_distId = DB::select('SELECT * FROM `distributor` WHERE distributor_id = ?', [$dist_id]);
                            if (count($check_distId) != 0) {
                                $dis_point_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id = ?', [$dist_id]);
                                if (count($dis_point_data) != 0) {
                                    foreach ($dis_point_data as $dist_points) {
                                        $distributor_point = $dist_points->points;
                                    }
                                    if (($distributor_point != 0) && ($distributor_point >= $points)) {
                                        $distributor_point = $distributor_point - $points;
                                        $request->session()->put('dist_points', $distributor_point);
                                        $dist_check = DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id=?', [$distributor_point, $dist_id]);
                                        if ($dist_check) {
                                            $NotificationArray = array('sender' => $dist_id, 'reciever' => $user_id, 'points' => $points, 'status' => 1);
                                            $id = DB::table('distributor_notification')->insertGetId($NotificationArray);
                                            if ($id) {
                                                if ($this->AddUserNotification($id,$dist_id, $user_id, $points)) {
                                                    return back()->with('message', 'Points Send Successfully...');
                                                } else {
                                                    return back()->with('message', 'Something Went Wrong.....Points Not Send');
                                                }
                                            } else {
                                                return back()->with('message', 'Something Went Wrong.....Point Not Send');
                                            }
                                        } else {
                                            return back()->with('error', 'Points Not Send...');
                                        }
                                    } else {
                                        return back()->with('error', 'Insufficient Points');
                                    }
                                } else {
                                    return back()->with('error', 'Points Are Not Available In Your Account');
                                }
                            } else {
                                return back()->with('error', 'Distributor Not Found');
                            }
                        } else {
                            return back()->with('error', 'Pin Not Match');
                        }
                    }
            } else {
                return back()->with('error', 'User Not Exist...');
            }
        } catch (Exception $e) {
            // dd('Something Went Wrong');
            dd($e->getMessage());
        }
    }

    // Function For Getting User Info
    function SendPointToPlayer($user_id)
    {
        try {
            $user_data = DB::select('SELECT `user_id`, `distributor_id`, `username` FROM `user` WHERE user_id=?', [$user_id]);
            if (count($user_data) == 0) {
                return back()->with('error', 'User Data Not Found');
            } else {
                return view('admin.pages.SendPoint.SendPointToPlayer', array('user_data' => $user_data));
            }
        } catch (Exception $e) {
            dd('Something Went Wrong');
        }
    }
    
    // Function For Getting User Info
    function CutPointsOfPlayer($user_id)
    {
        try {
            $user_data = DB::select('SELECT `user_id`, `distributor_id`, `username` FROM `user` WHERE user_id=?', [$user_id]);
            if (count($user_data) == 0) {
                return back()->with('error', 'User Data Not Found');
            } else {
                return view('admin.pages.SendPoint.CutPointsOfPlayer', array('user_data' => $user_data));
            }
        } catch (Exception $e) {
            dd('Something Went Wrong');
        }
    }
    
    // Function For Cut Points Of User
    function CutUserPoints(Request $request)
    {
        // dd($request->all());die;
        $dist_id = $request->session()->get('user');
        $user_id = $request->input('user_id');
        $points = $request->input('points');
        $pin = $request->input('pin');

        try {
            $UserExist = DB::select('SELECT `id` FROM `user` WHERE distributor_id =? and user_id=?', [$dist_id, $user_id]);
            if (count($UserExist) != 0) {
                    $pin_data = DB::select('SELECT `pin` FROM `distributor` WHERE distributor_id=?', [$dist_id]);
                    foreach ($pin_data as $data_pin) {
                        if ($data_pin->pin == $pin) {
                                $user_point_data = DB::select('SELECT * FROM `user_points` WHERE user_id = ?', [$user_id]);
                                if (count($user_point_data) != 0) {
                                    foreach ($user_point_data as $user_points) {
                                        $user_points = $user_points->points;
                                    }
                                    if (($user_points != 0) && ($user_points > $points)) {
                                        $user_points = $user_points - $points;
                                        $dist_point_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id = ?', [$dist_id]);
                                        if (count($dist_point_data) != 0) {
                                            foreach ($dist_point_data as $dist_points) {
                                                $dist_points = $dist_points->points;
                                            }
                                            $dist_points = $dist_points + $points;
                                            $request->session()->put('dist_points', $dist_points);
                                            $dist_check = DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id=?', [$dist_points, $dist_id]);
                                            if ($dist_check) {
                                                $user_check = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id=?', [$user_points, $user_id]);
                                                if ($user_check) {                                                    
                                                    return back()->with('message', 'Points Receive Successfully...');                                        
                                                } else {
                                                    return back()->with('error', 'Something Went Wrong.....Point Not Receive');
                                                }
                                            }else {
                                                return back()->with('error', 'Something Went Wrong.....Point Not Receive');
                                            }
                                        
                                        }else {
                                            return back()->with('error', 'Something Went Wrong.....Point Not Receive');
                                        }
                                    } else {
                                        return back()->with('error', 'Insufficient Points');
                                    }
                                } else {
                                    return back()->with('error', "Points Are Not Available In User's Account");
                                }
                        } else {
                            return back()->with('error', 'Pin Not Match');
                        }
                    }
            } else {
                return back()->with('error', 'User Not Exist...');
            }
        } catch (Exception $e) {
            // dd('Something Went Wrong');
            dd($e->getMessage());
        }
    }

    // FUnction For Showing Transfer Point History
    function ShowHistory(Request $request)
    {
        try {
            $dist_id = $request->session()->get('user');
            $PointData = DB::select('SELECT * FROM `user_points` WHERE distributor_id=?', [$dist_id]);
            if (count($PointData) == 0) {
                return view('admin.pages.SendPoint.SendPoint', ['data' => 0])->with('error', 'Transfer History Not Found');
            } else {
                $query = collect($PointData)->sum('points');
                return view('admin.pages.SendPoint.SendPoint', array('PointData' => $PointData, 'total_points' => $query, 'data' => 1));
            }
        } catch (Exception $e) {
            dd('Something Went Wrong');
        }
    }

    // Function For Show Transfer Point Data
    function UserPointReport(Request $request)
    {
        try {
            $dist_id = $request->session()->get('user');
            $PointData = DB::select('SELECT user_points.id AS user_main_id, user_points.user_id, user_points.points AS main_bal, user_points_history.points,user_points_history.created_at,user_points.distributor_id FROM user_points LEFT JOIN user_points_history ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id=? GROUP BY user_points_history.user_points_id HAVING COUNT(*)', [$dist_id]);
            if (count($PointData) == 0) {
                return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
            } else {
                // foreach($PointData as $points){
                // $point_sum = $points->points;
                $sum_points = collect($PointData)->sum('points');
                // echo $sum_points;
                // }
                return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $PointData, 'data' => 1, 'point_sum' => $sum_points));
            }
        } catch (Exception $e) {
            dd('Something Went Wrong');
        }
    }

    //Function For Sort User Point Data
    function SortUserPointHistory($SortData, Request $request)
    {
        try {
            if ($SortData == 'today') {
                $date = Date('Y-m-d');
                $dist_id = $request->session()->get('user');
                $today = DB::select('SELECT user_points.id AS user_main_id, user_points.user_id, user_points.points AS main_bal, user_points_history.points,user_points_history.created_at,user_points.distributor_id FROM user_points LEFT JOIN user_points_history ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id=? AND user_points_history.created_at LIKE ? GROUP BY user_points.user_id HAVING COUNT(*)', [$dist_id,  "%$date%"]);
                if (count($today) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $today, 'data' => 1));
                }
            } else if ($SortData == 'yesterday') {
                $yesterday = date('Y-m-d', strtotime("-1 days"));
                $dist_id = $request->session()->get('user');
                $yesterday1 = DB::select("SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= ? AND user_points_history.created_at LIKE ? GROUP BY user_points.user_id HAVING COUNT(*)", [$dist_id, "%$yesterday%"]);
                if (count($yesterday1) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $yesterday1, 'data' => 1,));
                }
            } else if ($SortData == 'this_week') {
                $start = Carbon::now()->startOfWeek();
                $this_week_start_date = explode(" ", $start);
                $a = $this_week_start_date[0];
                $end = Carbon::now()->modify("+1 days");
                $this_week_end_date = explode(" ", $end);
                $b = $this_week_end_date[0];
                $dist_id = $request->session()->get('user');
                $sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$a' AND '$b'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $this_week = DB::select($sql);
                if (count($this_week) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $this_week, 'data' => 1,));
                }
            } else if ($SortData == 'last_week') {
                $dateParam = date('Y-m-d');
                $week = date('w', strtotime($dateParam));
                $date = new DateTime($dateParam);
                $strat_Week = $date->modify("-" . $week . " day")->format("Y-m-d");
                $endWeek = $date->modify("-6 day")->format("Y-m-d");
                $strat_Week;
                $endWeek;
                $dist_id = $request->session()->get('user');
                $sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$endWeek' AND '$strat_Week'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $last_week = DB::select($sql);
                if (count($last_week) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $last_week, 'data' => 1,));
                }
            } else if ($SortData == 'this_month') {
                $start = Carbon::now()->startOfMonth('Y-m-d');
                $end = Carbon::now()->modify("+1 days");
                $StartMonth = explode(" ", $start);
                $StartThisMonth = $StartMonth[0];
                $EndMonth = explode(" ", $end);
                $EndThisMonth = $EndMonth[0];
                $dist_id = $request->session()->get('user');
                $sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$StartThisMonth' AND '$EndThisMonth'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $this_month = DB::select($sql);
                if (count($this_month) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $this_month, 'data' => 1,));
                }
            } else if ($SortData == 'last_month') {
                $first_day_of_month_1 = Carbon::now()->startOfMonth()->modify('-1 month')->toDateString();
                $last_day_of_month_1 = Carbon::now()->endOfMonth()->modify('-1 month')->toDateString();
                $dist_id = $request->session()->get('user');
                $sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$first_day_of_month_1' AND '$last_day_of_month_1'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $last_month = DB::select($sql);
                if (count($last_month) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $last_month, 'data' => 1,));
                }
            }
        } catch (Exception $e) {
            // dd('Something Went Wrong');
            dd($e->getMessage());
        }
    }

    // FUnction For Custom Date Report
    function CustomUserPointHistory(Request $request)
    {
        $StartDate = $request->input('StartDate');
        $EndDate = $request->input('EndDate');
        $current_date = date('Y-m-d');
        $first_day_of_month_3 = Carbon::now()->startOfMonth()->modify('-3 month')->toDateString();

        if ($StartDate > $current_date || $EndDate > $current_date) {
            return back()->with('error', 'Select valid Date');
        } else {
            if ($StartDate < $first_day_of_month_3 || $current_date < $first_day_of_month_3) {
                return back()->with('error', 'Select valid Date');
            } else {
                $dist_id = $request->session()->get('user');
                //$sql = "SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND user_points_history.created_at BETWEEN '$StartDate' AND '$EndDate'  GROUP BY user_points_history.user_points_id HAVING COUNT(*)";
                $sql = "SELECT * FROM (SELECT user_points.id AS user_main_id,user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id, user_points_history.user_points_id FROM user_points_history LEFT JOIN user_points ON user_points_history.user_points_id=user_points.id WHERE user_points.distributor_id= '$dist_id' AND DATE(user_points_history.created_at) BETWEEN '$StartDate' AND '$EndDate' ORDER BY user_points_history.created_at DESC) AS sub GROUP BY user_points_id HAVING COUNT(*)";
                $cust_date = DB::select($sql);
                //print_r($sql);die;
                if (count($cust_date) == 0) {
                    return view('admin.pages.SendPoint.SendPointHistory', ['data' => 0])->with('error', 'Transfer History Not Found');
                } else {
                    return view('admin.pages.SendPoint.SendPointHistory', array('PointData' => $cust_date, 'data' => 1,));
                }
            }
        }
    }
    // Function For Get History By User Id
    function ShowhistoryByUserId($user_id)
    {
        $user_history['data'] = DB::select('SELECT user_points.id AS user_main_id, user_points.user_id, user_points_history.points,user_points_history.created_at,user_points.distributor_id FROM user_points LEFT JOIN user_points_history ON user_points_history.user_points_id=user_points.id WHERE user_points_history.user_points_id=?', [$user_id]);

        $sum_points = DB::table('user_points_history')->where('user_points_id', $user_id)->sum('points');
        $user_history['sum_points'] = $sum_points;
        echo json_encode($user_history);
        exit;
    }
}
