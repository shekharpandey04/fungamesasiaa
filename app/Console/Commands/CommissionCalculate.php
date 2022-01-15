<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;


class CommissionCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CommissionCalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is useful to calculate weekly commission of the distributer.';

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
        $dateParam = date('Y-m-d'); 
        $week = date('w', strtotime($dateParam));
        $date = new DateTime($dateParam);
        $strat_Week = $date->modify("-" . $week . " day")->format("Y-m-d"); 
        $endWeek = $date->modify("-7 day")->format("Y-m-d"); 
        //$endWeek = '2021-02-25';
        $strat_Week;
        $start = $strat_Week . ' ' . date('H:i:s');
        $end = $endWeek . ' ' . date('H:i:s');
        $endWeek;

       $abc = date('Y-m-d');
       //$abc = '2021-03-14';
        $flag = 0;

        if ($strat_Week == $abc) {
               
            $distributor_list = DB::select('SELECT `distributor_id` FROM `distributor`');

            foreach ($distributor_list as  $id) {

                $dist_id = $id->distributor_id;

                $check_date = DB::select('SELECT `start_date` FROM `dist_commission` where distributor_id =?', [$dist_id]);

                foreach ($check_date as $date_check) { //check cmsn already paid or not
                    $date = explode(" ", $date_check->start_date);
                    if ($abc == $date[0]) {
                        $flag = 1;
                    }
                }

                if ($flag == 1) { //if paid

                    dump("Commission Already Saved in The System.| Distributer Id:".$dist_id."");

                } else {
                    $get_dist_id = DB::select('SELECT id FROM `user_points` WHERE distributor_id = ?', [$dist_id]);
                    $all_sum = null;
                    foreach ($get_dist_id as $get_data) {
                        $data = DB::select('SELECT * FROM `user_points_history` WHERE created_at BETWEEN ? AND ? AND user_points_id = ?', ["$endWeek", "$strat_Week", $get_data->id]);
                        $all_sum = $all_sum + collect($data)->sum('points');
                    }
            
                    $dist_data = DB::select('SELECT `percentage` FROM `distributor` WHERE distributor_id = ?', [$dist_id]);
                    $commission = null;
                    foreach ($dist_data as $per) {
                        $commission = $all_sum / 100 * $per->percentage;
                    }
                    $commission_data = array('distributor_id' => $dist_id, 'start_date' => $start, 'end_date' => $end, 'end_point' => $all_sum, 'commission' => $commission, 'payable' => $commission);
                    $check = DB::table('dist_commission')->insert($commission_data);

                    if ($check == 1) {
                        dump("Commission Has Been Saved Successfully in the System.| Distributer Id:".$dist_id."");
                    }else{
                        $error = 'Error for update commission in dist_commission table';
                        $error_text = array('error_massage' => $error);
                        DB::table('error')->insert($error_text);
                    }
                    
                }
                
            }

            
        } else {

            dump("Please wait for week day Sunday ");
        }
    }
}
