<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .button-size input[type='radio'] {
            width: 2em;
            height: 2em;
        }

        .button-size label {
            font-size: 2em;
        }
    </style>

</head>

<body class="nav-md">


    @include('main_admin.sidebar.sidebar')

    <div class="container body">
        <div class="main_container">
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="animated flipInY" style="background-color:#f34b4b">
                                <div class="tile-stats" style="background-color:#45ae7d ">
                                    <div class="icon"><i class="fa fa-delicious"></i></div>
                                    <h1 class="ml-2" style="color: #fff">Round Number</h1>
                                    <div class="count" style="color: #fff">{{ Session::get('count') }}</div>
                                </div>
                            </div>
                            <div class="x_title">
                                <h2>Set Win Number And Win X</h2> <br>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
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
                                <form action="{{url('AddWinNo')}}" method="post" class="form-horizontal form-label-left">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group button-size">
                                                <input type="radio" id="no_0" name="win_no" value="no_0" required>
                                                <label for="no_0"> 0</label><br>
                                                <input type="radio" id="no_1" name="win_no" value="no_1" required>
                                                <label for="no_1"> 1</label><br>
                                                <input type="radio" id="no_2" name="win_no" value="no_2">
                                                <label for="no_2"> 2</label><br>
                                                <input type="radio" id="no_3" name="win_no" value="no_3">
                                                <label for="no_3"> 3</label><br>
                                                <input type="radio" id="no_4" name="win_no" value="no_4">
                                                <label for="no_4"> 4</label><br>
                                                <input type="radio" id="no_5" name="win_no" value="no_5">
                                                <label for="no_5"> 5</label><br>
                                                <input type="radio" id="no_6" name="win_no" value="no_6">
                                                <label for="no_6"> 6</label><br>
                                                <input type="radio" id="no_7" name="win_no" value="no_7">
                                                <label for="no_7"> 7</label><br>
                                                <input type="radio" id="no_8" name="win_no" value="no_8">
                                                <label for="no_8"> 8</label><br>
                                                <input type="radio" id="no_9" name="win_no" value="no_9">
                                                <label for="no_9"> 9</label><br>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group button-size">
                                                <input type="radio" id="1x" name="win_x" value="1x" required>
                                                <label for="1x"> 1x</label><br>
                                                <input type="radio" id="2x" name="win_x" value="2x">
                                                <label for="2x"> 2x</label><br>
                                                <input type="radio" id="4x" name="win_x" value="4x">
                                                <label for="4x"> 4x</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            {{-- <button type="reset" class="btn btn-primary">Reset</button> --}}
                                            {{-- <a  id="" name="">Submit</a> --}}
                                            <input class="btn btn-success" type="submit" name="btn_sub" value="Set Number And X" id="btn_sub">
                                            <!-- <a href="{{url('ResetWinNumber')}}" class="btn btn-danger">Reset Win Number</a> -->
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="x_content">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                </div>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('admin.script.datatable')
    @include('admin.script.script')
    <script>
        $(document).ready(function() {
            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
    <script>
        function Active(a) {
            var url = window.location.origin + '/Active/' + a;
            window.location.replace(url);
        }

        function DeActive(a) {
            var url = window.location.origin + '/DeActive/' + a;
            window.location.replace(url);
        }
    </script>
</body>

</html>