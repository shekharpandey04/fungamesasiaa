<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReportController extends Controller
{
     // function for current round
    function CurrentRound(Request $request)
    {
        $erro = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        
        if (count($erro) == 0) {
            $user_id = $request->input('user_id');
            $game_id = $request->input('game');
            $message = array();
            $device  = $request->input('device');
            $date = date('Y-m-d h:i:s');

            $check_device = $this->CheckDeviceId ($user_id,$device);
            if($check_device){

                $current_round = DB::select('select round_count from current_round ORDER BY cr_id DESC LIMIT ?', [1]);

                if ($current_round) {

                    foreach ($current_round as $current_data) {
                        $cuu_round = $current_data->round_count;
                    }

                    $report_data = DB::select('SELECT ar_id,`win_X`, `win_no`,game FROM `admin_round_report` WHERE game=? GROUP BY round_count HAVING COUNT(*) ORDER BY ar_id DESC LIMIT ?', ["$game_id", 10]);

                    $previous_round = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND win_no=? AND win_x=? ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id", 100, '0x', 1]);

                    if (count($previous_round) != 0) {

                        foreach ($previous_round as $previous_data) {
                            $prev_round = $previous_data->round_count;
                        }

                        if ($cuu_round == $prev_round) {

                            $curr_round_bet = DB::select('SELECT * FROM `round_report` WHERE player_id = ? AND round_count = ? AND game = ? ORDER BY id DESC LIMIT ?', [$user_id, $cuu_round, $game_id, 1]);

                            if (count($curr_round_bet) != 0) {
                                foreach ($curr_round_bet as $r_report) {
                                    $zero =  $r_report->no_0;
                                    $one = $r_report->no_1;
                                    $two = $r_report->no_2;
                                    $three = $r_report->no_3;
                                    $four = $r_report->no_4;
                                    $five = $r_report->no_5;
                                    $six = $r_report->no_6;
                                    $seven = $r_report->no_7;
                                    $eight = $r_report->no_8;
                                    $nine = $r_report->no_9;
                                }

                                $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                if ($points) {

                                    foreach ($points as $bal) {
                                        $points = $bal->points;
                                    }

                                    $timestamp = time() + date("Z");
                                    $sec = gmdate("s", $timestamp);

                                    $message['message'] = 'Data Loading';
                                    $message['status'] = '200';
                                    $message['coins'] = $points;
                                    $message['round_count'] = $cuu_round;
                                    $message['sec'] = '' . $sec . '';
                                    $message['is_current_round_bet_place'] = true ;
                                    $message['no_0'] = $zero;
                                    $message['no_1'] = $one;
                                    $message['no_2'] = $two;
                                    $message['no_3'] = $three;
                                    $message['no_4'] = $four;
                                    $message['no_5'] = $five;
                                    $message['no_6'] = $six;
                                    $message['no_7'] = $seven;
                                    $message['no_8'] = $eight;
                                    $message['no_9'] = $nine;
                                    $message['pre_round_win_amount'] = '0';
                                    $message['round_win_data'] = $report_data;
                                } else {
                                    $message['status'] = '400';
                                    $message['error'] = 'user point fetching error one';
                                }
                            } else {
                                $message['status'] = '400';
                                $message['error'] = 'current round report data fetching error';
                            }
                        } elseif ($cuu_round > $prev_round) { //user privious data updated with win amount

                            foreach ($previous_round as $previous_data) {
                                $zero = $previous_data->no_0;
                                $one = $previous_data->no_1;
                                $two = $previous_data->no_2;
                                $three = $previous_data->no_3;
                                $four = $previous_data->no_4;
                                $five = $previous_data->no_5;
                                $six = $previous_data->no_6;
                                $seven = $previous_data->no_7;
                                $eight = $previous_data->no_8;
                                $nine = $previous_data->no_9;
                            }

                            $pre_round_win = DB::select('SELECT * FROM `current_round` WHERE round_count=?', [$prev_round]);

                            if ($pre_round_win) {

                                foreach ($pre_round_win as $pre_win) {
                                    $win_x = $pre_win->win_x;
                                    $win_no = $pre_win->win_no;
                                }

                                $old_points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);
                                if ($old_points) {

                                    foreach ($old_points as $o_points) {
                                        $old_bal = $o_points->points;
                                        $new_bal = 0;
                                    }
                                    if ($win_no == 0) {
                                        if ($win_x == '1x') {
                                            $win_points = $zero * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $zero * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $zero * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 1) {
                                        if ($win_x == '1x') {
                                            $win_points = $one * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $one * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $one * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 2) {
                                        if ($win_x == '1x') {
                                            $win_points = $two * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $two * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $two * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 3) {
                                        if ($win_x == '1x') {
                                            $win_points = $three * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $three * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $three * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 4) {
                                        if ($win_x == '1x') {
                                            $win_points = $four * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $four * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $four * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 5) {
                                        if ($win_x == '1x') {
                                            $win_points = $five * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $five * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $five * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 6) {
                                        if ($win_x == '1x') {
                                            $win_points = $six * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $six * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $six * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 7) {
                                        if ($win_x == '1x') {
                                            $win_points = $seven * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $seven * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $seven * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 8) {
                                        if ($win_x == '1x') {
                                            $win_points = $eight * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $eight * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $eight * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    } elseif ($win_no == 9) {
                                        if ($win_x == '1x') {
                                            $win_points = $nine * 9;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '2x') {
                                            $win_points = $nine * 18;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                        if ($win_x == '4x') {
                                            $win_points = $nine * 36;
                                            $new_bal = $old_bal + $win_points;
                                        }
                                    }
                                   
                                    //update user win/loss balance
                                    if ($old_bal < $new_bal) {

                                        $win_points = (int) $win_points;

                                        //$new_points = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$new_bal, $user_id]);
                                          $new_points = true;
                                          
                                        if ($new_points) {

                                            // $round_report = DB::update("UPDATE `round_report` SET `winning_amount` = '$win_points', `win_X` = '$win_x', `win_no` = $win_no WHERE round_count = $prev_round AND player_id = '$user_id'");

                                            $round_report = DB::update("UPDATE `round_report` SET `winning_amount` = '$win_points', `status` = 2, `win_X` = '$win_x', `win_no` = $win_no WHERE round_count = $prev_round AND player_id = '$user_id'");


                                            if ($round_report) {

                                                $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                                if ($points) {
                                                    $timestamp = time() + date("Z");
                                                    $sec = gmdate("s", $timestamp);

                                                    foreach ($points as $bal) {
                                                        $message['message'] = 'Data Loading';
                                                        $message['status'] = '200';
                                                        $message['coins'] = '' . $bal->points . '';
                                                        $message['round_count'] = $cuu_round;
                                                        $message['sec'] = '' . $sec . '';
                                                        $message['is_current_round_bet_place'] = false ;
                                                        $message['no_0'] = '0';
                                                        $message['no_1'] = '0';
                                                        $message['no_2'] = '0';
                                                        $message['no_3'] = '0';
                                                        $message['no_4'] = '0';
                                                        $message['no_5'] = '0';
                                                        $message['no_6'] = '0';
                                                        $message['no_7'] = '0';
                                                        $message['no_8'] = '0';
                                                        $message['no_9'] = '0';
                                                        $message['pre_round_win_amount'] = $win_points;
                                                        $message['round_win_data'] = $report_data;
                                                    }
                                                } else {
                                                    $message['status'] = '400';
                                                    $message['error'] = 'user point fetching error two';
                                                }
                                            } else {
                                                $message['status'] = '400';
                                                $message['error'] = 'Round report updation error';
                                            }
                                        } else {
                                            $message['status'] = '400';
                                            $message['error'] = 'Database points updation error';
                                        }
                                    } else {
                                        $win_points = (int) 0;
                                        $date = date('Y-m-d h:i:s');
                                        $round_report = DB::update("UPDATE `round_report` SET `winning_amount` = '$win_points', `win_X` = '$win_x', `win_no` = $win_no,`status` = 2, `is_winning_amount_add`=1 WHERE round_count = $prev_round AND player_id = '$user_id'");

                                        if ($round_report) {

                                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                            if ($points) {

                                                $timestamp = time() + date("Z");
                                                $sec = gmdate("s", $timestamp);
                                                foreach ($points as $bal) {
                                                    $message['message'] = 'Data Loading';
                                                    $message['status'] = '200';
                                                    $message['coins'] = '' . $bal->points . '';
                                                    $message['round_count'] = $cuu_round;
                                                    $message['sec'] = '' . $sec . '';
                                                    $message['is_current_round_bet_place'] = false ;
                                                    $message['no_0'] = '0';
                                                    $message['no_1'] = '0';
                                                    $message['no_2'] = '0';
                                                    $message['no_3'] = '0';
                                                    $message['no_4'] = '0';
                                                    $message['no_5'] = '0';
                                                    $message['no_6'] = '0';
                                                    $message['no_7'] = '0';
                                                    $message['no_8'] = '0';
                                                    $message['no_9'] = '0';
                                                    $message['pre_round_win_amount'] = '0';
                                                    $message['round_win_data'] = $report_data;
                                                }
                                            } else {
                                                $message['status'] = '400';
                                                $message['error'] = 'user point fetching error three';
                                            }
                                        } else {
                                            $message['error'] = 'Round report updation error';
                                            $message['status'] = '400';
                                        }
                                    }
                                } else {
                                    $message['status'] = '400';
                                    $message['error'] = 'old point fetching error';
                                }
                            } else {
                                $message['status'] = '400';
                                $message['error'] = 'previous round win no fetching error';
                            }
                        } else {
                            $message['status'] = '400';
                            $message['error'] = 'previous round count indicating wrong previous round count';
                        }
                    } elseif (count($previous_round) == 0) {
                        if (count($report_data) == 0) {

                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);
                            if ($points) {

                                $timestamp = time() + date("Z");
                                $sec = gmdate("s", $timestamp);

                                foreach ($points as $bal) {
                                    $message['message'] = 'Data Loading';
                                    $message['status'] = '200';
                                    $message['coins'] = '' . $bal->points . '';
                                    $message['round_count'] = $cuu_round;
                                    $message['sec'] = '' . $sec . '';
                                    $message['is_current_round_bet_place'] = false ;
                                    $message['no_0'] = '0';
                                    $message['no_1'] = '0';
                                    $message['no_2'] = '0';
                                    $message['no_3'] = '0';
                                    $message['no_4'] = '0';
                                    $message['no_5'] = '0';
                                    $message['no_6'] = '0';
                                    $message['no_7'] = '0';
                                    $message['no_8'] = '0';
                                    $message['no_9'] = '0';
                                    $message['round_win_data'] = 'it is first round';
                                    $message['pre_round_win_amount'] = '0';
                                }
                            } else {
                                $message['status'] = '400';
                                $message['error'] = 'user point fetching error four';
                            }
                        } elseif (count($report_data) != 0) {

                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);
                            if(empty($points)){
                                $points['points'] = 0;
                            }

                            if ($points) {
                                $timestamp = time() + date("Z");
                                $sec = gmdate("s", $timestamp);

                                foreach ($points as $bal) {
                                    
                                    $message['message'] = 'Data Loading';
                                    $message['status'] = '200';
                                    $message['coins'] = '' . !empty($bal) ? $bal->points : 0 . '';
                                    $message['round_count'] = $cuu_round;
                                    $message['sec'] = '' . $sec . '';
                                    $message['is_current_round_bet_place'] = false ;
                                    // $record = array(
                                    //     '1' => (int) 0,
                                    //     '2' =>  (int) 0,
                                    //     '3' =>(int) 0,
                                    //     '4' =>(int) 0,
                                    //     '5' =>(int) 0,
                                    //     '6' =>(int) 0,
                                    //     '7' =>(int) 0,
                                    //     '8' =>(int) 0,
                                    //     '9' =>(int) 0,
                                    //     '0' =>(int) 0,
                                    // );
                                    //$message['current_bet'] = $record;
                                    $message['no_0'] = '0';
                                    $message['no_1'] = '0';
                                    $message['no_2'] = '0';
                                    $message['no_3'] = '0';
                                    $message['no_4'] = '0';
                                    $message['no_5'] = '0';
                                    $message['no_6'] = '0';
                                    $message['no_7'] = '0';
                                    $message['no_8'] = '0';
                                    $message['no_9'] = '0';
                                    $message['pre_round_win_amount'] = '0';
                                    $message['round_win_data'] = $report_data;
                                }
                            } else {
                                $message['status'] = '400';
                                $message['error'] = 'user point fetching error five';
                            }
                        } else {
                            $message['status'] = '400';
                            $message['error'] = 'round report data fetching error';
                        }
                    } else {
                        $message['status'] = '400';
                        $message['error'] = 'previous round data fetching error';
                    }
                } else {
                    $message['status'] = '400';
                    $message['error'] = 'Round Count Not Found';
                }
            } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
            }     
        } else {
            $message['status'] = '400';
            $message['error'] = 'There Is Problem In Server Side';
        }
        $response = $message;

        return response()->json($response);
    }

    // Function For Getting Sec
    function GetSec()
    {
        $timestamp = time() + date("Z");
        $sec = gmdate("s", $timestamp);
        $response['message'] = 'Data Loading';
        $response['status'] = '200';
        $response['sec'] = '' . $sec . '';
        return response()->json($response);
    }

    // Function For Getting Sec
    function GetSecNew()
    {
        $timestamp = time() + date("Z");
        //dd($timestamp);die;
        $sec = gmdate("s", $timestamp);
        $get_sec = abs($sec - 60);
        if($get_sec < 10) {
            $get_sec = '0'.$get_sec;
        }
        $response['message'] = 'Data Loading';
        $response['status'] = '200';
        $response['sec'] = '' . $get_sec . '';
        return response()->json($response);
    }


    // Function For Getting Sec
    function game_timer(Request $request)
    {
        $gameId = $request->input('game_id');
        if($gameId == 3) {
            $response['status'] = true;
            $response['message'] = 'Game Timer';
            $response['Timer'] = 60;
        } else {
            $response['status'] = false;
            $response['message'] = 'Game Timer';
            $response['Timer'] = [];
        }
        
        return response()->json($response);
    }




    // Function For Add Current Bet
    function ShowCurrentBet(Request $request)
    {
        $round_count = $request->input('round_count');
        $user_id = $request->input('user_id');
        $game = $request->input('game');
        $points = $request->input('points');
        $device  = $request->input('device');
        $no_0 = $request->input('no_0');
        $no_1 = $request->input('no_1');
        $no_2 = $request->input('no_2');
        $no_3 = $request->input('no_3');
        $no_4 = $request->input('no_4');
        $no_5 = $request->input('no_5');
        $no_6 = $request->input('no_6');
        $no_7 = $request->input('no_7');
        $no_8 = $request->input('no_8');
        $no_9 = $request->input('no_9');
        $check_device = $this->CheckDeviceId ($user_id,$device);
        if($check_device){

            $device = 'user';
            $win_X = '0x';
            $win_no = 100;
            $game = 3;
            $date = date('Y-m-d h:i:s');
            $round_confirm = DB::select('SELECT `round_count` FROM `current_round` ORDER BY cr_id DESC LIMIT ?', [1]);
            if (count($round_confirm) != 0) {
                foreach ($round_confirm as $round_data) {
                    $cur_round = $round_data->round_count;
                }
                if ($round_count == $cur_round) {
                    $distributor_id = DB::select('SELECT `distributor_id` FROM `user` WHERE user_id=?', [$user_id]);

                    if ($distributor_id) {
                        foreach ($distributor_id as $dist_data) {
                            $dist_id = $dist_data->distributor_id;
                        }

                        $check_round = DB::select('SELECT * FROM `round_report` WHERE round_count=? AND distributor_id=? And player_id=? AND game=?', [$round_count, $dist_id, $user_id, $game]);
                        if (count($check_round) == 0) {

                            $round_data = array('device' => $device, 'distributor_id' => $dist_id, 'round_count' => $round_count, 'player_id' => $user_id, 'game' => $game, 'win_X' => $win_X, "win_no" => $win_no, 'no_0' => $no_0, 'no_1' => $no_1, 'no_2' => $no_2, 'no_3' => $no_3, 'no_4' => $no_4, 'no_5' => $no_5, 'no_6' => $no_6, 'no_7' => $no_7, 'no_8' => $no_8, 'no_9' => $no_9, 'created_at' => $date);
                            $check1 = DB::table('round_report')->insert($round_data);
                            if ($check1) {
                                if ($points > 0) {

                                    $current_balance = DB::select('SELECT `points` FROM `user_points` WHERE user_id=?', [$user_id]);

                                    if ($current_balance) {
                                        foreach ($current_balance as $balance) {
                                            $old_balance = $balance->points;
                                        }


                                        if($points <= $old_balance){

                                            $new_balance = $old_balance - $points;

                                            $check = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$new_balance, $user_id]);

                                            if ($check) {

                                                $all_data = DB::select('SELECT * FROM `current_bet` WHERE round_count =?', [$round_count]);

                                                if (count($all_data) == 0) {

                                                    $bet_data = array(
                                                        'round_count' => $round_count, 'no_0' => $no_0, 'no_1' => $no_1, 'no_2' => $no_2, 'no_3' => $no_3, 'no_4' => $no_4, 'no_5' => $no_5,
                                                        'no_6' => $no_6, 'no_7' => $no_7, 'no_8' => $no_8, 'no_9' => $no_9, 'created_at' => $date
                                                    );

                                                    $check = DB::table('current_bet')->insert($bet_data);

                                                    if ($check) {
                                                        $response['status'] = '200';
                                                        $response['message'] = 'Bet Confirmed';
                                                    } else {
                                                        $response['status'] = '404';
                                                        $response['error'] = 'Current bet updation error';
                                                    }
                                                } elseif (count($all_data) != 0) {
                                                    foreach ($all_data as $data) {

                                                        $a0 = $data->no_0;
                                                        $add_0 = $no_0 + $a0;

                                                        $a1 = $data->no_1;
                                                        $add_1 = $no_1 + $a1;

                                                        $a2 = $data->no_2;
                                                        $add_2 = $no_2 + $a2;

                                                        $a3 = $data->no_3;
                                                        $add_3 = $no_3 + $a3;

                                                        $a4 = $data->no_4;
                                                        $add_4 = $no_4 + $a4;

                                                        $a5 = $data->no_5;
                                                        $add_5 = $no_5 + $a5;

                                                        $a6 = $data->no_6;
                                                        $add_6 = $no_6 + $a6;

                                                        $a7 = $data->no_7;
                                                        $add_7 = $no_7 + $a7;

                                                        $a8 = $data->no_8;
                                                        $add_8 = $no_8 + $a8;

                                                        $a9 = $data->no_9;
                                                        $add_9 = $no_9 + $a9;
                                                    }
                                                    $check = DB::update('UPDATE `current_bet` SET `no_0`=?,`no_1`=?,`no_2`=?,`no_3`=?,`no_4`=?,`no_5`=?,`no_6`=?,`no_7`=?,`no_8`=?,`no_9`=? WHERE round_count=?', [$add_0, $add_1, $add_2, $add_3, $add_4, $add_5, $add_6, $add_7, $add_8, $add_9, $round_count]);


                                                    if ($check) {
                                                        $response['status'] = '200';
                                                        $response['message'] = 'Bet Confirmed';
                                                    } else {
                                                        $response['status'] = '404';
                                                        $response['error'] = 'Current bet updation error';
                                                    }
                                                } else {
                                                    $response['status'] = '404';
                                                    $response['error'] = 'Current bet data feaching error';
                                                }
                                            } else {
                                                $response['status'] = '404';
                                                $response['error'] = 'Point Updation error';
                                            }
                                        }  else {
                                            $response['status'] = '404';
                                            $response['error'] = 'not enough balance';
                                        }  
                                    } else {
                                        $response['status'] = '404';
                                        $response['error'] = 'We do not found current balance';
                                    }
                                } else {
                                    $response['status'] = '200';
                                    $response['error'] = 'There is no need to update current bet';
                                }
                            } else {
                                $response['status'] = '404';
                                $response['error'] = 'Round report updation error';
                            }
                        } else {
                            $response['status'] = '404';
                            $response['error'] = 'Allready bet is Confirm';
                        }
                    } else {
                        $response['status'] = '404';
                        $response['error'] = 'Distributor Id does not found for your Id';
                    }
                } else {
                    $response['status'] = '404';
                    $response['error'] = 'You Are Playing Wrong Round';
                }
            } else {
                $response['status'] = '404';
                $response['error'] = 'Data Fetching Error';
            }
        } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
                $response['user_data'] = $message;
        }     
        return response()->json($response);
    }


    // Function For Update Points
    // function update_points(Request $request)
    // {
    //     $user_id = $request->input('user_id');
    //     $bet_points = $request->input('bet_points');
    //     $main_points = null;
    //     $userdata = DB::select('SELECT * FROM `user_points` WHERE `user_id` = ?', [$user_id]);
    //     foreach ($userdata as $user_data) {
    //         $bal = $user_data->points;

    //         if ($bet_points > $bal) {
    //             $response['message'] = 'Insufficient points..Bet Points Is Greater Than Main Points';
    //             $response['status'] = '404';
    //             $response['coins'] = '' . $bal . '';
    //         } else if ($bal < 1) {
    //             $response['message'] = 'Insufficient points';
    //             $response['status'] = '405';
    //             $response['coins'] = '' . $bal . '';
    //         } else {
    //             $main_points = $user_data->points - $bet_points;
    //             $check = DB::update('UPDATE `user_points` SET`points`=? WHERE user_id = ?', [$main_points, $user_id]);
    //             $response['message'] = 'Updated Points';
    //             $response['status'] = '200';
    //             $response['coins'] = '' . $main_points . '';
    //         }
    //     }
    //     return response()->json($response);
    // }
  
    // Function For show Win Number
    function GetWinNo()
    {
        sleep(4);
        try{
        $current_bet = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC LIMIT 1,1');
        $current_round = DB::select('SELECT * FROM `current_round` ORDER BY cr_id DESC LIMIT 1,1');

        if ($current_bet && $current_round) {
            foreach ($current_bet as $bet_data) {
                $round_count = $bet_data->round_count;
            }
            
            foreach ($current_round as $round_data) {
                $curr_round_count = $round_data->round_count;
                $win_no = $round_data->win_no;
                $win_x = $round_data->win_x;
            }

            if ($curr_round_count == $round_count) {
                $response['status'] = '200';
                $response['message'] = 'Win Number Is';
                $response['round_count'] = $round_count;
                $response['win_no'] = $win_no;
                $response['win_x'] = $win_x;
            } else {
                $response['status'] = '404';
                $response['error'] = 'Current Round Not Match';
            }    
        } else {
            $response['status'] = '404';
            $response['error'] = 'Current Bet Data Not Found';
        }
        } catch (Exception $e) {
            dd($e->getMessage());
            $message['message'] = 'Something Went Wrong';
            $response = $message;
        }

        return response()->json($response);
    }
    
    
    function GameWinNo(Request $request)
    {
        try{
            $round_count = $request->input('round_count');    
            $current_round  = DB::select('SELECT * FROM `current_round` WHERE round_count =? ORDER BY cr_id DESC LIMIT ?', [$round_count ,1]);
            if (!empty($current_round)) {
                foreach ($current_round as $round_data) {
                    $curr_round_count = $round_data->round_count;
                    $win_no = $round_data->win_no;
                    $win_x = $round_data->win_x;
                }
                if (isset($win_no)) {
                    $timestamp = time() + date("Z");
                    $sec = gmdate("s", $timestamp);
                    $response['status'] = '200';
                    $response['message'] = 'Win Number Is';
                    $response['round_count'] = $round_count;
                    $response['win_no'] = $win_no;
                    $response['win_x'] = $win_x;
                    $response['sec'] = '' . $sec . '';
                } else {
                    $response['status'] = '404';
                    $response['error'] = 'Win number Fetching Error';
                }    
            } else {
                $response['status'] = '404';
                $response['error'] = 'Round Count Not Found';
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            $message['message'] = 'Something Went Wrong';
            $response = $message;
        }

        return response()->json($response);
    }
    
  // Function For Night Mode
    public function nightmode($win_x, $round_count)
    {
        $curr_bet = DB::select('SELECT * FROM `current_bet` WHERE round_count = ?', [$round_count]);

        if ($curr_bet) {
            foreach ($curr_bet as $bet_data) {
                $round_count = $bet_data->round_count;
                $no0 = $bet_data->no_0;
                $no1 = $bet_data->no_1;
                $no2 = $bet_data->no_2;
                $no3 = $bet_data->no_3;
                $no4 = $bet_data->no_4;
                $no5 = $bet_data->no_5;
                $no6 = $bet_data->no_6;
                $no7 = $bet_data->no_7;
                $no8 = $bet_data->no_8;
                $no9 = $bet_data->no_9;
            }

            $rand_no = rand(0, 9);
            switch ($rand_no) {
                case 0:
                    $min_bate = $no0;
                    $win_no = 0;
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    break;
                case 1:
                    $min_bate = $no1;
                    $win_no = 1;
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    break;
                case 2:
                    $min_bate = $no2;
                    $win_no = 2;
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    break;
                case 3:
                    $min_bate = $no3;
                    $win_no = 3;
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    break;
                case 4:
                    $min_bate = $no4;
                    $win_no = 4;
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    break;
                case 5:
                    $min_bate = $no5;
                    $win_no = 5;
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    break;
                case 6:
                    $min_bate = $no6;
                    $win_no = 6;
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    break;
                case 7:
                    $min_bate = $no7;
                    $win_no = 7;
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    break;
                case 8:
                    $min_bate = $no8;
                    $win_no = 8;
                    if ($min_bate >= $no9) {
                        $min_bate = $no9;
                        $win_no = 9;
                    }
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    break;
                case 9:
                    $min_bate = $no9;
                    $win_no = 9;
                    if ($min_bate >= $no0) {
                        $min_bate = $no0;
                        $win_no = 0;
                    }
                    if ($min_bate >= $no1) {
                        $min_bate = $no1;
                        $win_no = 1;
                    }
                    if ($min_bate >= $no2) {
                        $min_bate = $no2;
                        $win_no = 2;
                    }
                    if ($min_bate >= $no3) {
                        $min_bate = $no3;
                        $win_no = 3;
                    }
                    if ($min_bate >= $no4) {
                        $min_bate = $no4;
                        $win_no = 4;
                    }
                    if ($min_bate >= $no5) {
                        $min_bate = $no5;
                        $win_no = 5;
                    }
                    if ($min_bate >= $no6) {
                        $min_bate = $no6;
                        $win_no = 6;
                    }
                    if ($min_bate >= $no7) {
                        $min_bate = $no7;
                        $win_no = 7;
                    }
                    if ($min_bate >= $no8) {
                        $min_bate = $no8;
                        $win_no = 8;
                    }
                    break;
            }

            $night_mode_win_save = DB::update("UPDATE `night_mode` SET `is_updated` = 1 WHERE id = 1");
            if ($night_mode_win_save) {
                DB::update('UPDATE `current_round` SET `win_no` = ?, `win_x` = ? WHERE round_count = ?', [$win_no, $win_x, $round_count]);

                return true;
            } else {
                $error = array('error_massage' => 'night mode not working.....');
                DB::table('error')->insert($error);
                return false;
            }
        } else {
            $error = array('error_massage' => 'night mode current bet query is not working');
            DB::table('error')->insert($error);
            return false;
        }
    }

    // Function For Night Mode
    public function joker($win_x, $round_count)
    {
        $joker_win_save = DB::update("UPDATE `joker` SET `is_updated` = 1 WHERE id = 1");
        if ($joker_win_save) {
            DB::update('UPDATE `current_round` SET `win_x` = ? WHERE round_count = ?', [$win_x, $round_count]);

            return true;
        } else {
            $error = array('error_massage' => 'Joker mode not working');
            DB::table('error')->insert($error);
            return false;
        }
    }

    // Function For show Win Number
    function GetWinNo1()
    {

        $n_mode = DB::select('SELECT * FROM `night_mode`');
        $j_mode = DB::select('SELECT * FROM `joker`');

        if ((count($n_mode) != 0) && (count($j_mode) != 0)) {
            foreach ($n_mode as $data) {
                $night_mode = $data->mode;
                $is_updated = $data->is_updated;
            }

            foreach ($j_mode as $data) {
                $joker_mode = $data->mode;
                $joker_is_updated = $data->is_updated;
            }
            $current_bet = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC LIMIT 0, 1');

            if ($current_bet) {
                foreach ($current_bet as $bet_data) {
                    $round_count = $bet_data->round_count;
                }


                if (($night_mode == 0) && ($joker_mode == 0)) {
                    $current_round = DB::select("SELECT * FROM `current_round` where round_count = $round_count");
                    if (count($current_round) != 0) {
                        foreach ($current_round as $current_data) {
                            $win_no = $current_data->win_no;
                            $win_x = $current_data->win_x;
                        }
                        $response['status'] = '200';
                        $response['message'] = 'Win Number Is';
                        $response['round_count'] = $round_count;
                        $response['win_no'] = $win_no;
                        $response['win_x'] = $win_x;
                    } else {
                        $response['status'] = '404';
                        $response['error'] = 'Current Round Win No Not Found';
                    }
                }elseif (($is_updated == 1) || ($joker_is_updated == 1)) {
                    $current_round = DB::select("SELECT * FROM `current_round` where round_count = $round_count");
                    if (count($current_round) != 0) {
                        foreach ($current_round as $current_data) {
                            $win_no = $current_data->win_no;
                            $win_x = $current_data->win_x;
                        }
                        $response['status'] = '200';
                        $response['message'] = 'Win Number Is';
                        $response['round_count'] = $round_count;
                        $response['win_no'] = $win_no;
                        $response['win_x'] = $win_x;
                    } else {
                        $response['status'] = '404';
                        $response['error'] = 'Current Round Win No Not Found';
                    }
                } elseif (($is_updated == 0) || ($joker_is_updated == 0)) {
                    $flag = 0;
                    if (($night_mode == 1) && ($joker_mode == 1)) {
                        $rand_no = rand(0, 18);
                        if ($rand_no == 6) {
                            $win_x = '2x';
                        } elseif ($rand_no == 13) {
                            $win_x = '4x';
                        } else {
                            $win_x = '1x';
                        }

                        if ($this->nightmode($win_x, $round_count)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                        }
                    } elseif ($joker_mode == 1) {
                        $rand_no = rand(0, 18);
                        if ($rand_no == 6) {
                            $win_x = '2x';
                            if ($this->joker($win_x, $round_count)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        } elseif ($rand_no == 13) {
                            $win_x = '4x';
                            if ($this->nightmode($win_x, $round_count)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        } else {
                            $win_x = '1x';
                            if ($this->joker($win_x, $round_count)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        }
                    } elseif ($night_mode == 1) {
                        $win_x = '1x';
                        if ($this->nightmode($win_x, $round_count)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                        }
                    }

                    if ($flag == 1) {
                        $current_round = DB::select("SELECT * FROM `current_round` where round_count = $round_count");
                        if (count($current_round) != 0) {
                            foreach ($current_round as $current_data) {
                                $curr_win_no = $current_data->win_no;
                                $win_x = $current_data->win_x;
                            }
                            $response['status'] = '200';
                            $response['message'] = 'Win Number Is';
                            $response['round_count'] = $round_count;
                            $response['win_no'] = $curr_win_no;
                            $response['win_x'] = $win_x;
                        } else {
                            $response['status'] = '404';
                            $response['error'] = 'Current Round Win No Not Found';
                        }
                    } else {
                        $response['status'] = '404';
                        $response['error'] = 'Current Round Win No Not Found';
                    }
                } else {
                    $response['status'] = '404';
                    $response['error'] = 'Night Mode Updated Status is Wrong..';
                }
            } else {
                $response['status'] = '404';
                $response['error'] = 'Current Bet Data Not Found';
            }
        } else {
            $response['status'] = '404';
            $response['error'] = 'Night Mode Status Not Found';
        }

        return response()->json($response);
    }

     // Function For show Win Number
    function GetWinNo2()
    {
        $n_mode = DB::select('SELECT * FROM `night_mode`');

        if (count($n_mode) != 0) {
            foreach ($n_mode as $data) {
                $night_mode = $data->mode;
                $is_updated = $data->is_updated;
            }

            $current_bet = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC LIMIT 0, 1');

            if ($current_bet) {
                foreach ($current_bet as $bet_data) {
                    $round_count = $bet_data->round_count;
                }

                if (($is_updated == 1) || ($night_mode == 0)) {
                    $current_round = DB::select("SELECT * FROM `current_round` where round_count = $round_count");
                    if (count($current_round) != 0) {
                        foreach ($current_round as $current_data) {
                            $win_no = $current_data->win_no;
                            $win_x = $current_data->win_x;
                        }
                        $response['message'] = 'Win Number Is';
                        $response['status'] = '200';
                        $response['round_count'] = $round_count;
                        $response['win_no'] = $win_no;
                        $response['win_x'] = $win_x;
                    } else {
                        $response['statu'] = '404';
                        $response['error'] = 'Current Round Win No Not Found';
                    }
                } elseif (($is_updated == 0) && ($night_mode == 1)) {
                    foreach ($current_bet as $bet_data) {
                        $round_count = $bet_data->round_count;
                        $no0 = $bet_data->no_0;
                        $no1 = $bet_data->no_1;
                        $no2 = $bet_data->no_2;
                        $no3 = $bet_data->no_3;
                        $no4 = $bet_data->no_4;
                        $no5 = $bet_data->no_5;
                        $no6 = $bet_data->no_6;
                        $no7 = $bet_data->no_7;
                        $no8 = $bet_data->no_8;
                        $no9 = $bet_data->no_9;
                    }
                    
                        $rand_no = rand(0, 9);
                        switch ($rand_no) {
                            case 0:
                                $min_bate = $no0;
                                $win_no = 0;
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                break;
                            case 1:
                                $min_bate = $no1;
                                $win_no = 1;
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                break;
                            case 2:
                                $min_bate = $no2;
                                $win_no = 2;
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                break;
                            case 3:
                                $min_bate = $no3;
                                $win_no = 3;
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                break;
                            case 4:
                                $min_bate = $no4;
                                $win_no = 4;
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                break;
                            case 5:
                                $min_bate = $no5;
                                $win_no = 5;
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                break;
                            case 6:
                                $min_bate = $no6;
                                $win_no = 6;
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                break;
                            case 7:
                                $min_bate = $no7;
                                $win_no = 7;
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                break;
                            case 8:
                                $min_bate = $no8;
                                $win_no = 8;
                                if ($min_bate >= $no9) {
                                    $min_bate = $no9;
                                    $win_no = 9;
                                }
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                break;
                            case 9:
                                $min_bate = $no9;
                                $win_no = 9;
                                if ($min_bate >= $no0) {
                                    $min_bate = $no0;
                                    $win_no = 0;
                                }
                                if ($min_bate >= $no1) {
                                    $min_bate = $no1;
                                    $win_no = 1;
                                }
                                if ($min_bate >= $no2) {
                                    $min_bate = $no2;
                                    $win_no = 2;
                                }
                                if ($min_bate >= $no3) {
                                    $min_bate = $no3;
                                    $win_no = 3;
                                }
                                if ($min_bate >= $no4) {
                                    $min_bate = $no4;
                                    $win_no = 4;
                                }
                                if ($min_bate >= $no5) {
                                    $min_bate = $no5;
                                    $win_no = 5;
                                }
                                if ($min_bate >= $no6) {
                                    $min_bate = $no6;
                                    $win_no = 6;
                                }
                                if ($min_bate >= $no7) {
                                    $min_bate = $no7;
                                    $win_no = 7;
                                }
                                if ($min_bate >= $no8) {
                                    $min_bate = $no8;
                                    $win_no = 8;
                                }
                                break;
                        }
                    
                    $night_mode_win_save = DB::update("UPDATE `night_mode` SET `is_updated` = 1 WHERE id=1");
                    if ($night_mode_win_save) {
                        DB::update("UPDATE `current_round` SET `win_no` = $win_no WHERE round_count = $round_count");

                        $current_round = DB::select("SELECT * FROM `current_round` where round_count = $round_count");

                        if (count($current_round) != 0) {
                            foreach ($current_round as $current_data) {
                                $curr_win_no = $current_data->win_no;
                                $win_x = $current_data->win_x;
                            }
                            if ($curr_win_no == $win_no) {
                                $response['message'] = 'Win Number Is';
                                $response['status'] = '200';
                                $response['round_count'] = $round_count;
                                $response['win_no'] = $curr_win_no;
                                $response['win_x'] = $win_x;
                            } else {
                                $response['statu'] = '404';
                                $response['error'] = 'Current Win No And Night Mode win No Is Different';
                            }
                        } else {
                            $response['statu'] = '404';
                            $response['error'] = 'Current Round Win No Not Found In Night Mode';
                        }
                    } else {
                        $response['statu'] = '404';
                        $response['error'] = 'Night Mode is_updated Status is Not Change';
                    }
                } else {
                    $response['statu'] = '404';
                    $response['error'] = 'Night Mode Updated Status is Wrong..';
                }
            } else {
                $response['statu'] = '404';
                $response['error'] = 'Current Bet Data Not Found';
            }
        } else {
            $response['statu'] = '404';
            $response['error'] = 'Night Mode Status Not Found';
        }
        return response()->json($response);
    }
    
    // Function For Store RoundInfo
    function UpdateRoundInfo(Request $request)
    {
        $round_count = $request->input('round_count');
        $device = $request->input('device');
        $user_id = $request->input('user_id');
        $game = $request->input('game');
        $win_amount = $request->input('points');
        $win_X = $request->input('win_x');
        $win_no = $request->input('win_no');
        $zero = $request->input('0');
        $one = $request->input('1');
        $two = $request->input('2');
        $three = $request->input('3');
        $four = $request->input('4');
        $five = $request->input('5');
        $six = $request->input('6');
        $seven = $request->input('7');
        $eight = $request->input('8');
        $nine = $request->input('9');

        $current_round_count = DB::select('select round_count from current_round ORDER BY cr_id DESC LIMIT ?', [1]);

        if ($current_round_count) {

            foreach ($current_round_count as $count_data) {
                $curr_round = $count_data->round_count;
            }

            $report_data = DB::select('SELECT ar_id,`win_X`, `win_no`,game FROM `admin_round_report` WHERE game=? GROUP BY round_count HAVING COUNT(*) ORDER BY ar_id DESC LIMIT ?', ["$game", 10]);

            if (count($report_data) != 0) {

                $pending_data = DB::select('SELECT * FROM `round_report` WHERE game=? && player_id=? && round_count=?', ["$game", "$user_id", "$round_count"]);

                if (count($pending_data) != 0) {

                    if ($win_amount > 0) {

                        $current_balance = DB::select('SELECT `points` FROM `user_points` WHERE user_id=?', [$user_id]);

                        if ($current_balance) {

                            foreach ($current_balance as $balance) {
                                $old_balance = $balance->points;
                            }

                            $new_balance = $old_balance + $win_amount;

                            $upd_win_amt = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$new_balance, $user_id]);

                            if ($upd_win_amt) {

                                $round_report = DB::update("UPDATE `round_report` SET `win_X` = '$win_X', `win_no` = $win_no WHERE round_count = $round_count AND player_id = '$user_id'");

                                if ($round_report) {

                                    $message = array();

                                    $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                    if ($points) {

                                        $timestamp = time() + date("Z");
                                        $sec = gmdate("s", $timestamp);

                                        foreach ($points as $bal) {
                                            $message['message'] = 'Data Loading';
                                            $message['status'] = '200';
                                            $message['coins'] = '' . $bal->points . '';
                                            $message['round_count'] = $curr_round;
                                            $message['sec'] = '' . $sec . '';
                                            $message['pre_round_win_amount'] = $win_amount;
                                            $message['round_win_data'] = $report_data;
                                        }
                                    } else {
                                        $message['message'] = 'user point fetching error one';
                                        $message['statu'] = '404';
                                    }
                                } else {
                                    $message['message'] = 'Round report not store';
                                    $message['statu'] = '404';
                                }
                            } else {
                                $message['message'] = 'win points updation error';
                                $message['statu'] = '404';
                            }
                        } else {
                            $message['message'] = 'Current points not found';
                            $message['statu'] = '404';
                        }
                    } elseif ($win_amount == 0) {

                        $round_report = DB::update("UPDATE `round_report` SET `win_X` = '$win_X', `win_no` = $win_no WHERE round_count = $round_count AND player_id = '$user_id'");

                        if ($round_report) {

                            $message = array();

                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                            if ($points) {

                                $timestamp = time() + date("Z");
                                $sec = gmdate("s", $timestamp);

                                foreach ($points as $bal) {
                                    $message['message'] = 'Data Loading';
                                    $message['status'] = '200';
                                    $message['coins'] = '' . $bal->points . '';
                                    $message['round_count'] = $curr_round;
                                    $message['sec'] = '' . $sec . '';
                                    $message['pre_round_win_amount'] = $win_amount;
                                    $message['round_win_data'] = $report_data;
                                }
                            } else {
                                $message['message'] = 'user point fetching error two';
                                $message['statu'] = '404';
                            }
                        } else {
                            $message['message'] = 'Round report not store';
                            $message['statu'] = '404';
                        }
                    } else {
                        $message['message'] = 'wrong win amount';
                        $message['statu'] = '404';
                    }
                } elseif (count($pending_data) == 0) {

                    $dist_id = DB::select('SELECT `distributor_id` FROM `user` WHERE user_id=?', [$user_id]);

                    if ($dist_id) {
                        foreach ($dist_id as $dist_data) {
                            $round_data = array('device' => $device, 'distributor_id' => $dist_data->distributor_id, 'round_count' => $round_count, 'player_id' => $user_id, 'game' => $game, 'win_X' => $win_X, "win_no" => $win_no, 'no_0' => $zero, 'no_1' => $one, 'no_2' => $two, 'no_3' => $three, 'no_4' => $four, 'no_5' => $five, 'no_6' => $six, 'no_7' => $seven, 'no_8' => $eight, 'no_9' => $nine);
                            $check = DB::table('round_report')->insertGetId($round_data);
                        }

                        if ($check) {

                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                            if ($points) {

                                $timestamp = time() + date("Z");
                                $sec = gmdate("s", $timestamp);


                                foreach ($points as $bal) {
                                    $message['message'] = 'Data Loading';
                                    $message['status'] = '200';
                                    $message['coins'] = '' . $bal->points . '';
                                    $message['round_count'] = $curr_round;
                                    $message['sec'] = '' . $sec . '';
                                    $message['pre_round_win_amount'] = '0';
                                    $message['round_win_data'] = $report_data;
                                }
                            } else {
                                $message['message'] = 'user point fetching error three';
                                $message['statu'] = '404';
                            }
                        } else {
                            $message['message'] = 'Round report not store';
                            $message['statu'] = '404';
                        }
                    } else {
                        $message['message'] = 'distributor id not found for our user id';
                        $message['statu'] = '404';
                    }
                } else {
                    $message['message'] = '$pending round data fetching error';
                    $message['statu'] = '404';
                }
            } else {
                $message['statu'] = '404';
                $message['message'] = 'round report data fetching error';
            }
        } else {
            $message['statu'] = '404';
            $message['message'] = 'Round Count Not Found';
        }
        $response = $message;
        return response()->json($response);
    }
    
    // Function For Add Points User Notification
    public function AddUserNotification($user_id, $reciever, $points)
    {   
        $today_date = date('Y-m-d h:i:s');
        $NotificationArray = array('sender' => $user_id, 'reciever' => $reciever, 'points' => $points, 'status' => 1,'created_at' => $today_date);
        $NotificationPoints = DB::table('user_notification')->insert($NotificationArray);
        if ($NotificationPoints) {
            return true;
        } else {
            return false;
        }
    }
    
    // // Function For Sending User To User Point
    // function AddUserPoint(Request $request)
    // {
    //     $user_id = $request->input('sender');
    //     $reciever = $request->input('reciever');
    //     $points = $request->input('points');
    //     $password = $request->input('password');
    //     $device  = $request->input('device');

    //     $check_device = $this->CheckDeviceId ($user_id,$device);
    //     if($check_device){

    //         $check_reciever = DB::select('SELECT `distributor_id` FROM `user` WHERE user_id =?', [$reciever]);
    //         $check_sender = DB::select('SELECT * FROM `user` Where user_id =?', [$user_id]);

    //         if ((count($check_reciever) != 0)&&(count($check_sender) != 0)) {

    //             foreach ($check_sender as $user_data) {
    //                     $user_dist = $user_data->distributor_id;
    //                     $user_password = $user_data->password;
    //             }
    //             if (Hash::check($password, $user_password)) {
    //                 foreach ($check_reciever as $user_data) {
    //                     $rec_dist = $user_data->distributor_id;
    //                 }
    //                 if ($user_dist == $rec_dist) {
    //                     $user_point_data = DB::select('SELECT * FROM `user_points` WHERE user_id = ?', [$user_id]);
    //                         if (count($user_point_data) != 0) {
    //                             foreach ($user_point_data as $user_data) {
    //                                 $user_points = $user_data->points;
    //                             }
    //                             if (($user_points != 0) && ($user_points >= $points)) {
    //                                 $user_points = $user_points - $points;
    //                                 $user_check = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id=?', [$user_points, $user_id]);
    //                                 if ($user_check) {
    //                                     if ($this->AddUserNotification($user_id, $reciever, $points)) {
    //                                         $message['status'] = '200';
    //                                         $message['message'] = 'Points Send Successfully...';
    //                                     } else {
    //                                         $message['status'] = '404';
    //                                         $message['error'] = 'Something Went Wrong.....Points Not Send';
    //                                     }
    //                                 } else {
    //                                     $message['status'] = '404';
    //                                     $message['error'] = 'Points Not Send...';
    //                                 }
    //                             } else {
    //                                 $message['status'] = '404';
    //                                 $message['error'] = 'Insufficient Points';
    //                             }
    //                         } else {
    //                             $message['status'] = '404';
    //                             $message['error'] = 'Points Are Not Available In Your Account';
    //                         }
    //                 } else {
    //                     $message['status'] = '404';
    //                     $message['error'] = 'Distributor Is Different';
    //                 }
    //             } else {
    //                     $message['status'] = '404';
    //                     $message['error'] = 'Incorrect Password';
    //             }    
    //         } else {
    //             $message['status'] = '404';
    //             $message['error'] = 'User Not Exist...';
    //         }
    //     } else{
    //             $message['message']    = 'Your Session Expired.';
    //             $message['status']     = "401";
    //     }     
    //     $response = $message;
    //     return response()->json($response);
    // }


    // Function For Sending Point From  User To User or distributer 
    function AddUserPoint(Request $request)
    {
        $user_id = $request->input('sender');
        $reciever = strtoupper($request->input('reciever'));
        $points = $request->input('points');
        $password = $request->input('password');
        $device  = $request->input('device');

        $check_device = $this->CheckDeviceId ($user_id,$device);
        if($check_device){
            $user_info = DB::select('SELECT `distributor_id` FROM `user` WHERE user_id =?', [$user_id]);

            foreach ($user_info as $user_d) {
                $distributor_id = $user_d->distributor_id;
            }

            if($distributor_id == $reciever){ //check receiver is distributer or not

                $check_sender = DB::select('SELECT * FROM `user` Where user_id =?', [$user_id]);
                foreach ($check_sender as $user_data) {
                    $user_dist = $user_data->distributor_id;
                    $user_password = $user_data->password;
                }

                if (Hash::check($password, $user_password)) {
                    $user_points = DB::select('SELECT `points` FROM `user_points` WHERE user_id = ?', [$user_id]);
                    if (count($user_points) != 0) {
                        foreach ($user_points as $points_data) {
                            if (($points_data->points != 0) && ($points_data->points > $points)) {
                                $distributor = DB::select('SELECT distributor_id FROM `user` WHERE user_id = ?', [$user_id]);
        
                                $dist_notify = array('reciever' => $distributor_id, 'sender' => $user_id, 'points' => $points, 'status' => 0);
                                $check_dist_notify = DB::table('distributor_notification')->insert($dist_notify);
                                if ($check_dist_notify) {
                                    $user_return_points = array('distributor_id' => $distributor_id, 'user_id' => $user_id, 'return_points' => $points);
                                    $check_dist_return = DB::table('user_return_points')->insert($user_return_points);
                                    if ($check_dist_return) {
                                        $distributor_points = DB::select('SELECT points FROM `distributor_points` WHERE distributor_id = ?', [$distributor_id]);
                                        if (count($distributor_points) != 0) {
                                            foreach ($distributor_points as $dist_point) {
                                                $dist_points = $dist_point->points;
                                            }
                                            $add_dist_point = $dist_points + $points;
                                            $dist_points_save = DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id = ?', [$add_dist_point, $distributor_id]);
                                            if ($dist_points_save) {
                                                $user_points = $points_data->points - $points;
                                                $main_points = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$user_points, $user_id]);
                                                if ($main_points) {
                                                    $message['status'] = '200';
                                                    $message['message'] = 'Points Transfer Successfully...';
                                                } else {
                                                    $message['status'] = '404';
                                                    $message['error'] = 'Something Went Wrong.....Points Not Send';
                                                }
                                            } else {
                                                $message['status'] = '404';
                                                $message['error'] = 'Points Not Send...';
                                            }
                                        } else {
                                            $message['status'] = '404';
                                            $message['error'] = 'Distributo Not Found';
                                        }
                                    } else {
                                        $message['status'] = '404';
                                        $message['error'] = 'Points Not Returns';
                                    }
                                } else {
                                    $message['status'] = '404';
                                    $message['error'] = 'Points Not Returns';
                                }
                            } else {
                                $message['status'] = '404';
                                $message['error'] = 'Insufficient Points';
                            }
                        }
                    } else {
                        $message['status'] = '404';
                        $message['error'] = 'Insufficient Points...!';
                    }
                } else {
                        $message['status'] = '404';
                        $message['error'] = 'Incorrect Password!';
                }    
            }else{
    
                $check_reciever = DB::select('SELECT `distributor_id` FROM `user` WHERE user_id =?', [$reciever]);
                $check_sender = DB::select('SELECT * FROM `user` Where user_id =?', [$user_id]);

                if ((count($check_reciever) != 0)&&(count($check_sender) != 0)) {

                    foreach ($check_sender as $user_data) {
                            $user_dist = $user_data->distributor_id;
                            $user_password = $user_data->password;
                    }
                    if (Hash::check($password, $user_password)) {
                        foreach ($check_reciever as $user_data) {
                            $rec_dist = $user_data->distributor_id;
                        }
                        if ($user_dist == $rec_dist) {
                            $user_point_data = DB::select('SELECT * FROM `user_points` WHERE user_id = ?', [$user_id]);
                                if (count($user_point_data) != 0) {
                                    foreach ($user_point_data as $user_data) {
                                        $user_points = $user_data->points;
                                    }
                                    if (($user_points != 0) && ($user_points >= $points)) {
                                        $user_points = $user_points - $points;
                                        $user_check = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id=?', [$user_points, $user_id]);
                                        if ($user_check) {
                                            if ($this->AddUserNotification($user_id, $reciever, $points)) {
                                                $message['status'] = '200';
                                                $message['message'] = 'Points Transfer Successfully...';
                                            } else {
                                                $message['status'] = '404';
                                                $message['error'] = 'Something Went Wrong.....Points Not Send';
                                            }
                                        } else {
                                            $message['status'] = '404';
                                            $message['error'] = 'Points Not Send...';
                                        }
                                    } else {
                                        $message['status'] = '404';
                                        $message['error'] = 'Insufficient Points';
                                    }
                                } else {
                                    $message['status'] = '404';
                                    $message['error'] = 'Points Are Not Available In Your Account';
                                }
                        } else {
                            $message['status'] = '404';
                            $message['error'] = 'Distributor Is Different';
                        }
                    } else {
                            $message['status'] = '404';
                            $message['error'] = 'Incorrect Password';
                    }    
                } else {
                    $message['status'] = '404';
                    $message['error'] = 'User Not Exist...';
                }
            }    
        } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
        }     
        $response = $message;
        return response()->json($response);
    }



    // Function For Change Status From Notification
    public function ChangeUserStatus($notify_id, $status)
    {
        $check = DB::update('UPDATE `user_notification` SET `status`= ? WHERE id = ?', [$status, $notify_id]);

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Change Status From Notification
    public function ChangeDistStatus($dist_notify_id, $user_id, $status)
    {
        $check = DB::update('UPDATE `distributor_notification` SET `status`= ? WHERE `id` = ? AND reciever=? AND `status`=?', [$status, $dist_notify_id, $user_id, 1]);

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Delete Points From Hold Points
    public function AddUserPointsHistory($getdist_id, $points, $status)
    {
        $date = date('Y-m-d h:i:s');
        $historyArray = array('user_points_id' => $getdist_id, 'points' => $points, 'status' => $status, 'created_at' => $date);
        $addhistory = DB::table('user_points_history')->insert($historyArray);
        if ($addhistory) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Delete Points From Hold Points
    public function AddUserToUserPointHistory($from, $to, $points, $status)
    {
        $historyArray = array('sender' => $from, 'reciever' => $to, 'points' => $points, 'status' => $status);
        $addhistory = DB::table('user_to_user_points_history')->insert($historyArray);
        if ($addhistory) {
            return true;
        } else {
            return false;
        }
    }

    // Function For Insert History Of Point Transfer To User
    function AcceptPoints(Request $request)
    {
        $user = $request->input('user');
        $sender_id = $request->input('sender');
        $notify_id = $request->input('notify_id');
        $device  = $request->input('device');

        $check_device = $this->CheckDeviceId ($user,$device);
        if($check_device){

            $notify_data = DB::select('SELECT * FROM `user_notification` WHERE id = ?', [$notify_id]);
            if (count($notify_data) != 0) {
                foreach ($notify_data as $data) {
                    $dist_notify_id = $data->dist_notify_id;
                    $status = $data->status;
                    $sender = $data->sender;
                    $reciever = $data->reciever;
                    $points = $data->points;
                }
                if (($status == 1) && ($user == $reciever) && ($sender_id == $sender)) {

                    $user_info = DB::select('SELECT * FROM `user` WHERE user_id = ?', [$user]);
                    if (count($user_info) != 0) {
                        foreach ($user_info as $user_d) {
                            $distributor_id = $user_d->distributor_id;
                        }

                        $user_data = DB::select('SELECT * FROM `user_points` WHERE user_id =  ?', [$reciever]);

                        if (count($user_data) == 0) {
                            $pointarray = array('distributor_id' => $distributor_id, 'user_id' => $reciever, 'points' => $points);
                            $id = DB::table('user_points')->insertGetId($pointarray);
                            if ($sender_id == $distributor_id) {
                                $change_status = 2;
                                $user_read = 0;
                                if ($this->ChangeUserStatus($notify_id, $change_status, $user_read)) {
                                    if ($this->ChangeDistStatus($dist_notify_id, $reciever, $change_status)) {
                                        if ($this->AddUserPointsHistory($id, $points, 'Accepted')) {
                                            $message['status'] = '200';
                                            $message['message'] = 'Transfer Successfully...';
                                        } else {
                                            $error = array('error_massage' => 'transfer point adding in user history error');
                                            DB::table('user_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'Distributor Notification Updation Error');
                                        DB::table('user_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Something Went Wrong.....';
                                    }
                                } else {
                                    $error = array('error' => 'User notification Updation error');
                                    DB::table('distributors_error')->insert($error);
                                    $message['status'] = '404';
                                    $message['error'] = 'Something Went Wrong.....';
                                }
                            } else {
                                $change_status = 2;
                                $user_read = 0;
                                if ($this->ChangeUserStatus($notify_id, $change_status, $user_read)) {
                                    if ($this->AddUserToUserPointHistory($sender_id, $user, $points, 'Accepted')) {
                                        $message['status'] = '200';
                                        $message['message'] = 'Transfer Successfully...';
                                    } else {
                                        $error = array('error_massage' => 'transfer point adding in user to user history error');
                                        DB::table('user_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Something Went Wrong.....';
                                    }
                                } else {
                                    $error = array('error' => 'User notification Updation error');
                                    DB::table('distributors_error')->insert($error);
                                    $message['status'] = '404';
                                    $message['error'] = 'Points Transfer Error';
                                }
                            }
                        } else {
                            foreach ($user_data as $data_dist) {
                                $total_points = $points + $data_dist->points;
                                $id = $data_dist->id;

                                DB::update('UPDATE `user_points` SET `points`= ? WHERE user_id = ?', [$total_points, $reciever]);

                                if ($sender_id == $distributor_id) {
                                    $change_status = 2;
                                    $user_read = 0;
                                    if ($this->ChangeUserStatus($notify_id, $change_status, $user_read)) {
                                        if ($this->ChangeDistStatus($dist_notify_id, $reciever, $change_status)) {
                                            if ($this->AddUserPointsHistory($id, $points, 'Accepted')) {
                                                $message['status'] = '200';
                                                $message['message'] = 'Point Transfer Successfully...';
                                            } else {
                                                $error = array('error_massage' => 'transfer point adding in user history error');
                                                DB::table('user_error')->insert($error);
                                                $message['status'] = '404';
                                                $message['error'] = 'Something Went Wrong.....';
                                            }
                                        } else {
                                            $error = array('error' => 'Distributor Notification Updation Error');
                                            DB::table('user_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'User notification Updation error');
                                        DB::table('distributors_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Something Went Wrong.....';
                                    }
                                } else {
                                    $change_status = 2;
                                    $user_read = 0;
                                    if ($this->ChangeUserStatus($notify_id, $change_status, $user_read)) {
                                        if ($this->AddUserToUserPointHistory($sender_id, $user, $points, 'Accepted')) {
                                            $message['status'] = '200';
                                            $message['message'] = 'Point Transfer Successfully...';
                                        } else {
                                            $error = array('error_massage' => 'transfer point adding in user to user history error');
                                            DB::table('user_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'User notification Updation error');
                                        DB::table('distributors_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Points Transfer Error';
                                    }
                                }
                            }
                        }
                    } else {
                        $message['status'] = '404';
                        $message['error'] = 'User Not Found';
                    }
                } else {
                    $message['status'] = '404';
                    $message['error'] = 'Notification Is Wrong';
                }
            } else {
                $message['status'] = '404';
                $message['error'] = 'Notification Is Wrong one';
            }
        } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
        }      
        $response = $message;
        return response()->json($response);
    }

    // Function For Insert History Of Point Transfer To User
    function RejectPoints(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = $request->input('reciever');
        $sender_id = $request->input('sender');
        $notify_id = $request->input('notify_id');
        $device  = $request->input('device');

        $check_device = $this->CheckDeviceId ($user_id,$device);
        if($check_device){
            // $notify_data = DB::select('SELECT * FROM `user_notification` WHERE id = ?', [$notify_id]);
            // if (count($notify_data) != 0) {
            //     foreach ($notify_data as $data) {
            //         $dist_notify_id = $data->dist_notify_id;
            //         $status = $data->status;
            //         $sender = $data->sender;
            //         $reciever = $data->reciever;
            //         $points = $data->points;
            //     }
            //     if (($status == 1) && ($user == $reciever) && ($sender_id == $sender)) {
            
                $notify_data = DB::select('SELECT * FROM `user_notification` WHERE id = ? AND sender = ? AND reciever = ? ORDER BY id DESC', [$notify_id,$sender_id,$user]);

                if (count($notify_data) != 0) {
                    
                    foreach ($notify_data as $data) {
                        $dist_notify_id = $data->dist_notify_id;
                        $sender = $data->sender;
                        $reciever = $data->reciever;
                        $status = $data->status;
                        $points = $data->points;
                    }

                if (($status == 1)) {
                    $user_info = DB::select('SELECT * FROM `user` WHERE user_id = ?', [$user]);
                    if (count($user_info) != 0) {
                        foreach ($user_info as $user_d) {
                            $distributor_id = $user_d->distributor_id;
                        }

                        if ($sender_id == $distributor_id) {
                            $user_data = DB::select('SELECT * FROM `user_points` WHERE user_id =  ?', [$reciever]);
                            if (count($user_data) == 0) {
                                $pointarray = array('distributor_id' => $distributor_id, 'user_id' => $reciever, 'points' => 0);
                                $id = DB::table('user_points')->insertGetId($pointarray);

                                $dist_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id = ?', [$distributor_id]);
                                if (count($dist_data) != 0) {
                                    foreach ($dist_data as $data) {
                                        $dist_point = $data->points;
                                    }
                                    $add_dist_points = $dist_point + $points;

                                    $check = DB::update('UPDATE `distributor_points` SET `points`= ? WHERE `distributor_id` = ?', [$add_dist_points, $distributor_id]);
                                    if ($check) {
                                        $change_status = 3;
                                        $user_read = 0;
                                        if ($this->ChangeUserStatus($notify_id, $change_status,$user_read)) {
                                            if ($this->ChangeDistStatus($dist_notify_id, $reciever, $change_status)) {
                                                if ($this->AddUserPointsHistory($id, $points, 'Rejected')) {
                                                    $message['status'] = '200';
                                                    $message['message'] = 'Point Rejected Successfully...';
                                                } else {
                                                    $error = array('error_massage' => 'Rejected point adding in user history error');
                                                    DB::table('user_error')->insert($error);
                                                    $message['status'] = '404';
                                                    $message['error'] = 'Something Went Wrong.....';
                                                }
                                            } else {
                                                $error = array('error' => 'Distributor Notification Updation Error');
                                                DB::table('user_error')->insert($error);
                                                $message['status'] = '404';
                                                $message['error'] = 'Something Went Wrong.....';
                                            }
                                        } else {
                                            $error = array('error' => 'User notification Updation error');
                                            DB::table('distributors_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'User Points Rejecting Error');
                                        DB::table('user_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Something Went Wrong.....';
                                    }
                                } else {
                                    $error = array('error' => 'distributor Not Found');
                                    DB::table('user_error')->insert($error);
                                    $message['status'] = '404';
                                    $message['error'] = 'Something Went Wrong.....';
                                }
                            } else {
                                foreach ($user_data as $data) {
                                    $id = $data->id;
                                }

                                $dist_data = DB::select('SELECT * FROM `distributor_points` WHERE distributor_id = ?', [$distributor_id]);
                                if (count($dist_data) != 0) {
                                    foreach ($dist_data as $data) {
                                        $dist_point = $data->points;
                                    }
                                    $add_dist_points = $dist_point + $points;

                                    $check = DB::update('UPDATE `distributor_points` SET `points`= ? WHERE `distributor_id` = ?', [$add_dist_points, $distributor_id]);
                                    if ($check) {
                                        $change_status = 3;
                                        $user_read=0;
                                        if ($this->ChangeUserStatus($notify_id, $change_status,$user_read)) {
                                            if ($this->ChangeDistStatus($dist_notify_id, $reciever, $change_status)) {
                                                if ($this->AddUserPointsHistory($id, $points, 'Rejected')) {
                                                    $message['status'] = '200';
                                                    $message['message'] = 'Point Rejected Successfully...';
                                                } else {
                                                    $error = array('error_massage' => 'Rejected point adding in user history error');
                                                    DB::table('user_error')->insert($error);
                                                    $message['status'] = '404';
                                                    $message['error'] = 'Something Went Wrong.....';
                                                }
                                            } else {
                                                $error = array('error' => 'Distributor Notification Updation Error');
                                                DB::table('user_error')->insert($error);
                                                $message['status'] = '404';
                                                $message['error'] = 'Something Went Wrong.....';
                                            }
                                        } else {
                                            $error = array('error' => 'User notification Updation error');
                                            DB::table('distributors_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'User Points Rejecting Error');
                                        DB::table('user_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Something Went Wrong.....';
                                    }
                                } else {
                                    $error = array('error' => 'distributor Not Found');
                                    DB::table('user_error')->insert($error);
                                    $message['status'] = '404';
                                    $message['error'] = 'Something Went Wrong.....';
                                }
                            }
                        } else {
                            $user_points_data = DB::select('SELECT * FROM `user_points` WHERE user_id = ?', [$sender_id]);
                            if (count($user_points_data) != 0) {
                                foreach ($user_points_data as $data) {
                                    $user_point = $data->points;
                                }
                                $add_user_points = $user_point + $points;

                                $check = DB::update('UPDATE `user_points` SET `points`= ? WHERE `user_id` = ?', [$add_user_points, $sender_id]);
                                if ($check) {
                                    $change_status = 3;
                                    $user_read=0;
                                    if ($this->ChangeUserStatus($notify_id, $change_status,$user_read)) {
                                        if ($this->AddUserToUserPointHistory($sender_id, $user, $points, 'Rejected')) {
                                            $message['status'] = '200';
                                            $message['message'] = 'Point Rejected Successfully...';
                                        } else {
                                            $error = array('error_massage' => 'transfer point adding in user to user history error');
                                            DB::table('user_error')->insert($error);
                                            $message['status'] = '404';
                                            $message['error'] = 'Something Went Wrong.....';
                                        }
                                    } else {
                                        $error = array('error' => 'User notification Updation error');
                                        DB::table('distributors_error')->insert($error);
                                        $message['status'] = '404';
                                        $message['error'] = 'Points Something Went Wrong.....';
                                    }
                                } else {
                                    $error = array('error' => 'User Points Rejecting Error Third');
                                    DB::table('user_error')->insert($error);
                                    $message['status'] = '404';
                                    $message['error'] = 'Something Went Wrong.....';
                                }
                            } else {
                                $message['status'] = '404';
                                $message['error'] = 'Something Went Wrong.....';
                            }
                        }
                    } else {
                        $error = array('error' => 'User Not Found');
                        DB::table('user_error')->insert($error);
                        $message['status'] = '404';
                        $message['error'] = 'User Not Found';
                    }
                } else {
                    $message['status'] = '404';
                    $message['error'] = 'Notification Is Wrong';
                }
            } else {
                $message['status'] = '404';
                $message['error'] = 'Notification Is Wrong One';
            }
        } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
        }      
        $response = $message;
        return response()->json($response);
    }

    // Function For Return Points To Distributor
    function ReturnPoints(Request $request)
    {
        $user_id = $request->input('user_id');
        $return_points = $request->input('points');
        $device  = $request->input('device');

        $check_device = $this->CheckDeviceId ($user_id,$device);
        if($check_device){

            $points = DB::select('SELECT `points` FROM `user_points` WHERE user_id = ?', [$user_id]);

            if (count($points) != 0) {
                foreach ($points as $points_data) {
                    if (($points_data->points != 0) && ($points_data->points > $return_points)) {
                        $distributor = DB::select('SELECT distributor_id FROM `user` WHERE user_id = ?', [$user_id]);
                        if (count($distributor) != 0) {
                            foreach ($distributor as $dist_verify) {
                                $dist_id = $dist_verify->distributor_id;
                            }
                            $dist_notify = array('reciever' => $dist_id, 'sender' => $user_id, 'points' => $return_points, 'status' => 0);
                            $check_dist_notify = DB::table('distributor_notification')->insert($dist_notify);
                            if ($check_dist_notify) {
                                $user_return_points = array('distributor_id' => $dist_id, 'user_id' => $user_id, 'return_points' => $return_points);
                                $check_dist_return = DB::table('user_return_points')->insert($user_return_points);
                                if ($check_dist_return) {
                                    $distributor_points = DB::select('SELECT points FROM `distributor_points` WHERE distributor_id = ?', [$dist_id]);
                                    if (count($distributor_points) != 0) {
                                        foreach ($distributor_points as $dist_point) {
                                            $dist_points = $dist_point->points;
                                        }
                                        $add_dist_point = $dist_points + $return_points;
                                        $dist_points_save = DB::update('UPDATE `distributor_points` SET `points`=? WHERE distributor_id = ?', [$add_dist_point, $dist_id]);
                                        if ($dist_points_save) {
                                            $user_points = $points_data->points - $return_points;
                                            $main_points = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$user_points, $user_id]);
                                            if ($main_points) {
                                                $message['status'] = '200';
                                                $message['message'] = 'Points Return Successfully';
                                            } else {
                                                $message['status'] = '404';
                                                $message['error'] = 'Points Not Returns';
                                            }
                                        } else {
                                            $message['status'] = '404';
                                            $message['error'] = 'Points Not Returns';
                                        }
                                    } else {
                                        $message['status'] = '404';
                                        $message['error'] = 'Distributo Not Found';
                                    }
                                } else {
                                    $message['status'] = '404';
                                    $message['error'] = 'Points Not Returns';
                                }
                            } else {
                                $message['status'] = '404';
                                $message['error'] = 'Points Not Returns';
                            }
                        } else {
                            $message['status'] = '404';
                            $message['error'] = 'Distributor Not Found';
                        }
                    } else {
                        $message['status'] = '404';
                        $message['error'] = 'Insufficient Points';
                    }
                }
            } else {
                $message['status'] = '404';
                $message['error'] = 'Insufficient Points...!';
            }
        } else{
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
        }     
        $response = $message;
        return response()->json($response);
    }


    //  // function for current round
    // function last_Bet_User(Request $request)
    // {
    //     $erro = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        
    //     if (count($erro) == 0) {
    //         $user_id = $request->input('user_id');
    //         $game_id = $request->input('game');
    //         $device  = $request->input('device');
    //         $message = array();
    //         $check_device = $this->CheckDeviceId ($user_id,$device);
    //         if($check_device){
            
    //             $last_round = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id", 1]);

    //             if ($last_round) {

    //                 foreach ($last_round as $round_data) {
    //                     $status = $round_data->status;

    //                     if($status == 2) {

    //                         $data =  array(
    //                             'round_count' => $round_data->round_count, 
    //                             'winning_amount' => $round_data->winning_amount,
    //                             'win_no' => $round_data->win_no, 
    //                             "no_0" => $round_data->no_0,
    //                             "no_1" => $round_data->no_1,
    //                             "no_2" => $round_data->no_2,
    //                             "no_3" => $round_data->no_3,
    //                             "no_4" => $round_data->no_4,
    //                             "no_5" => $round_data->no_5,
    //                             "no_6" => $round_data->no_6,
    //                             "no_7" => $round_data->no_7,
    //                             "no_8" => $round_data->no_8,
    //                             "no_9" => $round_data->no_9,
    //                             "is_winning_amount_add" => $round_data->is_winning_amount_add,   
    //                         );

    //                     }else{

    //                         $data =  array(
    //                             'message' => 'Please wait for finish match and update current round',
    //                             'round_count' => $round_data->round_count,
    //                             "no_0" => $round_data->no_0,
    //                             "no_1" => $round_data->no_1,
    //                             "no_2" => $round_data->no_2,
    //                             "no_3" => $round_data->no_3,
    //                             "no_4" => $round_data->no_4,
    //                             "no_5" => $round_data->no_5,
    //                             "no_6" => $round_data->no_6,
    //                             "no_7" => $round_data->no_7,
    //                             "no_8" => $round_data->no_8,
    //                             "no_9" => $round_data->no_9,
    //                             "is_winning_amount_add" => $round_data->is_winning_amount_add,
    //                         );

    //                     }
    //                 }

    //                 $message['status'] = '200';
    //                 $message['last_bet'] = $data;

    //             } else {
    //                 $message['status'] = '400';
    //                 $message['error'] = 'Round Count Not Found';
    //             }
    //         } else{
    //                 $message['message']    = 'Your Session Expired.';
    //                 $message['status']     = "401";
    //         }        
    //     } else {
    //         $message['status'] = '400';
    //         $message['error'] = 'There Is Problem In Server Side';
    //     }
    //     $response = $message;
    //     return response()->json($response);
    // }

     // function for current round
    function last_Bet_User(Request $request)
    {
        $erro = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        
        if (count($erro) == 0) {
            $user_id = $request->input('user_id');
            $game_id = $request->input('game');
            $device  = $request->input('device');
            $message = array();
            $check_device = $this->CheckDeviceId ($user_id,$device);
            if($check_device){
            
                $last_round = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id", 1]);

                if ($last_round) {

                    foreach ($last_round as $round_data) {
                        $status = $round_data->status;
                    }
                        if($status == 2) {

                            $data =  array(
                                'round_count' => $round_data->round_count, 
                                'winning_amount' => $round_data->winning_amount,
                                'win_no' => $round_data->win_no, 
                                "no_0" => $round_data->no_0,
                                "no_1" => $round_data->no_1,
                                "no_2" => $round_data->no_2,
                                "no_3" => $round_data->no_3,
                                "no_4" => $round_data->no_4,
                                "no_5" => $round_data->no_5,
                                "no_6" => $round_data->no_6,
                                "no_7" => $round_data->no_7,
                                "no_8" => $round_data->no_8,
                                "no_9" => $round_data->no_9,
                                "is_winning_amount_add" => $round_data->is_winning_amount_add,   
                            );

                            $message['status'] = '200';
                            $message['last_bet'] = $data;

                        }else{

                            $message['status'] = '400';
                            $message['error'] = 'Please wait for finish match and update current round';
                        }

                } else {
                    $message['status'] = '204';
                    $message['error'] = 'user play first round';
                }
            } else{
                    $message['message']    = 'Your Session Expired.';
                    $message['status']     = "401";
            }        
        } else {
            $message['status'] = '400';
            $message['error'] = 'There Is Problem In Server Side';
        }
        $response = $message;
        return response()->json($response);
    }

    function add_win_amount_new(Request $request)
    {
        $user_id = $request->input('user_id');
        $game_id = $request->input('game');
        $round_count = $request->input('round_count');

        $user_bal = DB::table('user_points')->where(['user_id'=>$user_id])->first();

        print_r($user_bal);die;


        $response = $message;
        return response()->json($response);
    }


    // function for take current round winning amount
    function add_win_amount(Request $request)
    {
        $erro = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        
        if (count($erro) == 0) {
            $user_id = $request->input('user_id');
            $game_id = $request->input('game');
            $round_count = $request->input('round_count');
            $device  = $request->input('device');
            $message = array();
            $check_device = $this->CheckDeviceId($user_id,$device);
            if($check_device){

                $last_round = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count", 1]);

                if (!empty($last_round)) {

                    $bet_complete = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? And status=?  ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count",2,1]);

                    if (!empty($bet_complete)) {

                        $pending_data = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? And is_winning_amount_add=?  ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count",0,1]);

                        if (count($pending_data) != 0) {

                            foreach ($pending_data as $data) {
                                $win_amount = $data->winning_amount;
                            }

                            if ($win_amount > 0) {

                                $current_balance = DB::select('SELECT `points` FROM `user_points` WHERE user_id=?', [$user_id]);
                                
                                if ($current_balance) {
 
                                    foreach ($current_balance as $balance) {
                                            $old_balance = $balance->points;
                                    }

                                    $new_balance = $old_balance + $win_amount;

                                    $upd_win_amt = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$new_balance, $user_id]);

                                    if ($upd_win_amt) {

                                        $round_report = DB::update("UPDATE `round_report` SET `is_winning_amount_add` = 1 WHERE round_count = $round_count AND player_id = '$user_id'");

                                        if ($round_report) {

                                            $message = array();

                                            $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                            if ($points) {

                                                $timestamp = time() + date("Z");
                                                $sec = gmdate("s", $timestamp);

                                                foreach ($points as $bal) {
                                                    $message['message'] = 'Successfully winning amount added';
                                                    $message['status'] = '200';
                                                    $message['coins'] = '' . $bal->points . '';
                                                    $message['sec'] = '' . $sec . '';
                                                    $message['win_amount'] = $win_amount;
                                                    $message['is_winning_amount_add'] = 1;
                                                }
                                            } else {
                                                $message['message'] = 'user point fetching error one';
                                                $message['statu'] = '404';
                                            }
                                        } else {
                                            $message['message'] = 'Round report not store';
                                            $message['statu'] = '404';
                                        }
                                    } else {
                                        $message['message'] = 'win points updation error';
                                        $message['statu'] = '404';
                                    }

                                }  else {
                                        $message['message'] = 'Current points not found';
                                        $message['statu'] = '404';
                                }    
                            } else{
                                $message['status'] = '400';
                                $message['error'] = 'Winning amount should be greater than 0';
                            }   
                        } else {
                            $message['status'] = '200';
                            $message['error'] = 'Winning amount already added';
                        }
                    }else {
                        $message['status'] = '400';
                        $message['error'] = 'Please wait for finish match and update current round';
                    }     
                } else {
                    $message['status'] = '400';
                    $message['error'] = 'Round Count Not Found';
                } 
             } else {
                $message['message']    = 'Your Session Expired.';
                $message['status']     = "401";
            }       
        } else {
            $message['status'] = '400';
            $message['error'] = 'There Is Problem In Server Side';
        }
        $response = $message;
        return response()->json($response);
    }


    // function for take current round winning amount
    function add_win_amount_old(Request $request)
    {
        $erro = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        
        if (count($erro) == 0) {
            $user_id = $request->input('user_id');
            $game_id = $request->input('game');
            $round_count = $request->input('round_count');
            $message = array(); 

            $last_round = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count", 1]);

            if (!empty($last_round)) {

                $bet_complete = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? And status=?  ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count",2,1]);

                if (!empty($bet_complete)) {

                    $pending_data = DB::select('SELECT * FROM `round_report` WHERE player_id=? AND game=? AND round_count=? And is_winning_amount_add=?  ORDER BY id DESC LIMIT ?', ["$user_id", "$game_id","$round_count",0,1]);

                    if (count($pending_data) != 0) {

                        foreach ($pending_data as $data) {
                            $win_amount = $data->winning_amount;
                        }

                        if ($win_amount > 0) {

                            $current_balance = DB::select('SELECT `points` FROM `user_points` WHERE user_id=?', [$user_id]);
                            
                            if ($current_balance) {

                                foreach ($current_balance as $balance) {
                                        $old_balance = $balance->points;
                                }

                                $new_balance = $old_balance + $win_amount;

                                $upd_win_amt = DB::update('UPDATE `user_points` SET `points`=? WHERE user_id = ?', [$new_balance, $user_id]);

                                if ($upd_win_amt) {

                                    $round_report = DB::update("UPDATE `round_report` SET `is_winning_amount_add` = 1 WHERE round_count = $round_count AND player_id = '$user_id'");

                                    if ($round_report) {

                                        $message = array();

                                        $points = DB::select('SELECT points FROM `user_points` WHERE user_id = ?', [$user_id]);

                                        if ($points) {

                                            $timestamp = time() + date("Z");
                                            $sec = gmdate("s", $timestamp);

                                            foreach ($points as $bal) {
                                                $message['message'] = 'Successfully winning amount added';
                                                $message['status'] = '200';
                                                $message['coins'] = '' . $bal->points . '';
                                                $message['sec'] = '' . $sec . '';
                                                $message['win_amount'] = $win_amount;
                                                $message['is_winning_amount_add'] = 1;
                                            }
                                        } else {
                                            $message['message'] = 'user point fetching error one';
                                            $message['statu'] = '404';
                                        }
                                    } else {
                                        $message['message'] = 'Round report not store';
                                        $message['statu'] = '404';
                                    }
                                } else {
                                    $message['message'] = 'win points updation error';
                                    $message['statu'] = '404';
                                }

                            }  else {
                                    $message['message'] = 'Current points not found';
                                    $message['statu'] = '404';
                            }    
                        } else{
                            $message['status'] = '400';
                            $message['error'] = 'Winning amount should be greater than 0';
                        }   
                    } else {
                        $message['status'] = '200';
                        $message['error'] = 'Winning amount already added';
                    }
                }else {
                    $message['status'] = '400';
                    $message['error'] = 'Please wait for finish match and update current round';
                }     
            } else {
                $message['status'] = '400';
                $message['error'] = 'Round Count Not Found';
            }       
        } else {
            $message['status'] = '400';
            $message['error'] = 'There Is Problem In Server Side';
        }
        $response = $message;
        return response()->json($response);
    }
    
    
    function test(Request $request){
        
        print_r(date('Y-m-d h:i:s'));die;
        
    }

    
}


