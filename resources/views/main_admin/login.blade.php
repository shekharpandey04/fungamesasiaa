<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    body {
        background-color: #000;
        background: url('GameImage/login_bg.png') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;;
    }
    .login-row {
        position: absolute;
        top: 50vh;
        left: 50vw;
        transform: translate(-50%, -50%);
        width: 80vw;
    }
    .img-admin {
        max-width: 200px;
        height: auto;
        animation: rotate-chip 3s linear infinite;
    }
    .alert-login{
        font-size: 0.9em;
        color:#fff;
        background-color:#9e2515;
        margin-bottom:0px;
        border-color: #fb6704;
        margin-top:2px
    }
    @keyframes rotate-chip {
        0% {transform: rotateY(0);}
        100% {transform: rotateY(360deg);}
    }

    .login-msg-col h1 {
        font-size: 2.5em;
        font-weight: 700;
        color: #e18c34;
        text-shadow: 3px 3px 3px #000;
    }
    .login-input-col input {
        margin: 2rem auto;
        font-size: 1.5em;
        padding: .5em 1.5em;
        width: 60%;
        border: 4px solid #fb6704;
        background-color: #9d1604;
        border-radius: 10rem;
        box-shadow: 5px 5px 5px #000;
    }
    .login-input-col input:focus {
        border-color: #661505;
        background-color: #fb6704;
    }
    .login-input-col input[placeholder] {
        color: #fdcbb8;
    }

    .login-input-col input[type="submit"] {
        text-align: center;
        margin: 2.2rem auto;
        font-size: 1.7em;
        color: #fff;
        padding: .5em 3.5em;
        width: auto;
        border: none;
        background: linear-gradient(to right, #fb6704, #661505);
        border-radius: 10rem;
    }
    .login-input-col input[type="submit"]:hover {
        background: linear-gradient(to right, #661506, #fb6704);
    }
    @media (orientation: portrait) {
        body {
            background: url('GameImage/login_bg_portrait.png') no-repeat center center fixed;
            background-size: cover;
        }
        .login-input-col {
            text-align: center;
        }
        .login-input-col input {
            margin: 2rem auto;
            font-size: 1.1em;
            padding: .5em 1em;
            width: 75%;
            border: 3px solid #fb6704;
            background-color: #9d1604;
            border-radius: 10rem;
            box-shadow: 5px 5px 5px #000;
        }
        .login-input-col input[type="submit"] {
            font-size: 1.2em;
            color: #fff;
            padding: .5em 2.5em;
            width: auto;
            border: none;
            border-radius: 10rem;
        }
    }
</style>

<body>
    <div class="login_wrapper">
        <div class="login_form">
            <section class="login_content">
                <form action="{{url('LoginMainAdmin')}}" method="post" oncopy="return false" oncut="return false"
                    onpaste="return false">
                    @csrf
                    <div class="row login-row">
                        <div class="col-sm-6 col-6 login-msg-col text-center">
                            <img src="{{url('GameImage\chip.png')}}" class="img-admin">
                            <h1>Admin</h1>
                                
                        </div>

                        <div class="col-sm-6 col-6 login-input-col">
                            <div class="flash-message col-sm-7 col-7 ">
                                @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-login') }}"
                                    >
                                    {{ Session::get('message') }}</p>
                                {{ Session::forget('message') }}
                                @endif
                                @if(Session::has('error'))
                                <p class="alert {{ Session::get('alert-class', 'alert-login') }}"
                                    >
                                    {{ Session::get('error') }}</p>
                                {{ Session::forget('error') }}
                                @endif
                            </div>
                            <input type="text" id="username" name="username" autocomplete="off" placeholder="Username"
                                required/><br>
                            <input type="password" id="passsword" name="password" autocomplete="off"
                                placeholder="Password" value="" required/><br>
                            <input type="submit" class="btn text-center" name="btn_sub" value="Log In">
                        </div>
                    </div>
                </form>
            </section>
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