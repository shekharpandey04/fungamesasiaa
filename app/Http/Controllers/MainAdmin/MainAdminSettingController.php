<?php

namespace App\Http\Controllers\MainAdmin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainAdminSettingController extends Controller
{
    // Function For Change Main Admin Password
    function UpdateMainAdminPassword(Request $request)
    {
        try {
            $MainAdmin = $request->input('admin');
            $old_pass = $request->input('old_pass');
            $new_pass = $request->input('new_pass');
            $con_pass = $request->input('con_pass');
            if ($new_pass == $con_pass) {
                $data = DB::select('SELECT * FROM `admin` WHERE username = ?', [$MainAdmin]);
                if (count($data) != 0) {
                    foreach ($data as $log_data) {
                        if ($log_data->password == $old_pass) {
                            $check = DB::update('UPDATE `admin` SET `password`= ? WHERE username = ?', [$con_pass, $MainAdmin]);
                            if ($check) {
                                return back()->with('message', 'Password Update Successfully.');
                            } else {
                                return back()->with('message', 'Password Not Updated.');
                            }
                        } else {
                            return back()->with('error', 'Old Password Not Match.');
                        }
                    }
                } else {
                    return back()->with('error', 'User Not Found.');
                }
            } else {
                return back()->with('error', 'Password Not Match.');
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    // Function For Update Main Admin Pin
    function UpdateMainAdminPin(Request $request)
    {
        try {
            $mainAdmin = $request->input('MainAdmin');
            $old_pin = $request->input('old_pin');
            $new_pin = $request->input('new_pin');
            $con_pin = $request->input('con_pin');
            if ($new_pin == $con_pin) {
                $data = DB::select('SELECT * FROM `admin` WHERE username = ?', [$mainAdmin]);
                if (count($data) != 0) {
                    foreach ($data as $log_data) {
                        if ($log_data->pin == $old_pin) {
                            $check = DB::update('UPDATE `admin` SET `pin`= ? WHERE username = ?', [$con_pin, $mainAdmin]);
                            if ($check) {
                                return back()->with('message', 'Pin Update Successfully.');
                            } else {
                                return back()->with('message', 'Pin Not Updated.');
                            }
                        } else {
                            return back()->with('error', 'Old Pin Not Match.');
                        }
                    }
                } else {
                    return back()->with('error', 'User Not Found.');
                }
            } else {
                return back()->with('error', 'Pin Not Match.');
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    function SetWinNo(Request $request)
    {
        $current_round = DB::select('select round_count from current_bet ORDER BY id DESC LIMIT ?', [1]);
        if ($current_round) {
            foreach ($current_round as $curr_round) {
                $round_count = $curr_round->round_count;

                if ($round_count != 0) {
                    $request->session()->put('count', $round_count);
                    return view('main_admin.pages.Setting.SetWinNo');
                } else {
                    $request->session()->put('count', 'Round count not found');
                    return view('main_admin.Main_Dashboard');
                }
            }
        } else {
            $request->session()->put('count', 'Current Bet Data Fetching Error.');
            return view('main_admin.Main_Dashboard');
        }
    }

    // Function For get Maximum 2X OR 4X
    function SetMaxWinX()
    {
        $data = DB::select('SELECT * FROM `set_max_2x_4x`');
        if (count($data) == 0) {
            return view('main_admin.pages.Setting.SetMaxWinX', array('data' => '0'));
        } else {

            return view('main_admin.pages.Setting.SetMaxWinX', array('result' => $data, 'data' => '1',));
        }
    }



    // Function For update maximum 2X OR 4X
    function UpdateMaxWinx(Request $request)
    {   
        $Win_x = $request->input('select_action');
        $Max_Winx = $request->input('points');
        $pin = $request->input('pin');
        $date = date('Y-m-d h:i:s');
        try {
                $pin_data = DB::select('SELECT * FROM `admin`');
                foreach ($pin_data as $data_pin) {
                    if ($data_pin->pin == $pin) {
                        $check_Winx = DB::select('SELECT * FROM `set_max_2x_4x` WHERE Win_x= ?', [$Win_x]);
                        if (count($check_Winx) == 0) {
                            $SetArray = array('Win_x' => $Win_x, 'Max_Winx_Count' => $Max_Winx,'updated'=>$date);
                            $id = DB::table('set_max_2x_4x')->insertGetId($SetArray);
                            if ($id) {
                                return back()->with('message', $Win_x.'mode added Successfully...');
                            } else {
                                return back()->with('error', 'Something Went Wrong.....Winx not added');
                            }
                        } else {
                            $check= DB::update('UPDATE `set_max_2x_4x` SET `Max_Winx_Count`=?,`updated`=? WHERE Win_x=?', [$Max_Winx,$date,$Win_x]);
                            if ($check) {
                                return back()->with('message', $Win_x.' mode Successfully updated...');
                            } else {
                                return back()->with('error', 'Something Went Wrong.....Winx not updated');
                            }
                        }
                    } else {
                        return back()->with('error', 'Pin Not Match');
                    }
                }
           
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Function For set limit of Winning Bet
    function SetWinningBetLimit()
    {
        $data = DB::select('SELECT * FROM `prime_mode`');
        if (count($data) == 0) {
            return view('main_admin.pages.Setting.SetWinningBetLimit', array('data' => '0'));
        } else {

            return view('main_admin.pages.Setting.SetWinningBetLimit', array('result' => $data, 'data' => '1',));
        }
    }

    // Function For update maximum 2X OR 4X
    function UpdateMaxBetLimit(Request $request)
    {   
        $max_limit = $request->input('limit');
        $pin = $request->input('pin');
        $date = date('Y-m-d h:i:s');
        try {
                $pin_data = DB::select('SELECT * FROM `admin`');
                foreach ($pin_data as $data_pin) {
                    if ($data_pin->pin == $pin) {
                        $record = DB::select('SELECT * FROM `prime_mode` limit 1');
                        if (count($record) == 0) {
                            $SetArray = array('max_limit' => $max_limit,'created'=>$date,'updated'=>$date );
                            $id = DB::table('prime_mode')->insertGetId($SetArray);
                            if ($id) {
                                return back()->with('message', $max_limit.' limit added Successfully...');
                            } else {
                                return back()->with('error', 'Something Went Wrong.....Limit not added');
                            }
                        } else {
                            $record_id = $record[0]->id;
                            $check= DB::update('UPDATE `prime_mode` SET `max_limit`=?,`updated`=? WHERE id=?', [$max_limit,$date,$record_id]);
                            if ($check) {
                                return back()->with('message', $max_limit.' limit Successfully updated...');
                            } else {
                                return back()->with('error', 'Something Went Wrong.....limit not updated');
                            }
                        }
                    } else {
                        return back()->with('error', 'Pin Not Match');
                    }
                }
           
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    

    // Function For Update Apk Version
    function UpdateVersion(Request $request)
    {
        try {

            $apk_version = $request->input('apk_version');

            $check = DB::table('setting')->update(['apk_version' => $apk_version ]);

            if ($request->hasFile('apk')) {
                $file = $request->file('apk');
                $name = $file->getClientOriginalName();
                $destinationPath = public_path('/app');
                $file->move($destinationPath, $name);
                return back()->with('message', 'Apk updated successfully..');
            }

            if($check) {
                return back()->with('message', 'Apk Version updated successfully..');
            } else{
                return back()->with('error', 'Verion Code Not Updated.');
            }
            
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    //Function For set 2X OR 4X Image Image
    // function ActiveImage($x)
    // {
    //     try {

    //         if ($x == 2) {
    //             $check = DB::update('UPDATE `app_image` SET `active`=? WHERE id=?', [$x, 2]);
    //             if ($check) {
    //                 return back()->with('message', '2X Active Successfully.');
    //             } else {
    //                 return back()->with('error', '2X Aalready Active..please DeActive 4X.', ['data' => '1']);
    //             }
    //         } else {
    //             $check = DB::update('UPDATE `app_image` SET `active`=? WHERE id=?', [$x, 3]);
    //             if ($check) {
    //                 return back()->with('message', '4X Active Successfully.');
    //             } else {
    //                 return back()->with('error', '4X Already Active..please DeActive 4X.');
    //             }
    //         }
    //     } catch (Exception $th) {
    //         dd($th->getMessage());
    //     }
    // }

    //Function For Reset 2X OR 4X Image Image
    // function DeActiveImage($x)
    // {
    //     try {
    //         if ($x == 2) {
    //             $check = DB::update('UPDATE `app_image` SET `active`=? WHERE id=?', [1, 2]);
    //             if ($check) {
    //                 return back()->with('message', '2X DeActive Successfully.');
    //             } else {
    //                 return back()->with('error', '2X Already DeActive..');
    //             }
    //         } else {
    //             $check = DB::update('UPDATE `app_image` SET `active`=? WHERE id=?', [1, 3]);
    //             if ($check) {
    //                 return back()->with('message', '4X DeActive Successfully.');
    //             } else {
    //                 return back()->with('error', '4X Already DeActive..');
    //             }
    //         }
    //     } catch (Exception $th) {
    //         dd($th->getMessage());
    //     }
    // }

    // Function For Show Current bet And History
    function ShowCurrentBet()
    {
        try {
            $data = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC LIMIT 0, 1');
            if (count($data) == 0) {
                return back()->with('error', 'Current Bet Not Found', ['data' => 0]);
            } else {
                return view('main_admin.pages.Setting.ShowCurrentBet', array('bet_data' => $data, 'data' => 1));
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    // Function For Show All Current Bet
    function ShowAllCurrentBet()
    {
        // $betdata['data'] = DB::select('SELECT * FROM `current_bet`');
        $betdata['data'] = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC limit ?', [3000]);
        echo json_encode($betdata);
        exit;
    }

    // Function For Set Win Number
    function AddWinNumber(Request $request)
    {
        try {
            $win_no = $request->input('win_no');
            $win_x = $request->input('win_x');
            $no = explode('_', $win_no);
            $win_no = $no[1];
            $game_id = 3;

            if ($win_x == '') {
                $win_x = '1x';
            }
            $n_mode = DB::select('SELECT * FROM `night_mode`');
            $p_mode = DB::select('SELECT * FROM `prime_mode` limit 1');
            if (count($n_mode) != 0 && count($p_mode) != 0) {

                foreach ($n_mode as $n_data) {
                    $night_mode = $n_data->mode;
                }

                foreach ($p_mode as $p_data) {
                    $prime_mode = $p_data->mode;
                }

                if ($night_mode == 0 && $prime_mode == 0) {
                    $current_round = DB::select('select round_count from current_round ORDER BY cr_id DESC LIMIT ?', [1]);
                    if ($current_round) {
                        foreach ($current_round as $current_data) {
                            $cuu_round = $current_data->round_count;
                        }
                        // $timestamp = time() + date("Z");
                        // $sec = gmdate("s", $timestamp);
                        $sec = $this->GameTimer($game_id);
                        if (($sec > 10) && ($sec < 54)) {
                            $check = DB::update('UPDATE `current_round` SET `win_no`=?,`win_x`=? WHERE round_count = ?', [$win_no, $win_x, $cuu_round]);
                            if ($check) {
                                $round_win_no_win_x = array('round_count' => $cuu_round, 'win_X' => $win_x, 'win_no' => $win_no, 'game' => 3);
                                $check = DB::table('win_no_win_x')->insert($round_win_no_win_x);
                                if ($check) {
                                    return back()->with('message', 'Win Number ' . $win_no . ' And Win X Is ' . $win_x . ' Set For Round Number ' . $cuu_round . '.');
                                } else {
                                    return back()->with('error', 'Something Went Wrong.. ' . $win_no . ' And ' . $win_x . ' This Is Not Set in win_no_win_x table.');
                                }
                            } else {
                                return back()->with('error', 'Something Went Wrong.. ' . $win_no . ' And ' . $win_x . ' This Is Not Set.');
                            }
                        } elseif ($sec < 10) {
                            return back()->with('error', 'Hold Some Time');
                        } elseif ($sec >= 54) {
                            return back()->with('error', 'Time Out.');
                        }
                    } else {
                        return back()->with('error', 'Something Went Wrong.. Current Round Not Found.');
                    }
                } else {
                    return back()->with('error', 'Night Mode Is On.');
                }
            } else {
                return back()->with('error', 'Something Went Wrong.. Current Round Not Found.');
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    // Function For Reset Win Number
    // function ResetWinNumber()
    // {
    //     $check = DB::update('UPDATE `win_no` SET `active`=? WHERE active = ?', [0, 1]);
    //     if ($check) {
    //         return back()->with('message', 'Win Number Reset Successfully.');
    //     } else {
    //         return back()->with('error', 'Win Number Not Reset.');
    //     }
    // }

    // Function For Main Admin Notify
    function MainAdminNotify($id, Request $request)
    {
        $notify_data = DB::select('SELECT * FROM `admin_notification` WHERE id = ?', [$id]);
        if (count($notify_data) == 0) {
            return view('main_admin.pages.DisplayMainAdminNotification', ['data' => 1]);
        } else {
            foreach ($notify_data as $data) {
                if (($data->status) != 1) {
                    DB::update('UPDATE `admin_notification` SET `admin_read`=? WHERE id = ?', [0, $id]);
                }
                 $data = DB::select('SELECT * FROM `admin_notification` WHERE admin_read = ?', [1]);
                // $request->session()->put('admin_notify_data', $data);
                $notify_count = count($data);
                $request->session()->put('admin_notify_count', $notify_count);
            }
            return view('main_admin.pages.DisplayMainAdminNotification', ['data' => 1, 'notify_data' => $notify_data]);
        }
    }

    // Function For  Delete All Notification
    function DeleteAllNotification(Request $request)
    {
        $notify_data = DB::select('SELECT * FROM `admin_notification`');
        if (count($notify_data) == 0) {
            return back()->with('message1', 'Notification Empty');
        } else {
            $check1 = DB::table('admin_notification')->delete();
            //$check2 = DB::table('admin_notification')->whereIn('status', [0,1,2,3])->update(['admin_read'=>0]);
            if ($check1) {
                $notify_count = 0;
                $request->session()->put('admin_notify_count', $notify_count);
                return back()->with('message1', 'All notification delete Successfully');
            } else {
                return back()->with('error1', 'Notification not delete');
            }
        }
    }

    //Function For Main Admin Night Mode
    function changeNightMode()
    {
        $n_mode = DB::select('SELECT * FROM `night_mode`');
        if (count($n_mode) != 0) {
            foreach ($n_mode as $data) {
                $night_mode = $data->mode;
                if ($night_mode == 0) {

                    $check = DB::update('UPDATE `night_mode` SET `mode`=1 WHERE id = 1');
                    if ($check) {
                        return back()->with('message1', 'Night Mode switch on Successfully');
                    } else {
                        return back()->with('error1', 'Night Mode Not change');
                    }
                }
                if ($night_mode == 1) {

                    $check = DB::update('UPDATE `night_mode` SET `mode`=0 WHERE id = 1');
                    if ($check) {
                        return back()->with('message1', 'Night Mode switch off Successfully');
                    } else {
                        return back()->with('error1', 'Night Mode not change');
                    }
                }
            }
        }
    }

    //Function For Main Admin Joker Mode
    function changeJokerMode()
    {
        $j_mode = DB::select('SELECT * FROM `joker`');
        if (count($j_mode) != 0) {
            foreach ($j_mode as $data) {
                $joker = $data->mode;
                if ($joker == 0) {

                    $check = DB::update('UPDATE `joker` SET `mode`=1 WHERE id = 1');
                    if ($check) {
                        return back()->with('message1', 'Joker switch on Successfully');
                    } else {
                        return back()->with('error1', 'Joker Not change');
                    }
                }
                if ($joker == 1) {

                    $check = DB::update('UPDATE `joker` SET `mode`=0 WHERE id = 1');
                    if ($check) {
                        return back()->with('message1', 'Joker switch off Successfully');
                    } else {
                        return back()->with('error1', 'Joker not change');
                    }
                }
            }
        }
    }


    //Function For Main Admin Prime Mode
    function changePrimeMode()
    {
        $p_mode = DB::select('SELECT * FROM `prime_mode` limit 1');
        if (count($p_mode) != 0) {
            foreach ($p_mode as $data) {
                $prime = $data->mode;
                $mode =  ($prime == 0) ? 1 : 0;
                $check  = DB::update('UPDATE `prime_mode` SET `mode`=? WHERE id = ?', [$mode, 1]);
                if($check) {
                    DB::update('UPDATE `night_mode` SET `mode`=? WHERE id = ?', [0, 1]);
                    DB::update('UPDATE `joker` SET `mode`=? WHERE id = ?', [0, 1]);
                    $status = ($prime == 0) ? 'on' : 'off';
                    return back()->with('message1', 'Prime switch ' .$status. ' Successfully');
                } 
            }
        } 
        return back()->with('error1', 'Prime mode Not change');
    }
}
