<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginMainAdminController extends Controller
{
    // fUNCTION fOR Login Main Admin
    function LoginMainAdmin(Request $request)
    {
        try {
            $username = $request->input('username');
            $password = $request->input('password');

            $log_data = DB::select('SELECT * FROM `admin`');

            if (count($log_data) != 0) {

                foreach ($log_data as $data) {
                    if ($data->username == $username) {
                        if ($password == $data->password) {
                            $request->session()->put('admin', $data->username);
                            return redirect('/main_dashboard');
                        } else {
                            return back()->with('error', 'Username And Password Not Match');
                        }
                    } else {
                        return back()->with('error', 'Username And Password Not Match');
                    }
                }
            } else {
                return back()->with('error', 'User Not Found');
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            dd('Something Went Wrong');
        }
    }

    // Function For Show Main Dashboard
    function ShowMainDashboard(Request $request)
    { 
        $dist = DB::select('SELECT id FROM `distributor`');
        $dist_count = count($dist);
        $request->session()->put('dist_count',$dist_count);
        
        $n_mode = DB::select('SELECT mode FROM `night_mode`');
        foreach ($n_mode as $data) {
            $night_mode = $data->mode;
        }
        if ($night_mode == 0) {
            $night_mode = 'Night Mode is off';
            $request->session()->put('night_mode', $night_mode);
        } else {
            $night_mode = 'Night Mode is on';
            $request->session()->put('night_mode', $night_mode);
        }

        $joker_mode = DB::select('SELECT mode FROM `joker`');
        foreach ($joker_mode as $data) {
            $joker_mode = $data->mode;
        }
        if ($joker_mode == 0) {
            $joker_mode = 'Joker is off';
            $request->session()->put('joker_mode', $joker_mode);
        } else {
            $joker_mode = 'Joker is on';
            $request->session()->put('joker_mode', $joker_mode);
        }

        $prime_mode_record = DB::select('SELECT * FROM `prime_mode` limit 1');
        $prime_mode  =  ($prime_mode_record[0]->mode) ? 'Night Mode is on' : 'Night Mode is off';
        $request->session()->put('prime_mode', $prime_mode);


        $admin_data = DB::select('SELECT * FROM `admin_notification` WHERE admin_read = ? ORDER BY id DESC ',[1]);
        //$request->session()->put('admin_notify_data',$admin_data);
        $admin_notify_data =  $admin_data ;
                $admin_notify_count = count($admin_data);
                $admin_notify= array();
                //$request->session()->put('admin_notify_count',$admin_notify_count);
                foreach($admin_data as $data){
                    $temp = array();
                    $temp['id ']= $data->id;
                    $temp['distributor_id ']= $data->distributor_id ;
                    //$temp['user_id']= $data->user_id;
                    $temp['points'] = $data->points;
                    $temp['status'] = $data->status;
                    $temp['dist_read']= $data->admin_read;
                    $temp['created_at']= $data->created_at;
                   array_push($admin_notify,$temp);
                }        
      
        if ($dist_count == 0) {
            return view('main_admin.Main_Dashboard', compact('dist_count','admin_notify_data','admin_notify_count'));
        } else {
            return view('main_admin.Main_Dashboard',compact('dist_count','admin_notify_data','admin_notify_count'));
        }
    }

    // Function For Logout User
    function Logout(Request $request){
        $request->session()->forget('admin');

        $request->session()->flush();
        return redirect('/main-admin');
    }


}
