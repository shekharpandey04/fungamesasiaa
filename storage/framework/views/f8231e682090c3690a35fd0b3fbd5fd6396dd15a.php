<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(url('GameImage\user.png')); ?>" type="image/ico" />
    <link rel="manifest" href="<?php echo e(url('manifest.json')); ?>">
    <title>Main Admin</title>
    <style type="text/css">
        .display-notification{
            margin-top: 13px;
        }
    </style>
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
                            <h2>Main Admin</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="<?php echo e(url('/main_dashboard')); ?>"><i class="fa fa-home"></i>Dashboard</a></li>

                                <li>
                                    <a>
                                        <i class="fa fa-user"></i>Distributor Managment<span class="fa fa-chevron-down" style="width: 0px;"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <a href="<?php echo e(url('/AddNewDistributor')); ?>"><i class="fa fa-user-plus"></i>Add New
                                                Distributor</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/DistributorList')); ?>"><i class="fa fa-user"></i>Distributor List</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a><i class="fa fa-calendar"></i>Reports<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        
                                <li><a href="<?php echo e(url('Maincommission_list')); ?>"><i class="fa fa-calendar"></i>Commission List</a></li>
                                
                            </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-rupee"></i>Cashier<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo e(url('/DistributorSendPoint')); ?>"><i class="fa fa-exchange"></i>Send Points to
                                            Distributor</a></li>
                                    <li><a href="<?php echo e(url('/DistPointreport')); ?>"><i class="fa fa-calendar"></i>Point
                                            Report</a></li>
                                    
                                </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-cogs"></i>Setting<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo e(url('ChangeMainAdminPassword')); ?>"><i class="fa fa-lock"></i>Change
                                            Password</a></li>
                                    <li><a href="<?php echo e(url('MainAdminChangePin')); ?>"><i class="fa fa-key"></i>Change Pin</a></li>
                                    <li><a href="<?php echo e(url('MainAdminSetVersion')); ?>"><i class="fa fa-android"></i>Version</a></li>
                                    <li><a href="<?php echo e(url('ShowCurrentBet')); ?>"><i class="fa fa-calendar"></i>Show Current Bet</a></li>
                                    <!-- <li><a href="<?php echo e(url('SetWinningBetLimit')); ?>"><i class="fa fa-calendar"></i>Set Winning Bet Limit</a></li> -->
                                    <!--<li><a href="<?php echo e(url('SetWinNo')); ?>"><i class="fa fa-trophy"></i>Set Win No</a></li>-->
                                    <!-- <li><a href="<?php echo e(url('SetXImage')); ?>"><i class="fa fa-calendar"></i>Set 2x Or 4X</a></li> -->
                                </ul>
                            </li>


                            
                            
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
                            <li><a href="<?php echo e(url('/Mainlogout')); ?>"><i class="fa fa-sign-out"></i>&nbsp;Logout</a></li>
                            
                            <li>
                                <a href="<?php echo e(url('main_dashboard')); ?>">
                                    <img src="<?php echo e(url('GameImage\notification_icon.png')); ?>" width="22px" alt="notification icon">
                                    &nbsp;<span class="badge"><?php echo e(Session::get('admin_notify_count')); ?></span>
                                </a>
                                
            </li>
             <li><button  class="btn btn-success display-notification" onclick="initFirebaseMessagingRegistration()" role="button" >Allow notification</button></li>
            </ul>
        </div>


        </li>

        </ul>

        </nav>
    </div>
    </div>

    </div>
    </div>

     <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
         var firebaseConfig = {
          apiKey: "AIzaSyAgB18oFEEZlMDoLtLsYyP4-MX1LPqCMmo",
          authDomain: "fungameasiaa-df450.firebaseapp.com",
          projectId: "fungameasiaa-df450",
          storageBucket: "fungameasiaa-df450.appspot.com",
          messagingSenderId: "118969680477",
          appId: "1:118969680477:web:9da450766f97491e4803b4",
          measurementId: "G-PG40DXTLL4"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        //Message request permittion

        // messaging.requestPermission().then(function(permission) {
        //       console.log("notificaton Allow");
        // }).catch(function(err){
        //     console.log('unable notification',err);
        // });

        function initFirebaseMessagingRegistration() {
                messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '<?php echo e(url("save_token")); ?>',
                        type: 'POST',
                        data: {
                            "device_token": token,
                            "_token": "<?php echo e(csrf_token()); ?>",
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert(response);
                        },
                        error: function (err) {
                            console.log('An error occurred while save token'+ err);
                        },
                    });

                }).catch(function (err) {
                     alert("Something wrong, Notification not allowed.");
                    //console.log('An error occurred while retrieving token.'+ err);
                });
        }

        // window.onload = function() {
        //   initFirebaseMessagingRegistration();
        // };

        messaging.onMessage(function(payload) {
            const noteTitle = payload.data.title;
            const noteOptions = {
                body: payload.data.body,
                icon: payload.data.icon,
                image: payload.data.image,
                data : {
                  time: new Date(Date.now()).toString(),
                  click_action : payload.data.click_action,
                }
            };
            new Notification(noteTitle, noteOptions);
        });
    </script>  
    <!-- End Firebase -->



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

</html><?php /**PATH /var/www/html/fungames_asiaa/resources/views/main_admin/sidebar/sidebar.blade.php ENDPATH**/ ?>