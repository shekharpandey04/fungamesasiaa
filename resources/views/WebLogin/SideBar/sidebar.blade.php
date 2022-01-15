<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta http-equiv="refresh" content="30" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{url('GameImage\user.png')}}" type="image/ico" />
    <title>Admin</title>
    @include('admin.head.head')
</head>

<body class="nav-md" oncontextmenu="return false">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a class="site_title"><span>FUN GAME</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{url('GameImage\user.png')}}" alt="ProfileImage" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{$user_id}}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i>Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                </li>
                </ul>
            </div>
        </div>

    </div>
    </div>


</body>

</html>