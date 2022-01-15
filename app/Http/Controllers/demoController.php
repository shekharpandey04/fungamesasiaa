<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class demoController extends Controller
{
    function data_insert(Request $request)
    {
        $username = "amol";
        $password = "chopade";

        $bet_data = array(
            'u_name' => $username, 'pass' => $password
        );
        $check = DB::table('demo')->insert($bet_data);
    }
}
