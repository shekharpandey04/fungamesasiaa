<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserLogInController extends Controller
{

    //Functin For Check User Login
   function user_login(Request $request)
    {
        try {
            $username = $request->input('user_id');
            $password = $request->input('password');
            $IMEI = $request->input('imei');
            $device = $request->input('device');

            $login_data = DB::select('SELECT * FROM user WHERE user_id=?', [$username]);
            // print_r($login_data);die
            if (count($login_data) != 0) {
                foreach ($login_data as $logdata) {
                    $message = array();
                    if ($logdata->IsBlocked != 1) {
                        if (Hash::check($password, $logdata->password)) {
                            $bal = DB::select('SELECT points FROM `user_points` WHERE user_id=?', [$username]);
                            $new_phone = DB::select('SELECT `IMEI_no`, `last_logged_in`,`active` FROM `user` WHERE user_id=?', [$username]);
                            foreach ($new_phone as $check_new_user) {
                                if ($check_new_user->active == 0) {
                                    $last_logged_in = date('Y-m-d h:i:s');
                                    DB::update('UPDATE `user` SET `last_logged_in`=?, `IMEI_no`=?,device=? WHERE user_id =?', [$last_logged_in, $IMEI, $device, $username]);
                                    if (count($bal) == 0) {
                                        $message['message'] = 'Login Successfully';
                                        $message['status'] = "200";
                                        $message['coins'] = "0";
                                        $message['round_count'] = 12354;
                                        $message['device'] = $device;
                                        $message['user_id'] = $logdata->user_id;
                                        $response['user_data'] = $message;
                                    } else {
                                        foreach ($bal as $points) {
                                            $message['message'] = 'Login Successfully';
                                            $message['status'] = "200";
                                            $message['coins'] = "$points->points";
                                            $message['round_count'] = 12354;
                                            $message['device'] = $device;
                                            $message['user_id'] = $logdata->user_id;
                                            $response['user_data'] = $message;
                                        }
                                    }
                                    DB::update('UPDATE `user` SET `active`=? WHERE user_id =?', [1, $username]);
                                } else {

                                    $message['message'] = 'You have active session from other location do you want close that ??';
                                    $message['status'] = "202";
                                    $response['user_data'] = $message;
                                }
                            }
                        } else {
                            $message['message'] = 'Username and Password Incorrect';
                            $message['status'] = "404";
                            $response['user_data'] = $message;
                        }
                    } else {
                        $message['message'] = 'Your Account is Blocked. Please Contact Administrator.';
                        $message['status'] = "203";
                        $response['user_data'] = $message;
                    }
                }
            } else {
                $message['message'] = 'User Not Found';
                $message['status'] = "404";
                $response['user_data'] = $message;
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            $message['message'] = 'Something Went Wrong';
            // $response['user_data'] = 'Your Internet Connection Is Slow ';
            // dd('Something Went Wrong');
            $response = $message;
        }
        return response()->json($response);
    }

    // Function For User Notification
    function UserNotification(Request $request)    
    {
         $user_id = $request->input('user_id');

        $user_notify = DB::select('SELECT `id`,`sender`,`reciever`,`points`,`created_at` FROM `user_notification` WHERE reciever=? AND status=? AND user_read=?', [$user_id, 1, 1]);
        if (count($user_notify) != 0) {
            $notification_count = count($user_notify);
            $message['status'] = "200";
            $message['message'] = 'Data Loading';
            $message['notification_count'] = $notification_count;
            $message['notification'] = $user_notify;
            $response['user_data'] = $message;
        } else {
            $message['status'] = "200";
            $message['message'] = 'Data Loading';
            $message['notification_count'] = 0;
            $message['notification'] = 'NULL';
            $response['user_data'] = $message;
        }
        return response()->json($response);
    }
    
    // Function For Sender Notification
    function SenderNotification(Request $request)    
    {
        $user_id = $request->input('user_id');

        $user_notify = DB::select('SELECT `id`,`sender`,`reciever`,`points`,`created_at` FROM `user_notification` WHERE sender=? AND status=? AND user_read=?', [$user_id, 1, 1]);
        if (count($user_notify) != 0) {
            $notification_count = count($user_notify);
            $message['status'] = "200";
            $message['message'] = 'Data Loading';
            $message['notification_count'] = $notification_count;
            $message['notification'] = $user_notify;
            $response['user_data'] = $message;
        } else {
            $message['status'] = "200";
            $message['message'] = 'Data Loading';
            $message['notification_count'] = 0;
            $message['notification'] = 'NULL';
            $response['user_data'] = $message;
        }
        return response()->json($response);
    }
    
    // Function For User Logout
    function user_logout(Request $request)
    {
        $user_id = $request->input('user_id');
        $last_logged_out = date('Y-m-d h:i:s');
        // DB::update('UPDATE `user` SET `last_logged_in`=? WHERE user_id =?',[$last_logged_in,$username]);
        $active = 0;
        $logout_user = DB::update('UPDATE `user` SET `last_logged_out`=?,`active`=? WHERE `user_id` =?', [$last_logged_out, 0, $user_id]);
        if ($logout_user == 1) {
            $message['message'] = 'User Logout Successfully';
            $message['status'] = "200";
            $response['user_data'] = $message;
        } else {
            $message['message'] = 'User Not Logout';
            $message['status'] = "404";
            $response['user_data'] = $message;
        }

        return response()->json($response);
    }

    // Function For User Notification Read
    function UserNotificationRead(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status != 1) {
            $check =  DB::update('UPDATE `user_notification` SET `user_read`=? WHERE id=?', [0, $id]);
            if ($check) {
                $message['status'] = "200";
                $message['message'] = 'Read Successfully';
                $response['user_data'] = $message;
            } else {
                $message['status'] = "404";
                $message['message'] = 'Notification Readading error';
                $response['user_data'] = $message;
            }
        } else {
            $message['status'] = "200";
            $message['message'] = 'Read Successfully';
            $response['user_data'] = $message;
        }

        return response()->json($response);
    }
    
    // Function For User Return Point
    function UserReturnPoints(Request $request)
    {
        $user_id = $request->input('user_id');
        $return_points = $request->input('points');
        $password = $request -> input('password');
        $get_password = DB::select('SELECT `distributor_id`,`password` FROM `user` WHERE user_id = ?',[$user_id]);
        foreach($get_password as $get_pass){
            if(Hash::check($password, $get_pass->password)){
                $main_point = DB::select('SELECT `points` FROM `user_points` WHERE user_id = ?', [$user_id]);
                if (count($main_point) == 0) {
                    $message['message'] = 'Insufficient Points';
                    $message['status_code'] = '404';
                    $response['return_points_data'] = $message;
                } else {
                    foreach ($main_point as $main_points) {
                        if ($main_points->points == 0) {
                            $message['message'] = 'Insufficient Points..! 0 Points Available';
                            $message['status_code'] = '404';
                            $response['return_points_data'] = $message;
                        } else {
                            if ($return_points > $main_points->points) {
                                $message['message'] = 'Insufficient Points..! Your Points Is Low';
                                $message['status_code'] = '404';
                                $response['return_points_data'] = $message;
                            }else{
                               $user_return_points = $main_points->points - $return_points;
                               $update_points = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?',[$user_return_points,$user_id]);
                               if($update_points){
                                   $dist_notify = array('distributor_id'=>$get_pass->distributor_id,'user_id'=>$user_id,'return_points'=>$return_points);
                                   $check_dist_notify = DB::table('distributor_notification')->insert($dist_notify);
                                   if($check_dist_notify){
                                       $get_dist_point = DB::select('SELECT `distributor_id`, `points` FROM `distributor_points` WHERE distributor_id = ?',[$get_pass->distributor_id]);
                                       foreach($get_dist_point as $get_dist_points){
                                        $update_Dist_points = $get_dist_points->points + $return_points;
                                        DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id = ?',[$update_Dist_points,$get_pass->distributor_id]);
                                       }
                                       $bal = DB::select('SELECT points FROM `user_points` WHERE user_id=?', [$user_id]);
                                       foreach($bal as $disp_bal){

                                           $message['message'] = 'Points Return Successfully';
                                           $message['status_code'] = '200';
                                           $message['points'] = $disp_bal->points;
                                           $response['return_points_data'] = $message;
                                       }
                                   }else{
                                    $message['message'] = 'Points Not Return';
                                    $message['status_code'] = '404';
                                    $response['return_points_data'] = $message;
                                   }
                               }

                            }
                        }
                    }
                }
            }else{
                $message['message'] = 'Password Not Mathch';
                $message['status_code'] = '404';
                $response['return_points_data'] = $message;
            }
        }
        return response()->json($response);
    }

    // Function For Show user_return_points_history
    function user_return_points_history(Request $request){
        $user_id = $request -> input('user_id');
        $history = DB::select('SELECT `user_id`, `return_points`, `created_at` FROM `user_return_points` WHERE user_id = ?',[$user_id]);
        $temp = array();
        foreach($history as $return_points_history){
            $message = array();
            $message['user_id'] = $return_points_history->user_id;
            $message['return_points'] = $return_points_history->return_points;
            $message['datetime'] =  $return_points_history->created_at;
            array_push($temp,$message);
        }
        $response['message'] = 'Return Point History';
            $response['status_code'] = '200';
        $response['return_point_history'] = $temp;
        return response()->json($response);
    }

    // Function For Update IMEI Number
    function UpdateIMEINumber(Request $request){
        try{

            $user_id = $request->input('user_id');
            $password = $request->input('password');
            $IMEI = $request->input('imei');
            $check_update_data = DB::update('UPDATE `user` SET `IMEI_no`=? WHERE user_id = ?',[$IMEI,$user_id]);
            if($check_update_data){
                $login_data = DB::select('SELECT * FROM user WHERE user_id=?', [$user_id]);
                // print_r($login_data);die
                if (count($login_data) != 0) {
                    foreach ($login_data as $logdata) {
                        $message = array();
                        if ($logdata->IsBlocked != 1) {
                            if (Hash::check($password, $logdata->password)) {
                                $bal = DB::select('SELECT points FROM `user_points` WHERE user_id=?', [$user_id]);
                                $new_phone = DB::select('SELECT `IMEI_no`, `last_logged_in` FROM `user` WHERE user_id=?', [$user_id]);
                                foreach ($new_phone as $check_new_user) {
                                    if ($check_new_user->IMEI_no == NULL) {
                                        $last_logged_in = date('Y-m-d h:i:s');
                                        DB::update('UPDATE `user` SET `last_logged_in`=?, `IMEI_no`=? WHERE user_id =?', [$last_logged_in, $IMEI, $user_id]);
                                        if (count($bal) == 0) {
                                            $message['message'] = 'Login Successfully';
                                            $message['status'] = "200";
                                            $message['coins'] = "0";
                                            $message['round_count'] = 12354;
                                            $message['user_id'] = $logdata->user_id;
                                            $response['user_data'] = $message;
                                        } else {
                                            foreach ($bal as $points) {
                                                $message['message'] = 'Login Successfully';
                                                $message['status'] = "200";
                                                $message['coins'] = "$points->points";
                                                $message['round_count'] = 12354;
                                                $message['user_id'] = $logdata->user_id;
                                                $response['user_data'] = $message;
                                            }
                                        }
                                        DB::update('UPDATE `user` SET `active`=? WHERE user_id =?', [1, $user_id]);
                                    } else {
                                        if ($check_new_user->IMEI_no == $IMEI) {
                                            $last_logged_in = date('Y-m-d h:i:s');
                                            DB::update('UPDATE `user` SET `last_logged_in`=? WHERE user_id =?', [$last_logged_in, $user_id]);
                                            if (count($bal) == 0) {
                                                $message['message'] = 'Login Successfully';
                                                $message['status'] = "200";
                                                $message['coins'] = "0";
                                                $message['round_count'] = 12354;
                                                $message['user_id'] = $logdata->user_id;
                                                $response['user_data'] = $message;
                                            } else {
                                                foreach ($bal as $points) {
                                                    $message['message'] = 'Login Successfully';
                                                    $message['status'] = "200";
                                                    $message['coins'] = "$points->points";
                                                    $message['round_count'] = 12354;
                                                    $message['user_id'] = $logdata->user_id;
                                                    $response['user_data'] = $message;
                                                }
                                            }
                                            DB::update('UPDATE `user` SET `active`=? WHERE user_id =?', [1, $user_id]);
                                        } else {
                                            $message['message'] = 'Active Session is Currently Running in Other Device. You Want to STOP it.';
                                            $message['status'] = "404";
                                            $response['user_data'] = $message;
                                        }
                                    }
                                }
                            } else {
                                $message['message'] = 'Username and Password Incorrect';
                                $message['status'] = "404";
                                $response['user_data'] = $message;
                            }
                        } else {
                            $message['message'] = 'Your Account is Blocked. Please Contact Administrator.';
                            $message['status'] = "404";
                            $response['user_data'] = $message;
                        }
                    }
                } else {
                    $message['message'] = 'User Not Found';
                    $message['status'] = "404";
                    $response['user_data'] = $message;
                }
            }else{
                $message['message'] = 'Can Not STOP Active Session, Please Try Again';
                $message['status'] = '404';
                $response['user_data'] = $message;
            }
        }catch(Exception $e){
            $message['message'] = ''.$e->getMessage().'';
            $message['status_code'] = '400';
            $response['user_data'] = $message;
        }
        return response()->json($response);
    }

    // Function For Geting Image
    function get_image(){
       try{
           $images = DB::select('SELECT `id`, `image_name`, `active` FROM `app_image`');
           $response['message'] = 'Image Loading';
           $response['status'] = "200";
           $temp = array();
           foreach($images as $images_data){
               $message['id'] = "".$images_data->id."";
               $message['image_name'] = $images_data->image_name;
               $message['active'] = "".$images_data->active."";
               array_push($temp,$message);

           }
   $response['user_data'] = $temp;

       }catch(Exception $e){
           $message['message'] = ''.$e->getMessage().'';
           $message['status_code'] = '400';
           $response['user_data'] = $message;
       }
       return response()->json($response);
    }
    
    // Function For Change Password
    function ChangePassword(Request $request)
    { 
        try {
            $user_id = $request->input('user_id');
            $password = Hash::make($request->input('password'));
            
            $check = DB::update('UPDATE `user` SET `password`= ? WHERE user_id = ?', [$password, $user_id]);
            if ($check) {
                $response['message'] = 'Password Change Successfully';
                $response['status'] = '200';
            } else {
                $response['message'] = 'Something Went Wrong...! Password Not Change';
                $response['status'] = '404';
            }
        } catch (Exception $e) {
            $response['message'] = '' . $e->getMessage() . '';
            $response['status'] = '404';
        }
        return response()->json($response);
    }

}
