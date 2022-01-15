<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .dtHorizontalExampleWrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        #dtHorizontalExample th,
        td {
            white-space: nowrap;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
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
                        <div class="col-md-12 col-xs-12">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="x_title">
                                <h2>Update Player Info</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12" style="margin-bottom: 15px;">

                                    <a href="{{url('/AddNewDistributor')}}" title="Add New Player" class="btn btn-primary">
                                        <i class="fa fa-user-plus"></i>Add New User
                                    </a>
                                    <a href="{{url('/edit_distributor/'.$dist_id)}}" title="Update Player" class="btn btn-warning">
                                        <i class="fa-7x fa fa-edit "></i>Update Player
                                    </a>
                                    <a href="{{url('/BlockDist/'.$dist_id)}}" title="Ban Player" class="btn btn-info">
                                        <i class="fa-7x fa fa-ban"></i>Block Player
                                    </a>
                                    <a href="{{url('/ChangeDistPassword/'.$dist_id)}}" title="Change Password" class="btn btn-success">
                                        <i class="fa fa-lock"></i>Change Password
                                    </a>
                                    <a href="{{url('/DistributorSendPoint')}}" title="Transfer Point" class="btn btn-danger">
                                        <i class="fa fa-exchange"></i>Transfer Points
                                    </a>
                                </div>
                                <br />

                                <form action="{{url('UpdateDistPassword/'.$dist_id)}}" method="post"
                                    class="form-horizontal form-label-left">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distributor</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="dist_id" style="cursor: not-allowed;" name="dist_id"
                                                readonly value="{{$dist_id}}"
                                                class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter New Password</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="password" autocomplete="off" name="password"
                                                value="{{old('password')}}" placeholder="Enter New Password"
                                                class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="con_pass" autocomplete="off" name="con_pass"
                                                value="{{old('con_pass')}}" placeholder="Enter Confirm Password"
                                                class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                            {{-- <a  id="" name="">Submit</a> --}}
                                            <input class="btn btn-success" type="submit" name="btn_sub" value="Update"
                                                id="btn_sub">
                                        </div>
                                    </div>
                                </form>


                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    @include('admin.script.datatable')
    <script>
        $(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
    </script>

</body>

</html>
