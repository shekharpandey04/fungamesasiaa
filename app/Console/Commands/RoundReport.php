<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RoundReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RoundReport';

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
        $error = DB::select('SELECT * FROM `error` ORDER BY e_id DESC LIMIT ?', [1]);
        if (count($error) == 0) {

            // Inserting data in rondom no table
            $random_no = DB::select('SELECT * FROM `random_no` ORDER BY rand_id DESC LIMIT ?', [1]);
            if (count($random_no) == 0) {
                $rand_no = rand(0, 360);
                $round_count = 1;
                $rand_data = array('round_count' => $round_count, 'random_no' => $rand_no);
                $new_rand_no = DB::table('random_no')->insert($rand_data);
                if (!$new_rand_no) {
                    $error = 'Inserting Random No Error';
                    $error_text = array('error_massage' => $error);
                    DB::table('error')->insert($error_text);
                }
            } elseif (count($random_no) != 0) {
                $current_round = DB::select('SELECT * FROM `current_round` ORDER BY cr_id DESC LIMIT ?', [1]);
                if ($current_round) {
                    foreach ($current_round as $data) {
                        $round_count = $data->round_count;
                    }
                    $new_rand_no = rand(0, 360);
                    $next_round_count = $round_count + 1;

                    $next_rand_no = array('round_count' => $next_round_count, 'random_no' =>  $new_rand_no);
                    $new_rand_no = DB::table('random_no')->insert($next_rand_no);

                    if (!$new_rand_no) {
                        $error = 'Inserting Next Round Random No Error';
                        $error_text = array('error_massage' => $error);
                        DB::table('error')->insert($error_text);
                    }
                } else {
                    $error = 'Fetching Random No Of Current Round Error';
                    $error_text = array('error_massage' => $error);
                    DB::table('error')->insert($error_text);
                }
            } else {
                $error = 'Data Fetching Error Of random_no table';
                $error_text = array('error_massage' => $error);
                DB::table('error')->insert($error_text);
            }

            // Inseting data in admin round report
            $current_r = DB::select('SELECT * FROM `current_round` ORDER BY cr_id DESC LIMIT ?', [1]);
            if (count($current_r) != 0) {
                foreach ($current_r as $data) {
                    $round_count = $data->round_count;
                    $win_no = $data->win_no;
                    $win_X = $data->win_x;
                }
                $admin = 'admin';
                $zero = 0;
                $game = 3;
                $date = date('Y-m-d h:i:s');
                $admin_round = array('device' => $admin, 'distributor_id' => $admin, 'round_count' => $round_count, 'player_id' => $admin, 'game' => $game, 'win_X' => $win_X, "win_no" => $win_no, 'no_0' => $zero, 'no_1' => $zero, 'no_2' => $zero, 'no_3' => $zero, 'no_4' => $zero, 'no_5' => $zero, 'no_6' => $zero, 'no_7' => $zero, 'no_8' => $zero, 'no_9' => $zero,'created_at' => $date);
                $submit_admin_roud = DB::table('round_report')->insert($admin_round);

                if ($submit_admin_roud) {
                    $admin_round = array('round_count' => $round_count, 'game' => $game, 'win_X' => $win_X, 'win_no' => $win_no);
                    $admin_round_report = DB::table('admin_round_report')->insert($admin_round);

                    if (!$admin_round_report) {
                        $error = 'Data Inseting Error Admin Report';
                        $error_text = array('error_massage' => $error);
                        DB::table('error')->insert($error_text);
                    }
                } else {
                    $error = 'Data Inseting Error Round Report';
                    $error_text = array('error_massage' => $error);
                    DB::table('error')->insert($error_text);
                }
            }

            // Inseting data in current round
            $rand_no_for_win_no = DB::select('SELECT * FROM `random_no` ORDER BY rand_id DESC LIMIT ?', [1]);
            if (count($rand_no_for_win_no) != 0) {
                foreach ($rand_no_for_win_no as $data) {
                    $rand_no = $data->random_no;
                    $round_count = $data->round_count;
                }
                if (($rand_no >= 0) && ($rand_no <= 18) || ($rand_no > 342) && ($rand_no <= 360)) {
                    $win_no = 0;
                } elseif (($rand_no > 18) && ($rand_no <= 54)) {
                    $win_no = 1;
                } elseif (($rand_no > 54) && ($rand_no <= 90)) {
                    $win_no = 2;
                } elseif (($rand_no > 90) && ($rand_no <= 126)) {
                    $win_no = 3;
                } elseif (($rand_no > 126) && ($rand_no <= 162)) {
                    $win_no = 4;
                } elseif (($rand_no > 162) && ($rand_no <= 198)) {
                    $win_no = 5;
                } elseif (($rand_no > 198) && ($rand_no <= 234)) {
                    $win_no = 6;
                } elseif (($rand_no > 234) && ($rand_no <= 270)) {
                    $win_no = 7;
                } elseif (($rand_no > 270) && ($rand_no <= 306)) {
                    $win_no = 8;
                } elseif (($rand_no > 306) && ($rand_no <= 342)) {
                    $win_no = 9;
                }

                $win_x = '1x';

                $round_data = array('round_count' => $round_count, 'win_no' => $win_no, 'win_x' => $win_x);

                $current_round_data = DB::table('current_round')->insert($round_data);
                if (!$current_round_data) {
                    $error = 'Data Inseting Error Of Current Round';
                    $error_text = array('error_massage' => $error);
                    DB::table('error')->insert($error_text);
                }
            } else {
                $error = 'Data Fetching Error Of random_r table For Find The Win No.';
                $error_text = array('error_massage' => $error);
                DB::table('error')->insert($error_text);
            }

            // insert data in current bet
            $cureent_bet_round = DB::select('SELECT * FROM `random_no`ORDER BY rand_id DESC LIMIT 0, 1');
            if (count($cureent_bet_round) != 0) {
                foreach ($cureent_bet_round as $data) {
                    $round_count = $data->round_count;
                }
                $zero = 0;

                $current_b = array('round_count' => $round_count, 'no_0' => $zero, 'no_1' => $zero, 'no_2' => $zero, 'no_3' => $zero, 'no_4' => $zero, 'no_5' => $zero, 'no_6' => $zero, 'no_7' => $zero, 'no_8' => $zero, 'no_9' => $zero);

                $current_bet = DB::table('current_bet')->insert($current_b);
                if (!$current_bet) {
                    $error = 'Data Inseting Error Of Current Bet';
                    $error_text = array('error_massage' => $error);
                    DB::table('error')->insert($error_text);
                }
            } else {
                $error = 'Data Fetching Error Of random_r table For Find The Round Count.';
                $error_text = array('error_massage' => $error);
                DB::table('error')->insert($error_text);
            }

        }
    }
}
