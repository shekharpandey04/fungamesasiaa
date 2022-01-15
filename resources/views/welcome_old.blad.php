<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome To FunGameAsiaa</title>
    <link rel="icon" href="{{url('GameImage/logo.png')}}">
    <link href="{{url('GameImage/logo.png')}}" rel="icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.13.0/css/mdb.min.css" rel="stylesheet">
    
    <meta name="description" content="FunGameAsiaa play games and fun more">
    <meta name="og:title" content="FunGameAsiaa play game and fun more">
    <meta name="twitter:title" content="FunGameAsiaa Play games Fun more">
    <style type="text/css">
        .md-form input[type="text"]:not(.browser-default), .md-form input[type="password"]:not(.browser-default){
           background-color:#fff;
           border:1px solid #ccc;
           padding: 5px 4px;
        }
        hr {
            width:80%;
            text-align:left;
            margin-left:0
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc; 
            padding: 0;
            margin-bottom:0; 
            margin-top:1em;
        }

    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 col-sm-12 text-center">
                <img src="{{url('GameImage\logo.png')}}" class="rounded-circle img-fluid" height="150px" width="150px"
                    alt="FunGamesAsia Logo">
            </div>
            <div class="col-md-6 col-sm-12 mt-5 text-center">
                <h1><b>Welcome To FunGameAsiaa</b></h1>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:5%">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4 card py-4 px-4" style="background-color:#c58c61;">
                <div class="flash-message">
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}" style="font-size: 17px">
                        {{ Session::get('message') }}</p>
                    {{ Session::forget('message') }}
                    @endif
                    @if(Session::has('error'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}" style="font-size: 17px">
                        {{ Session::get('error') }}</p>
                    {{ Session::forget('error') }}
                    @endif
                </div>
                <h5 class="text-center text-white" style="font-weight:400;">Sign In</h5>
                <form action="{{url('/WebLogin')}}" oncopy="return false" oncut="return false" onpaste="return false"
                    method="post" class="form-group">
                    @csrf
                    <!-- Material input -->
                    <div class="md-form">
                        <i class="fas fa-user prefix" style="color:#fff"></i>
                        <input type="text" id="user" name="user_id" autocomplete="off" required class="form-control" placeholder="User Id">
                        <!-- <label for="user">User Id</label> -->
                        <div class="alert alert-danger" id="show_user_error" role="alert">
                        </div>
                    </div>
                    <div class="md-form">
                        <i class="fas fa-lock prefix" style="color:#fff"></i>
                        <input type="password" id="password" name="password" autocomplete="off" class="form-control" placeholder="Password">
                        <!-- <label for="password">Password</label> -->
                        <div class="alert alert-danger" id="show_password_error" role="alert">
                        </div>
                    </div>
                    <input type="submit" id="sign" class="btn" value="Sign In" style="background-color:#8ad919;color:#fff">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modalQuickView">Contact Us</button>
                </form>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6 col-sm-12 py-4 px-4 card">
                <h2 class="text-center"><b><i>For amusement only</i></b></h2>
                <h4 class="mt-5 text-center">Download App Today and Start Playing.</h4>
                <div class="mt-5 text-center">
                    <a href="{{url('app\fungameasiaa.apk')}}" download="FunGamesAsiaa" class="btn btn-success px-1"><i
                            class="fa-3x fab fa-android px-2 py-2" aria-hidden="true"> Mobile</i> </a>
                    <a href="{{url('app\fungameasiaa.exe.zip')}}" download="FunGamesAsiaa" class="btn btn-info px-1"><i
                            class="fa-3x fab  fa-windows px-2 py-2" aria-hidden="true">Windows</i> </a>
                    <!-- <a href="{{url('app\fungameasia.apk')}}" download="FunGamesAsia" class="btn btn-info  px-1"><i class="fa-3x fab fa-windows px-2 py-2" aria-hidden="true"> Windows</i> </a> -->
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="mymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 pull-right"></div>
                        <div class="col-md-2">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Windows App</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <h2 class="text-center">Windows App Comming Soon</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!--
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalQuickView">Launch
        modal</button> -->
    <!-- Modal: modalQuickView -->
    <div class="modal fade" id="modalQuickView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 pull-right"></div>
                        <div class="col-md-2">
                            <!-- <a href="" class=""> <i class="fas fa-close prefix"></i></a> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Contact Us</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">

                            <form action="{{url('send_info')}}" method="post" class="form-group">
                                {{ csrf_field() }}                                <!-- Material input -->
                                <div class="md-form">
                                    <i class="fas fa-user prefix"></i>
                                    <input type="text" id="name" required name="name" autocomplete="off"
                                        class="form-control">
                                    <label for="name">Name</label>
                                    <!-- <div class="alert alert-danger" id="show_name_error" role="alert">
                                    </div> -->
                                </div>
                                <div class="md-form">
                                    <i class="fas fa-lock prefix"></i>
                                    <input type="number" min="1" required id="phone_no" autocomplete="off" name="number"
                                        class="form-control">
                                    <label for="phone_no">Phone Number</label>
                                    <!-- <div class="alert alert-danger" id="show_phone_no_error" role="alert">
                                    </div> -->
                                </div>
                                <div class="md-form">
                                    <i class="fas fa-envelope prefix"></i>
                                    <input type="email" id="email" required autocomplete="off" name="email"
                                        class="form-control">
                                    <label for="email">Email</label>
                                    <!-- <div class="alert alert-danger" id="show_email_error" role="alert">
                                    </div> -->
                                </div>
                                <div class="md-form">
                                    <i class="fas fa-map-marker-alt prefix"></i>
                                    <input type="text" id="location" required autocomplete="off" name="location"
                                        class="form-control">
                                    <label for="location">Location</label>
                                    <!-- <div class="alert alert-danger" id="show_location_error" role="alert">
                                    </div> -->
                                </div>
                                <div class="md-form">
                                    <i class="fas fa-envelope prefix"></i>
                                    <textarea type="text" id="message" name="message" autocomplete="off" required
                                        class="md-textarea form-control" rows="4"></textarea>
                                    <label data-error="wrong" data-success="right" for="form8">Your message</label>
                                    <!-- <div class="alert alert-danger" id="show_message_error" role="alert">
                                    </div> -->
                                </div>
                                <input type="submit" id="send_contact" value="Submit" class="btn btn-unique">
                                <!-- <button type="button" class="btn btn-deep-purple" data-dismiss="modal">Close</button> -->
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



     <div class="container">
        <div class="row">
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom text-center">
                    <img src="{{url('GameImage/funtarget1.jpeg')}}" width="100%" height="100%" class="img-fluid "
                        alt="Fun Roulette"><br>
                    <div class="mask flex-center waves-effect waves-light"><
                        <p style="color:#fff">Start</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom text-center">
                    <img src="{{url('GameImage/funtarget2.jpeg')}}" height="350px"
                      class="img-fluid " alt="Fun Target"><br>
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Login</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom text-center">
                    <img src="{{url('GameImage/funtarget3.jpeg')}}" height="350px"
                       class="img-fluid " alt="Fun Card"><br>
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Select Game</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom text-center">
                    <img src="{{url('GameImage/funtarget4.jpeg')}}" class="img-fluid " alt="Fun Matka"><br>
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Play Game</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center"><h3>Fun Target Timer</h3></div>

        <!-- <div class="row">
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom">
                    <img src="{{url('GameImage/sc6.jpeg')}}" class="img-fluid " alt="zoom">
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Fun Target</p>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom">
                    <img src="{{url('GameImage/sc5.jpeg')}}" height="350px"
                       class="img-fluid " alt="zoom">
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Same Text About Image</p>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 mt-5">
                <div class="view overlay zoom">
                    <img src="{{url('GameImage/sc4.jpeg')}}" height="350px"
                       class="img-fluid " alt="zoom">
                    <div class="mask flex-center waves-effect waves-light">
                        <p style="color:#fff">Same Text About Image</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <hr/>
    <div class="container-fluid text-center">
        <footer>
            <div class="row">
                <div class="col-md-12" style=" color: #777;font-size: 15px">
                    <p>Copyright Â© 2021 Fun Games Asiaa. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- <div class="container-fluid mt-5">
        <footer class="page-footer font-small">
            <div class="footer-copyright text-center py-3">© {{date('Y')}} Copyright:
                <a href="http://fungameasiaa.com/" target="_blank"> FunGameAsiaa </a>
            </div>
        </footer>
    </div> -->

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.13.0/js/mdb.min.js">
    </script>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>

    <script>
        $(document).ready(function() {
            var user_error = false;
            var password_error = false;

            $('#show_password_error').hide();
            $('#show_user_error').hide();

            $('#user').keyup(function() {
                check_user_error();
            });
            $('#password').keyup(function() {
                check_password_error();
            });

            function check_user_error() {
                var user_data = $('#user').val();
                if (user_data == '') {
                    $('#show_user_error').show();
                    user_error = true;
                    $('#show_user_error').html('This Field Is Required');
                    $('#user').focus();
                } else {
                    $('#show_user_error').hide();
                }
            }

            function check_password_error() {
                var password_data = $('#password').val();
                if (password_data == '') {
                    $('#show_password_error').show();
                    password_error = true;
                    $('#show_password_error').html('This Field Is Required');
                    $('#password').focus();
                } else {
                    $('#show_password_error').hide();
                }
            }

            $('#sign').click(function() {
                user_error = false;
                password_error = false;

                check_password_error();
                check_user_error();

                if (user_error === false && password_error === false) {
                    return true;
                } else {
                    return false;
                }
            });

        });
    </script>
</body>

</html>

