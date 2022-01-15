<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(url('GameImage\user.png')); ?>" type="image/ico" />
    <title>Admin</title>
    <?php echo $__env->make('admin.head.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="nav-md" oncontextmenu="return false">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo e(url('dashboard')); ?>" class="site_title"><span>FUN GAME</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?php echo e(url('GameImage\user.png')); ?>" alt="ProfileImage" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Distributer</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="<?php echo e(url('/dashboard')); ?>"><i class="fa fa-home"></i>Dashboard</a></li>

                                <li>
                                    <a>
                                        <i class="fa fa-user"></i>Player Managment<span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <a href="<?php echo e(url('/AddNewUser')); ?>"><i class="fa fa-user-plus"></i>Add New
                                                Player</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/PlayerList')); ?>"><i class="fa fa-user"></i>Player List</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a><i class="fa fa-calendar"></i>Reports<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo e(url('BusinessReport')); ?>"><i class="fa fa-calendar"></i>Business Report</a></li>
                                        <li><a href="<?php echo e(url('commission_list')); ?>"><i class="fa fa-calendar"></i>Commission List</a></li>
                                        <li><a href="<?php echo e(url('CasionGameReport')); ?>"><i class="fa fa-calendar"></i>Casino Game Report</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a><i class="fa fa-rupee"></i>Cashier<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo e(url('/SendPoint')); ?>"><i class="fa fa-exchange"></i>Send Points to
                                                User</a></li>
                                        <li><a href="<?php echo e(url('/UserPointreport')); ?>"><i class="fa fa-calendar"></i>Point
                                                Report</a></li>
                                        
                                    </ul>
                                </li>
                                <li>
                                    <a><i class="fa fa-cogs"></i>Setting<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo e(url('ChangeAdminPassword')); ?>"><i class="fa fa-lock"></i>Change
                                                Password</a></li>
                                        <li><a href="<?php echo e(url('ChangePin')); ?>"><i class="fa fa-key"></i>Change Pin</a></li>
                                        <li><a href="<?php echo e(url('ReturnPoints')); ?>"><i class="fa fa-mail-forward"></i>Return
                                                Points</a></li>
                                        <li><a href="<?php echo e(url('ReturnPointsHistory')); ?>"><i class="fa fa-calendar"></i>Return Points Histroy</a></li>
                                        <!--<li><a href="<?php echo e(url('UserReturnPointsHistory')); ?>"><i class="fa fa-calendar"></i>User Return Points Histroy</a></li>-->
                                    </ul>
                                </li>


                                <!-- <li><a href="<?php echo e(url('/SendPoint')); ?>"><i class="fa fa-edit"></i>Send Points to
                                User</a>
                                </li>  -->
                                <!--  <li><a href="request.php"><i class="fa fa-user"></i>User Request</a></li>
                                <li><a href="add_game.php"><i class="fa fa-delicious"></i>Add Game</a></li>
                                <li><a href="result.php"><i class="fa fa-trophy"></i>Upload Result</a></li>
                                <li><a href="profile.php"><i class="fa fa-users"></i>User Profile</a></li>
                                <li><a><i class="fa fa-user"></i>User Points Details<span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="user_points.php">User Points</a></li>
                                        <li><a href="report_userwise.php">Userwise</a></li>
                                        <li><a href="report_datewise.php">Datewise</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-calendar"></i>Reports Datewise<span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="report_single.php">Single</a></li>
                                        <li><a href="report_jodi.php">Jodi</a></li>
                                        <li><a href="report_patta.php">Single Patta</a></li>
                                    </ul>
                                </li>
                                <li><a href="report_respond.php"><i class="fa fa-line-chart"></i>Withdraw Report</a>
                                </li>
                                <li><a href="daily_report.php"><i class="fa fa-line-chart"></i>Daily Profit Report</a>
                                </li>
                                <li><a href="show_result.php"><i class="fa fa-users"></i>Winner List</a></li>
                                <li><a href="notification.php"><i class="fa fa-bullhorn"></i>Add Offers</a></li> -->
                                <!-- <li><a href="result_notify.php"> <i class="fa fa-bullhorn"></i>Notfication</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-sign-out"></i>&nbsp;Logout</a></li>
                            <li><a href="#"><img src="<?php echo e(url('GameImage\coins.svg')); ?>" width="25px" alt="coins icon">&nbsp;<?php echo e(Session::get('dist_points')); ?></a></li>
                            <li>
                                <a href="<?php echo e(url('dashboard')); ?>">
                                    <img src="<?php echo e(url('GameImage\notification_icon.png')); ?>" width="22px" alt="notification icon">
                                    &nbsp;<span class="badge"><?php echo e(Session::get('notify_count')); ?></span>
                                </a>
                                
            </li>

            </ul>
        </div>

        </li>

        </ul>

        </nav>
    </div>
    </div>

    </div>
    </div>
<script>
        document.onkeydown = function(e) {
    if (event.keyCode == 123) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
}
    </script>

</body>

</html>
<?php /**PATH /var/www/html/fungames_asiaa/resources/views/admin/sidebar/sidebar.blade.php ENDPATH**/ ?>