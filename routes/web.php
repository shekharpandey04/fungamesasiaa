<?php


//Andromeda



// Route::get('/', function () {
//     return view('login');
// });

use Illuminate\Support\Facades\DB;
use App\Http\Middleware\CheckAdminLogin;
use App\Http\Middleware\MainAdminLogin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*************************************************************************** */
//              Admin Login Route
// $schedule->call('MyController@MyAction')->everyMinute();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', function () {
    return view('admin.demo');
});

Route::get('/fcm', 'Controller@index');
Route::post('/save_token', 'Controller@saveToken');
Route::post('/send_notification', 'Controller@sendNotification');
Route::get('/sendn', 'Controller@sendNotificationFCM');

Route::get('/demo_data', 'demoController@data_insert');

Route::get('/backoffice', function () {
    return view('admin.login');
});
Route::get('/main-admin', function () {
    return view('main_admin.login');
});
Route::post('/login', 'LogInController@dist_login');

Route::get('/logout', 'LogInController@logout');

Route::get('/dashboard', 'LogInController@dashboard')->Middleware(CheckAdminLogin::class);

//Route For Display Notification
Route::get('/DisplayNotify/{id}', 'LogInController@DisplayNotify')->Middleware(CheckAdminLogin::class);

/******************************************************************************** */
//                     Admin SEND POINTS ROUTES
// Route FOr Show Send Point Page
Route::get('/SendPoint', 'SendPointController@ShowHistory')->Middleware(CheckAdminLogin::class);

// Route For Send Point To Player
Route::get('/SendPointToPlayer/{id}', 'SendPointController@SendPointToPlayer')->Middleware(CheckAdminLogin::class);

// Route For Send User Point
Route::post('/AddUserPoints', 'SendPointController@AddUserPoint')->Middleware(CheckAdminLogin::class);

// Route For Cut Points Of Player
Route::get('/CutPointsOfPlayer/{id}', 'SendPointController@CutPointsOfPlayer')->Middleware(CheckAdminLogin::class);

// Route For Send User Point
Route::post('/CutUserPoints', 'SendPointController@CutUserPoints')->Middleware(CheckAdminLogin::class);

// Route::post('/AddUserPoints', 'SendPointController@AddUserPoint')->Middleware(CheckAdminLogin::class);

Route::get('/UserPointreport', 'SendPointController@UserPointReport')->Middleware(CheckAdminLogin::class);
// Route For Show Report
Route::get('/SortUserPointHistory/{SortData}', 'SendPointController@SortUserPointHistory')->Middleware(CheckAdminLogin::class);
Route::post('/CustomUserPointHistory', 'SendPointController@CustomUserPointHistory')->Middleware(CheckAdminLogin::class);

// Route For Get User History By User Id
Route::get('/GetHistoryByUserId/{user_id}', 'SendPointController@ShowhistoryByUserId')->Middleware(CheckAdminLogin::class);

/******************************************************************************** */
//                     Admin Accept And Reject POINTS ROUTES

// Route For Accept Points From Main Admin Page
Route::get('/dist_accept_point/{notify_id}', 'SendPointController@AcceptPoints')->Middleware(CheckAdminLogin::class);

// Route For Reject Points Of Main Admin
Route::get('/dist_reject_point/{notify_id}', 'SendPointController@RejectPoints')->Middleware(CheckAdminLogin::class);

/******************************************************************************** */
//                     Admin Route For Adding New User
Route::get('/AddNewUser', 'NewPlayerController@new_user')->Middleware(CheckAdminLogin::class);

// Route For ADD New Player
Route::post('/AddNewPlayer', 'NewPlayerController@AddNewPlayer')->Middleware(CheckAdminLogin::class);

// Route For Update Player Data
Route::get('/edit_player/{id}', 'NewPlayerController@GetUserInfo')->Middleware(CheckAdminLogin::class);
Route::post('/UpdatePlayer/{id}', 'NewPlayerController@UpdateUserInfo')->Middleware(CheckAdminLogin::class);

