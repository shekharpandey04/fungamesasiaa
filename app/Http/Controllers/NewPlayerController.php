<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class NewPlayerController extends Controller
{
    //
    public function create_player_id()
    {
        $get_id = DB::select('select max(id) as id from user');
        foreach ($get_id as $id) {
            $user_id = $id->id;
        }

        $add1 = $user_id + 1;
        $len = strlen($add1);
        $final_user_id = null;
        if ($len == 1 ||  strlen($add1) == 1) {
            $final_user_id = 'FUN00000' . $add1;
        } else if ($len == 2 && strlen($add1) == 2) {
            $final_user_id = 'FUN0000' . $add1;
        } else if ($len == 3 && strlen($add1) == 3) {
            $final_user_id = 'FUN000' . $add1;
        } else if ($len == 4 && strlen($add1) == 4) {
            $final_user_id = 'FUN00' . $add1;
        } else if ($len == 5 && strlen($add1) == 5) {
            $final_user_id = 'FUN0' . $add1;
        } else if ($len == 6 && strlen($add1) == 6) {
            $final_user_id = 'FUN' . $add1;
        }else {
            $final_user_id = 'FUN' . $add1;
        }
        
        return $final_user_id;
    }
    public function new_user(Request $request)
    {
        $final_user_id = $this->create_player_id();
        $dist_id = $request->session()->get('user');
        try{
            $player_list = DB::select('SELECT user.active,user.user_id,user.distributor_id,user.username,user.IsBlocked,user.last_logged_in,user.last_logged_out,user_points.points FROM user LEFT JOIN user_points ON user.user_id =user_points.user_id WHERE user.distributor_id=?',[$dist_id]);
            return view('admin.pages.AddPlayer.AddPlayer', array('user_id' => $final_user_id, 'player_list' => $player_list, 'dist_id' => $dist_id));
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // FUnction For Adding New Player
    function AddNewPlayer(Request $request)
    {
        $dist_id = $request->input('dist_id');
        $player_id = $request->input('player_id');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        try{
            $player_data = array('user_id' => $player_id, 'distributor_id' => $dist_id, 'username' => $username, 'password' => $password);
            $check = DB::table('user')->insert($player_data);
            if ($check) {
                // Redirect::to('/AddNewUser')->with('success', 'Record updated.');
                return back()->with('message', 'Player Inserted.');
            } else {
                return back()->with('error', 'Player Not Inserted.');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // Function For Getting User Info
    function GetUserInfo($user_id)
    {
        try{
            $user_data = DB::select('SELECT `user_id`, `distributor_id`, `username` FROM `user` WHERE user_id=?', [$user_id]);
            if (count($user_data) == 0) {
                return back()->with('error', 'User Data Not Found');
            } else {
                return view('admin.pages.AddPlayer.UpdatePlayer', array('user_data' => $user_data));
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // FUnction For Update User dATA
    function UpdateUserInfo(Request $request, $user_id)
    {
        $username = $request->input('username');
        try{
            $check = DB::update('UPDATE `user` SET `username`=? WHERE user_id =?', [$username, $user_id]);
            if ($check) {
                return back()->with('message', 'Player Info Updated...');
            } else {
                return back()->with('error', 'Player Info Not Updated...');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // Function For Blocked User
    function BlockedUser($user_id)
    {
       try{
           $check = DB::update('UPDATE `user` SET `IsBlocked`=? WHERE user_id =?', [1, $user_id]);
           if ($check) {
               return redirect('/AddNewUser')->with('message', 'Player Blocked...');
            } else {
                return back()->with('error', 'Player Not Blocked...');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }
    // Function For UnBlocked User
    function UnBlockedUser($user_id)
    {
        try{
            $check = DB::update('UPDATE `user` SET `IsBlocked`=? WHERE user_id =?', [0, $user_id]);
            if ($check) {
                return back()->with('message', 'Player UnBlocked...');
            } else {
                return back()->with('error', 'Player Not UnBlocked...');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }
    
    // Function For logout User
    function user_logout($user_id)
    {
        try{

            $last_logged_out = date('Y-m-d h:i:s');
            $active = 0;
            $device = 'ABC!@#45786'; //random
            $logout_user = DB::update('UPDATE `user` SET `last_logged_out`=?,`active`=?,`device`=? WHERE `user_id` =?', [$last_logged_out, 0,$device,$user_id]);
            if ($logout_user == 1) {
                return back()->with('message', 'User Logout Successfully...');
            } else {
                return back()->with('error', 'User Not Logout...');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // Function For Update Player Password
    function UpdatePassword(Request $request, $user_id)
    {
        // $dist_id = $request->input('dist_id');
        $player_id = $request->input('player_id');
        $password = $request->input('password');
        $conn_pass = $request->input('con_pass');
        $final_pass = Hash::make($password);
        try{
            if ($password === $conn_pass) {
                $check = DB::update('UPDATE `user` SET `password`=? WHERE user_id=?', [$final_pass, $player_id]);
                if ($check) {
                    return back()->with('message', 'Password Change Successfully...');
                } else {
                    return back()->with('error', 'Password Not Change...');
                }
            }else{
                return back()->with('error','Password Are not Match...! Try Again');
            }
        }catch(Exception $e){
            dd('Something Went Wrong');
        }
    }

    // Function For Display Player List
    function PlayerList(Request $request){
        $dist_id = $request->session()->get('user');
        $PlayerList = DB::select('SELECT user.active,user.user_id,user.distributor_id,user.username,user.IsBlocked,user.last_logged_in,user.last_logged_out,user_points.points FROM user LEFT JOIN user_points ON user.user_id =user_points.user_id WHERE user.distributor_id=?',[$dist_id]);
        if(count($PlayerList) == 0){
            return back()->with('error','Player Not Found..Add New Player');
        }else{
            return view('admin.pages.PlayerList.PlayerList',array('player_list'=>$PlayerList));
        }
    }
}
