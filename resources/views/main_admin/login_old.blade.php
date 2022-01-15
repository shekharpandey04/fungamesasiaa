<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>
    @include('admin.head.head')
    {{-- <!-- Bootstrap -->
    <link href="{{url('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet"> --}}
</head>
<style>
    #content form .submit,
    .login_content form input[type=submit] {

        margin-left: 0px;
    }

    .login {
background-color:#ff9fe0;

    }

    .btn-info {
        background-color: #0f0bea;
        border-color: #0f0bea;
    }

    .login_content {
        padding: 10px 0 0;
    }
</style>

<body class="login">
    <div>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <div class="text-center">
                    <img src="{{url('GameImage\admin.png')}}" height="250px" width="250px">
                </div>
                <section class="login_content">
                    <form action="{{url('LoginMainAdmin')}}" method="post" oncopy="return false" oncut="return false" onpaste="return false">
                        @csrf
                        <h1 style="color:white">MAIN ADMIN</h1>
                        <div class="row">
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" id="username" name="username" autocomplete="off" class="form-control" placeholder="Username" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="password" id="passsword" name="password" autocomplete="off" class="form-control" placeholder="Password" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="submit" class="btn btn-info submit" style="width:100%" name="btn_sub" value="Log In">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </section>
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