// Route For Blocked User
Route::get('/BlockUser/{id}', 'NewPlayerController@BlockedUser')->Middleware(CheckAdminLogin::class);

// Route For UnBlocked User
Route::get('/UnBlockUser/{id}', 'NewPlayerController@UnBlockedUser')->Middleware(CheckAdminLogin::class);

//Route For Display Player List
Route::get('/PlayerList', 'NewPlayerController@PlayerList')->Middleware(CheckAdminLogin::class);

// Route For logout User
Route::get('/userlogout/{id}', 'NewPlayerController@user_logout')->Middleware(CheckAdminLogin::class);

// Route For Cheange Password
Route::get('/ChangePassword/{id}', function ($id) {
    $data = DB::select('SELECT `user_id`, `distributor_id` FROM `user` WHERE user_id=?', [$id]);
    return view('admin.pages.AddPlayer.UpdatePassword', array('data' => $data));
})->Middleware(CheckAdminLogin::class);

Route::post('/UpdatePassword/{id}', 'NewPlayerController@UpdatePassword')->Middleware(CheckAdminLogin::class);


/****************************************************************************************************** */
//                  Admin Route For Reports

// Route for BusinessReport
Route::get('/BusinessReport', 'BusinessReportController@BusinessReport')->Middleware(CheckAdminLogin::class);

//  Route For Display Commission Report
Route::get('commission_list', 'BusinessReportController@DisplayBusinessReports')->Middleware(CheckAdminLogin::class);

// Route For CasionGmeReport
Route::get('/CasionGameReport', 'BusinessReportController@CasionGameReport')->Middleware(CheckAdminLogin::class);

Route::post('/GetRoundData', 'BusinessReportController@GetRoundData')->Middleware(CheckAdminLogin::class);
Route::post('/GetDataByUserId', 'BusinessReportController@GetDataByUserId')->Middleware(CheckAdminLogin::class);


/******************************************************************************************************** */
//                             Admin Route For Setting

// Route For Change Password
Route::get('/ChangeAdminPassword', function () {
    return view('admin.pages.Setting.ChangePassword');
})->Middleware(CheckAdminLogin::class);
Route::post('/ChangePassword', 'DistributorSettingController@ChangePassword')->Middleware(CheckAdminLogin::class);

// Route For Change Pin
Route::get('/ChangePin', function () {
    return view('admin.pages.Setting.ChangePin');
})->Middleware(CheckAdminLogin::class);
Route::post('/UpdatePin', 'DistributorSettingController@UpdatePin')->Middleware(CheckAdminLogin::class);

// Route For Return Point To Admin
Route::get('/ReturnPoints', function () {
    return view('admin.pages.Setting.ReturnPoints');
})->Middleware(CheckAdminLogin::class);

Route::post('/ReturnPoints', 'DistributorSettingController@ReturnPoints')->Middleware(CheckAdminLogin::class);

Route::get('/ReturnPointsHistory', 'DistributorSettingController@ReturnPointsHistory')->Middleware(CheckAdminLogin::class);

// Route For Show UserReturnPointsHistory
Route::get('/UserReturnPointsHistory', 'DistributorSettingController@UserReturnPointsHistory')->Middleware(CheckAdminLogin::class);

/*****************************************************************************************************************************
 * ********************************************************************************************************************
 * *********************************************************************************************************************
 */
//                  Main Admin Route

Route::post('/LoginMainAdmin', 'MainAdmin\LoginMainAdminController@LoginMainAdmin');

// Route For Logout main Admin
Route::get('/Mainlogout', 'MainAdmin\LoginMainAdminController@Logout');

Route::get('/main_dashboard', 'MainAdmin\LoginMainAdminController@ShowMainDashboard')->Middleware(MainAdminLogin::class);

// Route For Adding New Distributor
Route::get('/AddNewDistributor', 'MainAdmin\AddNewDistributorController@create_dist_id')->Middleware(MainAdminLogin::class);

// Route for Adding New Distributor
Route::post('/AddDistributor', 'MainAdmin\AddNewDistributorController@AddNewDistributor')->Middleware(MainAdminLogin::class);

