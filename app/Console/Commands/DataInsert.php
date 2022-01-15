<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DataInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DataInsert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //sleep(54);
        
        // $username = "amol";
        // $password = "chopade";
        // $today_date = date('Y-m-d');
        // $bet_data = array('u_name' => $username, 'pass' => $password);
        // $check = DB::table('demo')->insert($bet_data);
        
        $current_bet = DB::select('SELECT * FROM `current_bet` ORDER BY id DESC LIMIT 1');

        $current_round = DB::select('SELECT * FROM `current_round` ORDER BY cr_id DESC LIMIT 1');

            if ($current_bet && $current_round) {
                foreach ($current_bet as $bet_data) {
                    $round_count = $bet_data->round_count;
                }

                foreach ($current_round as $round_data) {
                    $curr_round_count = $round_data->round_count;
                }
            
                if ($round_count == $curr_round_count) {
                    $n_mode = DB::select('SELECT * FROM `night_mode`');
                    $j_mode = DB::select('SELECT * FROM `joker`');
                    $p_mode = DB::select('SELECT * FROM `prime_mode`');
                
                    if ((count($n_mode) != 0) && (count($j_mode) != 0) && (count($p_mode) != 0)) {
                        
                        foreach ($n_mode as $n_data) {
                            $night_mode = $n_data->mode;
                            $is_updated = $n_data->is_updated;
                        }

                        foreach ($j_mode as $j_data) {
                            $joker_mode = $j_data->mode;
                            $joker_is_updated = $j_data->is_updated;
                        }

                        foreach ($p_mode as $p_data) {
                            $prime_mode = $p_data->mode;
                            $max_limit  = $p_data->max_limit;
                        }

                        $flag = 0;
                        if($prime_mode == 1){
                            $win_x = '1x';
                            if ($this->primemode($max_limit, $round_count)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        }elseif (($night_mode == 1) && ($joker_mode == 1)) {

                            $rand_no = rand(0, 18);
                            //$rand_no = 6;
                            //$rand_no = rand(12,15);
                            $is_2x_avl = $this->check_winx_limit($x ='2x');
                            $is_4x_avl = $this->check_winx_limit($x ='4x');
                            
                            if ($rand_no == 13 && $is_2x_avl == 1) {
                                $win_x = '2x';
                            } elseif ($rand_no == 14 && $is_4x_avl == 1) {
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
                            //$rand_no = 14;
                            $is_2x_avl = $this->check_winx_limit($x ='2x');
                            $is_4x_avl = $this->check_winx_limit($x ='4x');
                            
                            if ($rand_no == 6 && $is_2x_avl == 1) {
                                $win_x = '2x';
                                if ($this->joker($win_x, $round_count)) {
                                    $flag = 1;
                                } else {
                                    $flag = 0;
                                }
                            } elseif ($rand_no == 14 && $is_4x_avl == 1) {
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
                            // $username = "amol";
                            // $password = "chopade";

                            // $bet_data = array('u_name' => $username, 'pass' => $password);
                            // $check = DB::table('demo')->insert($bet_data);
                            $win_x = '1x';
                            if ($this->nightmode($win_x, $round_count)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        } 
                    }
                } else {
                    $error = array('error_massage' => 'Round Count Not Match...');
                    DB::table('error')->insert($error);
                    return false;
                }
            } else {
                $error = array('error_massage' => 'Current Bet Current Round Data Not Found....');
                DB::table('error')->insert($error);
                return false;
            }
    }


    // Function For prime Mode
    public function primemode($max_limit, $round_count){
        if ($max_limit <= 0) return true;

        $bet_data = DB::select('SELECT * FROM `current_bet` WHERE round_count = ? LIMIT ?', [$round_count,1]);
        if(!empty($bet_data)){
           $bets = [$bet_data[0]->no_0,$bet_data[0]->no_1,$bet_data[0]->no_2,$bet_data[0]->no_3,$bet_data[0]->no_4,$bet_data[0]->no_5,$bet_data[0]->no_6,$bet_data[0]->no_7,$bet_data[0]->no_8,$bet_data[0]->no_9];
    
            $limitBets = [];

            $countZero = array_count_values($bets); //count zero amount of bet in array
            if(!empty($countZero[0]) && $countZero[0] == 10) return true;

            foreach ($bets as $key =>$val) { //save each no bet
                if($val < $max_limit) {
                    $limitBets[$key] =  $val;
                }
            }

            if(!empty($limitBets)){ //random bet
                $win_no = array_rand($limitBets,1);
                $check = DB::update('UPDATE `current_round` SET `win_no` = ? WHERE round_count = ?', [$win_no,$round_count]);
            }
        }
        return true;
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

                DB::update('UPDATE `current_round` SET `win_no` = ?, `win_x` = ? WHERE round_count = ?', [$win_no, $win_x, $round_count]);

                return true;
        } else {
            $error = array('error_massage' => 'night mode current bet query is not working');
            DB::table('error')->insert($error);
            return false;
        }
    }

    // Function For Joker Mode
    public function joker($win_x, $round_count)
    {
       
            DB::update('UPDATE `current_round` SET `win_x` = ? WHERE round_count = ?', [$win_x, $round_count]);

            return true;

    }
    
    //calculate max 4x and Max 2x in game
    public function check_winx_limit($win_x){
        $today_date = date('Y-m-d');
        $max_4x_limit = 0; $max_2x_limit= 0; $count_2x=0; $count_4x=0;

        $joker_max_2x_4x = DB::select('SELECT `Win_x`,`Max_Winx_Count` FROM `set_max_2x_4x` ORDER BY id DESC');
        foreach ($joker_max_2x_4x as  $max_x) {
            if ($max_x->Win_x == '4X') {
                 $max_4x_limit = $max_x->Max_Winx_Count;
            } elseif ($max_x->Win_x == '2X') {
                $max_2x_limit =$max_x->Max_Winx_Count;
            }
        }

        $wix = DB::select("SELECT `win_x`, count(`win_x`) AS winx_count FROM `current_round` WHERE DATE(`created`) = ? AND `win_x` IN ('4x','2x') GROUP BY `win_x`",[$today_date]);
       
        foreach ($wix as  $val) {
            if ($val->win_x == '4x') {
                 $count_4x = $val->winx_count;
            } elseif ($val->win_x == '2x') {
                $count_2x = $val->winx_count;
            }
        }
        
        if ($win_x = '2x' && $count_2x < $max_2x_limit) {
            return true;
        }elseif ($win_x = '4x' && $count_4x < $max_4x_limit) {
            return true;
        }else{
            return false;
        }

    }

            //   // Function For prime Mode
            // public function primemode($win_x, $round_count){
            //     $max_limit = 100;
            //     $bet_data = DB::select('SELECT * FROM `current_bet` WHERE round_count = ? LIMIT ?', [$round_count,1]);
            //     if(!empty($bet_data)){
            //        $bets = [$bet_data[0]->no_0,$bet_data[0]->no_1,$bet_data[0]->no_2,$bet_data[0]->no_3,$bet_data[0]->no_4,$bet_data[0]->no_5,$bet_data[0]->no_6,$bet_data[0]->no_7,$bet_data[0]->no_8,$bet_data[0]->no_9];
            //         //$bets = [0,10,20,30,80,70,40,50,10,100]; 
            //         $bets = [10,10,10,10,10,10,10,10,10,10];
            //         //$bets = [100,100,100,100,100,100,100,100,100,100]; 
            //         //$bets = [100,100,200,300,800,700,400,500,100,100]; 
            //         //$bets = [0,0,0,0,0,0,0,0,0,0];
            //         //$bets   = [0,10,10000,10,10,100,10,10,10,100];
            //         $limitBets = [];

            //         $countZero = array_count_values($bets); //count zero amount of bet in array
            //         if(!empty($countZero[0]) && $countZero[0] == 10) return true;

            //         foreach ($bets as $key =>$val) {
            //             if($val < $max_limit) {
            //                 $limitBets[$key] =  $val;
            //             }
            //         }

            //         if(!empty($limitBets)){
            //             $win_no = array_rand($limitBets,1);
            //             $check = DB::update('UPDATE `current_round` SET `win_no` = ? WHERE round_count = ?', [$win_no,$round_count]);
            //         }

                



            //         // foreach ($bets as $val) {
            //         //   if($val < $max_limit && $val > 0) array_push($limitBets, $val);
            //         // }

            //         // if(!empty($limitBets)){

            //         //     $len = (count($limitBets)-1);
            //         //     $rand_no = mt_rand(0,$len);
            //         //     $win_bet =  $limitBets[$rand_no];
            //         //     print_r( $win_bet);
            //         //     $win_no  = array_search($win_bet, $bets);

            //         //     print_r( $win_no);die;
            
            //         //     $check = DB::update('UPDATE `current_round` SET `win_no` = ? WHERE round_count = ?', [$win_no,$round_count]);
            //         // }
            //     }
            //     return true;
            // }
}
