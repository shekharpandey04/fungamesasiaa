<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>
   
    {{--
    <!-- Bootstrap -->
    <link href="{{url('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" >
</head>
<style>
    .navbar-dark {
        background-color: black !important;
    }

    @media (max-width: 576px) {
        .navbar-dark .navbar-toggler {
            font-size: 1em;
        }

        .navbar-brand {
            font-size: 1em;
        }
    }
</style>

<body class="bg-light">

    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container-fluid d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex">
                    <div class="text-primary">FUNGAMESASIAA</div>&nbsp;BACK OFFLICE
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="container-fluid d-flex w-100">
                <a href="" class="btn btn-warning text-light ml-auto mr-0 mt-1">Contact Us</a>
            </div>
        </div>
    </header>
    <div class="container">

        <div class="login_wrapper">
            <div class="form login_form">
                <section class="login_content p-3 bg-white">
                    <form action="{{url('login')}}" method="post" oncopy="return false" oncut="return false"
                        onpaste="return false">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h5
                                    style="border-bottom: 1px solid lightgrey; padding: 1rem 0 1rem 0;  color: rgb(107, 107, 107);">
                                    Log In</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="flash-message">
                                @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-success') }}"
                                    style="font-size: 17px">
                                    {{ Session::get('message') }}</p>
                                {{ Session::forget('message') }}
                                @endif
                                @if(Session::has('error'))
                                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}"
                                    style="font-size: 17px">
                                    {{ Session::get('error') }}</p>
                                {{ Session::forget('error') }}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" id="username" name="username" autocomplete="off" class="form-control"
                                    placeholder="Username Ex.DIS000000000" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="password" id="passsword" name="password" autocomplete="off"
                                    class="form-control" placeholder="Password" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="submit" class="btn btn-primary submit" name="btn_sub" value="Log In">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script>
        document.onkeydown = function (e) {
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