// rOUTE fOR Edit edit_distributor
Route::get('/edit_distributor/{id}', 'MainAdmin\AddNewDistributorController@edit_distributor')->Middleware(MainAdminLogin::class);
Route::post('/UpdateDist/{id}', 'MainAdmin\AddNewDistributorController@UpdateDist')->Middleware(MainAdminLogin::class);

// Route For Blocked Dist
Route::get('/BlockDist/{id}', 'MainAdmin\AddNewDistributorController@BlockedDist')->Middleware(MainAdminLogin::class);
// Route For Un Blocked Dist
Route::get('/UnBlockDist/{id}', 'MainAdmin\AddNewDistributorController@UnBlockDist')->Middleware(MainAdminLogin::class);
// Route For Change Password of Dist
Route::get('/ChangeDistPassword/{id}', function ($id) {
    return view('main_admin.pages.AddDist.UpdatePassword', ['dist_id' => $id]);
})->Middleware(MainAdminLogin::class);

//Route For Update password
Route::post('/UpdateDistPassword/{id}', 'MainAdmin\AddNewDistributorController@UpdateDistPassword')->Middleware(MainAdminLogin::class);

// Route For Dist Logout
Route::get('Distlogout/{id}', 'MainAdmin\LoginMainAdminController@DistLogout')->Middleware(MainAdminLogin::class);

//Route For Add Points To Dist
Route::post('/AddDistPoints', 'MainAdmin\AddDistPointsController@AddDistPoints')->Middleware(MainAdminLogin::class);

// Route For Send Points Distributor Point
Route::get('/DistributorSendPoint', 'MainAdmin\AddDistPointsController@DistributorSendPoint')->Middleware(MainAdminLogin::class);

// Route For Dist Point Report
Route::get('/DistPointreport', 'MainAdmin\AddDistPointsController@DistPointReport')->Middleware(MainAdminLogin::class);

// Route For Get History Data By Dist Id
Route::get('GetHistoryByDistId/{id}', 'MainAdmin\AddDistPointsController@GetHistoryByDistId')->Middleware(MainAdminLogin::class);

//Route For Display Distributor List
Route::get('/DistributorList', 'MainAdmin\AddDistPointsController@DistributorList')->Middleware(MainAdminLogin::class);

// ROute FOr Show Dist Report
Route::geT('/SortDistPointHistory/{SortData}', 'MainAdmin\DistPointHistoryController@SortDistPointHistory')->Middleware(MainAdminLogin::class);

// Route For Show Custom Dist Point History
Route::post('/CustomDistPointHistory', 'MainAdmin\DistPointHistoryController@CustomDistPointHistory')->Middleware(MainAdminLogin::class);

//Route For Change Password
Route::get('/ChangeMainAdminPassword', function () {
    return view('main_admin.pages.Setting.ChangeMainAdminPassword');
})->Middleware(MainAdminLogin::class);

// Route For Update Password
Route::post('/UpdateMainAdminPassword', 'MainAdmin\MainAdminSettingController@UpdateMainAdminPassword')->Middleware(MainAdminLogin::class);

// ROute For Update Main Admin Pin
Route::get('MainAdminChangePin', function () {
    return view('main_admin.pages.Setting.ChangeMainAdminPin');
})->Middleware(MainAdminLogin::class);

// Route For Update Main Admin Pin
Route::post('/MainAdminUpdatePin', 'MainAdmin\MainAdminSettingController@UpdateMainAdminPin')->Middleware(MainAdminLogin::class);

// Route For Change Setting like version
Route::get('/MainAdminSetVersion', function () {
    $data = DB::table('setting')->first();
    return view('main_admin.pages.Setting.ChangeVersionCode',array('data' => $data));
})->Middleware(MainAdminLogin::class);

Route::post('/updateApkVersion', 'MainAdmin\MainAdminSettingController@UpdateVersion')->Middleware(MainAdminLogin::class);

// Route For Night Mode
Route::get('/night_mode', 'MainAdmin\MainAdminSettingController@changeNightMode')->Middleware(MainAdminLogin::class);

