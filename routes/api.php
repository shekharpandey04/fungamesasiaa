<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route For Login User
Route::post('login', 'mobile\UserLogInController@user_login');

// Route For receivable User notification
Route::post('logout', 'mobile\UserLogInController@user_logout');

// Route For Logout User
Route::post('profile', 'mobile\UserLogInController@profile');

// Route For transferable sender notification
Route::post('sender_notification', 'mobile\UserLogInController@SenderNotification');

// Route For Logout User
Route::post('read_notification', 'mobile\UserLogInController@UserNotificationRead');

// Route For Logout User
Route::post('notification', 'mobile\UserLogInController@UserNotification');

// Route For Return Points
Route::post('user_return_points', 'mobile\UserLogInController@UserReturnPoints');

// Route For Update IMEI Number
Route::post('update_imei_no', 'mobile\UserLogInController@UpdateIMEINumber');

// Route For Update Device Number
Route::post('update_device_id', 'mobile\UserLogInController@UpdateDeviceId');

// Route For Get Images
Route::get('get_image', 'mobile\UserLogInController@get_image');

// Route For Show Return Point History
Route::post('user_return_points_history', 'mobile\UserLogInController@user_return_points_history');

// Route For Store Round Report
Route::post('update_round_info', 'mobile\ReportController@UpdateRoundInfo');

Route::post('get_sec_result', 'mobile\ReportController@GetSecResult');

Route::post('current_round', 'mobile\ReportController@CurrentRound');

Route::get('get_sec', 'mobile\ReportController@GetSec');

Route::get('get_sec_new', 'mobile\ReportController@GetSecNEW');

// Route For send point to user
Route::post('send_point_to_user', 'mobile\ReportController@AddUserPoint');

// Route For Reject Points
Route::post('/reject_points', 'mobile\ReportController@RejectPoints');

// Route For Accept Points
Route::post('/accept_points', 'mobile\ReportController@AcceptPoints');

// Route For Return Points
Route::post('/return_points', 'mobile\ReportController@ReturnPoints');

// Route For Update Points
Route::post('/update_points', 'mobile\ReportController@update_points');

// Route For Adding Current Bet
Route::post('/add_showcurrent_bet', 'mobile\ReportController@ShowCurrentBet');

// Route For Send Win Number
Route::get('/get_win_no', 'mobile\ReportController@GetWinNo');

// Route For Send Win Number
Route::post('/GameWinningNo', 'mobile\ReportController@GameWinNo');

// Route For Change Password

Route::post('/change_password', 'mobile\UserLogInController@ChangePassword');


// Route For Change Password
Route::get('/get_active_x', 'mobile\ReportController@get_active_x');

//testing route
Route::get('/test', 'mobile\UserLogInController@test');

// Route For last Bet user Play
Route::post('/lastBetUser', 'mobile\ReportController@last_Bet_User');

// Route For last Bet user Play
Route::post('/addWinAmount', 'mobile\ReportController@add_win_amount');

// Route For Get Apk version
Route::get('/getApkVersion', 'mobile\UserLogInController@get_apk_version');


// Route For Get Apk version
Route::post('/gameTimer', 'mobile\ReportController@game_timer');

Route::get('/TimerTest', 'Controller@GameTimer');

Route::post('/send_contact_info', 'Controller@SendContactInfo');



