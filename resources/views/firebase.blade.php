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
        background-color: #fff;
        background-size: cover;
        font-family: 'Poppins', sans-serif;;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <center>
                    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                </center>
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{url('send_notification') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea class="form-control" name="body"></textarea>
                              </div>
                            <button type="submit" class="btn btn-primary">Send Notification</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>

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
                    console.log(token);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ url("save_token") }}',
                        type: 'POST',
                        data: {
                            "device_token": token,
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('An error occurred while save token'+ err);
                        },
                    });

                }).catch(function (err) {
                    console.log('An error occurred while retrieving token.'+ err);
                });
        }

        messaging.onMessage(function(payload) {

            //console.log(payload);
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
</body>
</html>

