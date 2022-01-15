<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistributorSettingController extends Controller
{
    // Function For Change Password
    function ChangePassword(Request $request){
        $pass = $request -> input('new_pass');
        $conn_pass = $request -> input('con_pass');
        $old_pass = $request -> input('old_pass');
        $dist_id = $request->session()->get('user');
        // dd($request->all());die;
        $sql = 'SELECT `password` FROM `distributor` WHERE distributor_id ="'.$dist_id.'"';
        $db_pass = DB::select($sql);
        if($pass == $conn_pass){
            foreach($db_pass as $pass_data){
                if(Hash::check($old_pass, $pass_data->password)){
                    $password = Hash::make($conn_pass);
                    $check = DB::update('UPDATE `distributor` SET `password`=? WHERE distributor_id = ?',[$password,$dist_id]);
                    if($check){
                        return back()->with('message','Password Change Successfully');
                    }else{
                        return back()->with('error','Password Not Change');
                    }
                }else{
                    return back()->with('error','Old Password Not Match ');
                }
            }

        }else{
            return back()->with('error','Password Not Match main');
        }
    }

    // Function For Update Pin
    function UpdatePin(Request $request){
        $pin = $request -> input('new_pin');
        $conn_pin = $request -> input('con_pin');
        $old_pin = $request -> input('old_pin');
        $dist_id = $request->session()->get('user');
        $sql = 'SELECT `pin` FROM `distributor` WHERE distributor_id ="'.$dist_id.'"';
        $db_pin = DB::select($sql);
        if($pin == $conn_pin){
            foreach($db_pin as $pin_data){
                if($old_pin == $pin_data->pin){
                    $check = DB::update('UPDATE `distributor` SET `pin`=? WHERE distributor_id = ?',[$conn_pin,$dist_id]);
                    if($check){
                        return back()->with('message','Pin Change Successfully');
                    }else{
                        return back()->with('error','Pin Not Change');
                    }
                }else{
                    return back()->with('error','Old Pin Not Match ');
                }
            }

        }else{
            return back()->with('error','Pin Not Match main');
        }
    }

    // Function For Return Points To Admin
    function ReturnPoints(Request $request)
    {
        $return_points = $request->input('points');
        $my_pin = $request->input('pin');
        $dist_id = $request->session()->get('user');

        $points = DB::select('SELECT `points` FROM `distributor_points` WHERE distributor_id = ?', [$dist_id]);
        $pin = DB::select('SELECT `pin` FROM `distributor` WHERE distributor_id =?', [$dist_id]);

        foreach ($pin as $pin_data) {
            if ($my_pin == $pin_data->pin) {
                if (count($points) != 0) {
                    foreach ($points as $points_data) {
                        if (($points_data->points != 0) && ($points_data->points > $return_points)) {
                            $admin_notify = array('distributor_id' => $dist_id, 'points' => $return_points, 'status' => 0);
                            $check_admin_notify = DB::table('admin_notification')->insert($admin_notify);
                            if ($check_admin_notify) {
                                $main_admin="Main Admin";
                                $dist_notify = array('sender' => $dist_id, 'reciever' => $main_admin, 'points' => $return_points, 'status' => 0);
                                $check_dist_notify = DB::table('distributor_notification')->insert($dist_notify);
                                if ($check_dist_notify) {
                                    $admin_return_points = array('distributor_id' => $dist_id, 'return_points' => $return_points);
                                    $check_admin_return = DB::table('distributor_return_points')->insert($admin_return_points);
                                    if ($check_admin_return) {
                                        $dist_points = $points_data->points - $return_points;
                                        $main_points = DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id = ?', [$dist_points, $dist_id]);
                                        if ($main_points) {
                                            $request->session()->put('dist_points', $dist_points);
                                            return back()->with('message', 'Points Return');
                                        } else {
                                            return back()->with('error', 'Points Not Returns');
                                        }
                                    } else {
                                        return back()->with('error', 'Points Not Returns');
                                    }
                                } else {
                                    return back()->with('error', 'Points Not Returns');
                                }    
                            } else {
                                return back()->with('error', 'Points Not Returns');
                            }
                        } else {
                            return back()->with('error', 'Insufficient Points');
                        }
                    }
                } else {
                    return back()->with('error', 'Insufficient Points...! Check Your Points And Send');
                }
            } else {
                return back()->with('error', 'Pin Not Match');
            }
        }
    }

    // Function For Display Return Point History
    function ReturnPointsHistory(Request $request){
        $dist_id = $request->session()->get('user');
        $history = DB::select('SELECT `id`, `distributor_id`, `return_points`, `created_at` FROM `distributor_return_points` WHERE distributor_id = ? ORDER BY id DESC',[$dist_id]);
        if(count($history) == 0){
            return view('admin.pages.Setting.ReturnPointsHistory',['data'=>'0']);
        }else{
            $sum_points = collect($history)->sum('return_points');
            return view('admin.pages.Setting.ReturnPointsHistory',array('history'=>$history,'sum_points'=>$sum_points,'data'=>'1'));
        }
    }

    // Function For Show UserReturnPointsHistory
    function UserReturnPointsHistory(Request $request){
        $dist_id = $request->session()->get('user');
        $history = DB::select('SELECT `id`, `distributor_id`, `return_points`, `created_at` FROM `user_return_points` WHERE distributor_id = ?',[$dist_id]);
        if(count($history) == 0){
            return view('admin.pages.Setting.UserReturnPointsHistory',['data'=>'0']);
        }else{
            $sum_points = collect($history)->sum('return_points');
            return view('admin.pages.Setting.UserReturnPointsHistory',array('history'=>$history,'sum_points'=>$sum_points,'data'=>'1'));
        }
    }
}
