<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class AddNewDistributorController extends Controller
{
    //
    public function create_player_id()
    {
        $get_id = DB::select('select max(id) as id from distributor');
        foreach ($get_id as $id) {
            $dist_id = $id->id;
        }

        $add1 = $dist_id + 1;
        $len = strlen($add1);
        $final_user_id = null;
        if ($len == 1 ||  strlen($add1) == 1) {
            $final_user_id = 'DIS00000' . $add1;
        } else if ($len == 2 && strlen($add1) == 2) {
            $final_user_id = 'DIS0000' . $add1;
        } else if ($len == 3 && strlen($add1) == 3) {
            $final_user_id = 'DIS000' . $add1;
        } else if ($len == 4 && strlen($add1) == 4) {
            $final_user_id = 'DIS00' . $add1;
        } else if ($len == 5 && strlen($add1) == 5) {
            $final_user_id = 'DIS0' . $add1;
        } else if ($len == 6 && strlen($add1) == 6) {
            $final_user_id = 'DIS' . $add1;
        } else {
            $final_user_id = 'DIS' . $add1;
        } 
        return $final_user_id;
    }

    // Function For Create Dist Id
    function create_dist_id(Request $request){
         $admin = $request->session()->get('admin');
         $final_user_id = $this->create_player_id();

         $dist_list = DB::select('SELECT `id`, `distributor_id`, `username`, `percentage`, `pin`, `IsBlocked`, `LastLoggedIn`, `LastLoggedOut`, `active`, `created_at` FROM `distributor`');
         if(count($dist_list) == 0){
             return view('main_admin.pages.AddDist.AddNewDist',array('dist_id'=>$final_user_id,'data'=>"0"));
         }else{
            return view('main_admin.pages.AddDist.AddNewDist',array('dist_id'=>$final_user_id,'dist_list'=>$dist_list,'data'=>"1"));
         }
    }

    // Function for Adding New Distributor
    function AddNewDistributor(Request $request){
        $dist_id = $request -> input('dist_id');
        $username = $request -> input('username');
        $per = $request -> input('percentage');
        $pin = $request -> input('pin');
        $password = Hash::make($request -> input('password'));
        $dist_data = array('distributor_id'=>$dist_id,'username'=>$username,'percentage'=>$per,'password'=>$password,'pin'=>$pin);
        $check = DB::table('distributor')->insert($dist_data);
        if($check){
            $dist_count = DB::select('SELECT * FROM `distributor`');
            $dist_count = count($dist_count);
            $request->session()->forget('dist_count');
            $request->session()->put('dist_count',$dist_count);
            return redirect('/AddNewDistributor')->with('message','Distributor Added Successfully');
        }else{
            return redirect('/AddNewDistributor')->with('error','Distributor Not Added');
        }
    }

    // Function For edit_distributor
    function edit_distributor($id){
        $dist_data = DB::select('SELECT * FROM `distributor` WHERE distributor_id = ?',[$id]);
        if (count($dist_data) == 0) {
            return back()->with('error', 'User Data Not Found');
        } else {
            return view('main_admin.pages.AddDist.UpdateDist', array('user_data' => $dist_data));
        }
    }

    // Functiobn For Blocked Dist
    function BlockedDist($id){
        $check = DB::update('UPDATE `distributor` SET `IsBlocked`= ? WHERE `distributor_id` = ?',[1,$id]);
        if($check){
            return redirect('/AddNewDistributor')->with('message','Distributor Blocked');
        }else{
            return back()->with('error','Distributor Not Blocked');
        }
    }
    // Functiobn For Blocked Dist
    function UnBlockDist($id){
        $check = DB::update('UPDATE `distributor` SET `IsBlocked`= ? WHERE `distributor_id` = ?',[0,$id]);
        if($check){
            return redirect('/AddNewDistributor')->with('message','Distributor UnBlocked');
        }else{
            return back()->with('error','Distributor Not UnBlocked');
        }
    }

    // Function For Update Dist Password
    function UpdateDistPassword($id,Request $request){
        $dist_id = $request -> input('dist_id');
        $password = $request -> input('password');
        $con_pass = $request -> input('con_pass');
        if($password == $con_pass){
            $pass = Hash::make($password);
            $check = DB::update('UPDATE `distributor` SET `password`= ? WHERE distributor_id = ?',[$pass,$dist_id]);
            if($check){
                return back()->with('message','Password Update Successfully');
            }else{
                return back()->with('error','Password Not Updated');
            }
        }else{
            return back()->with('error','Password Not Match');
        }
    }

    // Function For Update User Info
    function UpdateDist($id,Request $request){
        try {
            $user_name = $request -> input('username');
            $percentage = $request -> input('percentage');
            $pin = $request -> input('pin');
            // $user_data = array('username'=>$user_name,'percentage'=>$percentage,'pin'=>$pin);
            $check = DB::update('UPDATE `distributor` SET `username`= ?,`percentage`= ?,`pin`=? WHERE distributor_id = ?',[$user_name,$percentage,$pin,$id]);
            if($check){
                return back()->with('message','User Info Updated');
            }else {
                return back()->with('error','User Not Updated');
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }
}