// Route For Night Mode
Route::get('/joker_mode', 'MainAdmin\MainAdminSettingController@changeJokerMode')->Middleware(MainAdminLogin::class);

// Route For prime mode
Route::get('/prime_mode', 'MainAdmin\MainAdminSettingController@changePrimeMode')->Middleware(MainAdminLogin::class);

// Route For Set 2X Or 4X Image
// Route::get('SetXImage', function () {
//     return view('main_admin.pages.Setting.SetXImage');
// })->Middleware(MainAdminLogin::class);

// Route For Set 2x
// Route::get('/Active/{x}', 'MainAdmin\MainAdminSettingController@ActiveImage')->Middleware(MainAdminLogin::class);
// Route For ReSet 2x
// Route::get('/DeActive/{x}', 'MainAdmin\MainAdminSettingController@DeActiveImage')->Middleware(MainAdminLogin::class);

// Route For Show ShowCurrentBet
Route::get('/ShowCurrentBet', 'MainAdmin\MainAdminSettingController@ShowCurrentBet')->Middleware(MainAdminLogin::class);
// Route For Getting All Data Of Bet
Route::get('GetAllBetData', 'MainAdmin\MainAdminSettingController@ShowAllCurrentBet')->Middleware(MainAdminLogin::class);

// Route for Set Win No
// Route::get('/SetWinNo', function () {
//     return view('main_admin.pages.Setting.SetWinNo');
// })->Middleware(MainAdminLogin::class);

Route::get('/SetWinNo', 'MainAdmin\MainAdminSettingController@SetWinNo')->Middleware(MainAdminLogin::class);
// Route FOr Set Max Winx in game
Route::get('/SetMaxWinX', 'MainAdmin\MainAdminSettingController@SetMaxWinX')->Middleware(MainAdminLogin::class);
// Route FOr Update Max Winx in game
Route::post('/UpdateMaxWinx', 'MainAdmin\MainAdminSettingController@UpdateMaxWinx')->Middleware(MainAdminLogin::class);
// Route FOr Set Max Limit Of Winning Bet Amount 
Route::get('/SetWinningBetLimit', 'MainAdmin\MainAdminSettingController@SetWinningBetLimit')->Middleware(MainAdminLogin::class);
// Route FOr Update Max Limit Of Winning Bet
Route::post('/UpdateMaxBetLimit', 'MainAdmin\MainAdminSettingController@UpdateMaxBetLimit')->Middleware(MainAdminLogin::class);
// Route FOr Add Win Number
Route::post('/AddWinNo', 'MainAdmin\MainAdminSettingController@AddWinNumber')->Middleware(MainAdminLogin::class);
// Route FOr Reset Win Number
// Route::get('/ResetWinNumber', 'MainAdmin\MainAdminSettingController@ResetWinNumber')->Middleware(MainAdminLogin::class);

// Route For Main Admin Notify
Route::get('/MainAdminNotify/{id}', 'MainAdmin\MainAdminSettingController@MainAdminNotify')->Middleware(MainAdminLogin::class);

// Route For delete notification
Route::get('/DeleteNotify', 'MainAdmin\MainAdminSettingController@DeleteAllNotification')->Middleware(MainAdminLogin::class);

// Route For Show Main commission list
Route::get('/Maincommission_list', 'MainAdmin\MainAdminBusinessReportController@MainCommissionList')->Middleware(MainAdminLogin::class);

// Route For Get Main Admin Commission List
Route::get('/GetAdminCommission/{id}', 'MainAdmin\MainAdminBusinessReportController@GetMainAdminCommissionList')->Middleware(MainAdminLogin::class);

Route::get('/GamePlayTimer/{id}', 'Controller@GameTimer');









// route for clear all cache data
Route::get('/cache_data', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('event:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
});


/******************************************************************************* */
//                  Route For Main Pages

Route::post('/send_info', 'Controller@SendInfo');

Route::post('/WebLogin', 'Controller@DummyLogin');
