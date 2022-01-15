<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class LogInController extends Controller
{
    // Function For Login
    function dist_login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $logdata = DB::select("SELECT * FROM `distributor` WHERE distributor_id ='$username'");
            if (count($logdata) == 0) {
                return back()->with('error', 'User Not Found..');
            } else {
                foreach ($logdata as $data) {
                    if ($data->IsBlocked == 0) {
                        if (Hash::check($password, $data->password)) {
                            $request->session()->put('user', $data->distributor_id);
                            $date_time = date('Y-m-d h:i:s');
                            
                            DB::update('UPDATE `distributor` SET `LastLoggedIn`=?,`active`=? WHERE distributor_id = ?', [$date_time, 1, $data->distributor_id]);
                            
                            return redirect('dashboard');
                            // ->with($request->session()->get('user'));
                            
                        } else {
                            return back()->with('error', 'Username Or Password Not Match..');
                        }
                    } else {
                        return back()->with('error', 'Your Account is Blocked. Please Contact Administrator.');
                    }
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            dd('Something Went Wrong');
        }
    }

    // Function For Show Dashboard
    function dashboard(Request $request)
    {
        try {
            $dist_id = $request->session()->get('user');
            $player = DB::select('SELECT * FROM `user` WHERE distributor_id=?', [$dist_id]);
            $dist_points = DB::select('SELECT `points` FROM `distributor_points` WHERE distributor_id=?', [$dist_id]);

            if (count($dist_points) == 0) {
                $player_count = count($player);
                $request->session()->put('dist_points', 0);

                $dist_data = DB::select('SELECT * FROM `distributor_notification` WHERE (sender=? OR reciever=?) AND dist_read = ?', [$dist_id,$dist_id,1]);
                if (count($dist_data) != 0) {
                    $notify_count = count($dist_data);
                    $dist_notify = array();
                    $request->session()->put('notify_count', $notify_count);
                    $request->session()->get('notify_data');
                    if (count($player) == 0) {
                        $player_count = count($player);
                        return view('admin.dashboard', array('player_count' => $player_count, 'dist_data' => $dist_data, 'no_data' => 1));
                    } else {
                        $player_count = count($player);
                        return view('admin.dashboard', array('player_count' => $player_count, 'dist_data' => $dist_data, 'no_data' => 1));
                    }
                }
                return view('admin.dashboard', array('player_count' => $player_count, 'no_data' => 0));
            } else {
                foreach ($dist_points as $dist_point) {

                    $request->session()->put('dist_points', $dist_point->points);

                    $dist_data = DB::select('SELECT * FROM `distributor_notification` WHERE (sender=? OR reciever=?) AND dist_read = ?', [$dist_id,$dist_id,1]);
                    $notify_count = count($dist_data);
                    
                    $dist_notify = array();
                    $request->session()->put('notify_count', $notify_count);

                    
                    $request->session()->get('notify_data');
                    if (count($player) == 0) {
                        $player_count = count($player);
                        return view('admin.dashboard', array('player_count' => $player_count, 'dist_data' => $dist_data, 'no_data' => 1));
                    } else {
                        $player_count = count($player);
                        return view('admin.dashboard', array('player_count' => $player_count, 'dist_data' => $dist_data, 'no_data' => 1));
                    }
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Function For Display Notification
    function DisplayNotify($id, Request $request)
    {
        $notify_data123 = DB::select('SELECT * FROM `distributor_notification` WHERE id= ?', [$id]);
        if (count($notify_data123) == 0) {
            return view('admin.pages.DisplayNotification', ['data' => 0]);
        } else {
            foreach ($notify_data123 as $data) {
                if (($data->status) != 1) {
                    DB::update('UPDATE `distributor_notification` SET `dist_read`=? WHERE id = ?', [0, $id]);
                }
            }
            $dist_notify = DB::select('SELECT * FROM `distributor_notification` WHERE dist_read = ? AND id = ?', [1, $id]);
            // $request->session()->put('notify_data', $dist_notify);
            $notify_count = count($dist_notify);

            $request->session()->put('notify_count', $notify_count);
            return view('admin.pages.DisplayNotification', array('data' => 1, 'notify_data' => $notify_data123));
        }
    }

    // FUnction For Logout Session
    function logout(Request $request)
    {
        $dist_id = $request->session()->get('user');
        $date_time = date('Y-m-d h:i:s');
        DB::update('UPDATE `distributor` SET `LastLoggedOut`=? ,`active`=? WHERE distributor_id = ?', [$date_time, 0, $dist_id]);

        $request->session()->forget('user');

        // $request->session()->flush();
        return redirect('/backoffice');
    }
}
