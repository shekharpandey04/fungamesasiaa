<?php

namespace App\Http\Controllers;

use App\Mail\SendContactInfo;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Write code on Method
     *
     * @return response()
     */
   

    public function index(){
         return view('firebase');
    }


    public function saveToken(Request $request)
    {
        $saveTok = DB::table('admin')->update(['device_token'=>$request->device_token]);
        return response()->json(['Notification allowed successfully.']);
    }

    
    public function sendNotificationFCM($userId, $notiType='', $ReceiverDeviceTokens='', $title = '', $message = '')
    {
        $DeviceToken = DB::table('admin')->select('device_token')->first();
        if (empty($DeviceToken)) {
            return true;
        } else{
            $ReceiverDeviceTokens = $DeviceToken->device_token;
            $userId = $userId;
            $notiType = 'Android';
            $title = 'FUN GAMES ASIA';
            $message = $userId.' login successfully into device';
            $data = array();
              

            $fcm_key = 'AAAAG7MlQl0:APA91bEHvkCrAfxrrubcqt_ysOseV8v1LTsM7px6eqpsZ0FFJ5uElP6thQ9hamJbsVnLQkchPCOfBelJKM6WnYh90_1BoYY1F8G357DzsvzIc2mRpiA0_mZVR-puutqAoxysjDZaHE7b';

            $key    =   $fcm_key;
            $badge_count    =   1;
            $msg =  array(
                'body'          =>  trim(strip_tags($message)),
                'title'         =>  $title,
                'icon'          => "https://www.fungameasiaa.com/asset/GameImage/logo.png",/*Default Icon*/
                //'matchData'     =>  $data,
                //'type'          =>  $notiType,
                //'image'         => "https://www.fungameasiaa.com/GameImage/user_1.png",
                'badge'         => "https://www.fungameasiaa.com/asset/GameImage/fcm2.png",
                'sound'         =>  'mySound',
                //'sound'         =>  'https://www.fungameasiaa.com/asset/GameImage/msg.mp3',
                'badge_count'   =>  $badge_count,
                'click_action'  =>  'https://www.fungameasiaa.com/',
                "content_available" => true,
                "priority" => "high",
            );

            $fields =   array(
                'to'    =>  $ReceiverDeviceTokens,
                'data'  =>  $msg,
            );

            $headers =  array(
                'Authorization: key=' . $key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $response = curl_exec($ch);
            curl_close($ch);
            return true;
        }
    }



    public function sendNotificationFCMTesting()
    {

        
        $ReceiverDeviceTokens = 'd2sK7FhZUJzW-Q7PRlcJAG:APA91bHaY6bIu2XaI5UuFv3rGLJyrUcfS5JecsASqEhhl12Y3dM_X78VTgXULUhFGeWW3rT3VCGlBQGVEazP9V0bj_Ub5u294POWIhHZpnHExwg1v0_Qy1YftrSJH8ssnHWReUKLv7Xb';
        $userId = 'FUN000001';
        $notiType = 'Android';
        $title = 'FUN GAMES ASIA';
        $message = $userId.' login successfully into device';
        $data = array();
          

        if ($ReceiverDeviceTokens == '') {
            return true;
        } else {
            if (empty($data)) {
                $mtDate = '';
            } else {
                $mtDate = serialize($data);
            }


            $fcm_key = 'AAAAG7MlQl0:APA91bEHvkCrAfxrrubcqt_ysOseV8v1LTsM7px6eqpsZ0FFJ5uElP6thQ9hamJbsVnLQkchPCOfBelJKM6WnYh90_1BoYY1F8G357DzsvzIc2mRpiA0_mZVR-puutqAoxysjDZaHE7b';

            $key    =   $fcm_key;
            $badge_count    =   1;
            $msg =  array(
                'body'          =>  trim(strip_tags($message)),
                'title'         =>  $title,
                'icon'          => "https://www.fungameasiaa.com/GameImage/logo.png",/*Default Icon*/
                'matchData'     =>  $data,
                //'type'          =>  $notiType,
                //'image'         => "https://www.fungameasiaa.com/GameImage/user_1.png",
                'badge'         => "https://www.fungameasiaa.com/GameImage/admin.png",
                'sound'         =>  'mySound',
                'badge_count'   =>  $badge_count,
                'click_action'  =>  'https://www.fungameasiaa.com/',
                "content_available" => true,
                "priority" => "high",
            );

            $fields =   array(
                'to'    =>  $ReceiverDeviceTokens,
                'data'  =>  $msg
            );

            $headers =  array(
                'Authorization: key=' . $key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $response = curl_exec($ch);
            curl_close($ch);
            return true;
        }
    }




    // Function For Send Mail To
    function SendInfo(Request $request)
    {
        $name = $request->input('name');
        $number = $request->input('number');
        $email = $request->input('email');
        $location = $request->input('location');
        $location = $request->input('location');
        $message = $request->input('message');
        $data = new \stdClass();
        $data->name = $name;
        $data->mobile_no = $number;
        $data->email = $email;
        $data->location = $location;
        $data->message = $message;
        Mail::to('fungamesasia15@gmail.com')->send(new SendContactInfo($data));
        return back()->with('message', 'Contact Infomation Send Successfully');
    }

    // Function For Dummy Login
    function DummyLogin(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $password = $request->input('password');

            $log_data = DB::select('SELECT * FROM `user` WHERE user_id = ?', [$user_id]);
            //print_r($log_data);die;
            if (count($log_data) == 0) {
                return back()->with('error', 'User Not Found');
            } else {
                foreach ($log_data as $data) {
                    if ($data->IsBlocked == 0) {
                        if (Hash::check($password, $data->password)) {
                            return view('DummyTable', array('data' => $log_data, 'user_id' => $user_id));
                        } else {
                            return back()->with('error', 'Username Or Password Not Match..');
                        }
                    } else {
                        return back()->with('error', 'Your Account is Blocked. Please Contact Administrator.');
                    }
                }
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    function CheckDeviceId ($user_id,$device_id){
        $login_device = DB::select('SELECT `device` FROM `user` WHERE user_id=? AND device=? ', [$user_id, $device_id]);

        if(count($login_device) != 0){
            return true;
        }else{
            return false;
        }
    }

   

    public function GameTimer($game_id){
        $fields =   array(
            'game_id'=>(int)$game_id,
        );
        
        $headers =  array(
            'Content-Type: application/json'
        );

        $Game_Url = Config('constants.FUN_GAME_URL');
        $End_Point = '/getTimer';
        $URL = $Game_Url.$End_Point;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);//http://localhost/Practice/practice.php
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
           echo "cURL Error #:" . $err;
        }  

        $result = json_decode($response);
        $timer = $result->timer;
        return $timer;
    }

    // Function For Send Mail To
    public function SendContactInfo(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $name = $request->input('name');
        $number = $request->input('number');
        $email = $request->input('email');
        $location = $request->input('location');
        $message = $request->input('message');

        if(!empty($name) && !empty($number) && !empty($email) && !empty($location) && !empty($message) ){ 
            $data = new \stdClass();
            $data->name = $name;
            $data->mobile_no = $number;
            $data->email = $email;
            $data->location = $location;
            $data->message = $message;
            $check = Mail::to('fungamesasia15@gmail.com')->send(new SendContactInfo($data));
            if( count(Mail::failures()) > 0 ) {
                $response['status'] = false;
                $response['message'] = 'Failed To Send Contact Infomation.';
            } else {
                $response['status'] = true;
                $response['message'] = 'Contact Infomation Send Successfully.';
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Please filled all details.';

        }    
        return response()->json($response);
    }


}
