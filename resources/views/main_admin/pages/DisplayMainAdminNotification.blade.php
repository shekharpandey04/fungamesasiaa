<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        #popup_table {
            display: none;
        }

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

        div.scrollmenu {

            overflow: auto;
            white-space: nowrap;
        }
    </style>

</head>

<body class="nav-md">



    <div class="container body">
        <div class="main_container">
            @include('main_admin.sidebar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>
                                    Distributor Return Points</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <div class="col-md-6" style="margin-top: 25px;">
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

                                </div>
                                <br />


                            </div>
                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}
                        <div class="col-md-2"></div>
                        <div class="col-md-5 col-xs-12">
                            {{-- <p class="alert alert-success text-center"><strong>{{$day}}</strong></p> --}}
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">

                                <tbody>
                                    @if($data != 0)
                                    @foreach ($notify_data as $history_point)
                                    <tr>
                                        <td>Notification</td>
                                        @if(($history_point->status)==0)
                                        <td>{{$history_point->distributor_id}} Return {{$history_point->points}} Points To You</td>
                                        @elseif(($history_point->status)==1)
                                        <td>You Send {{$history_point->points}} Points To {{$history_point->distributor_id}}</td>
                                        @elseif(($history_point->status)==2)
                                        <td>{{$history_point->distributor_id}} Accepted Your {{$history_point->points}} Points</td>
                                        @elseif(($history_point->status)==3)
                                        <td>{{$history_point->distributor_id}} Rejected Your {{$history_point->points}} Points</td>
                                        @elseif(($history_point->status)==4)
                                        <td>{{$history_point->distributor_id}} logged into device</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>At</td>
                                        <td>{{$history_point->created_at}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" align="center"><a href="{{url('main_dashboard')}}" class="btn btn-danger">Go Back</a></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center" style="background: lightgrey;color:#000;font-size:18px">Data Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div> {{-- End Of x_panel --}}
            </div>
        </div>
    </div>





    <!-- jQuery -->
    <script src="{{url('vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{url('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{url('vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{url('vendors/nprogress/nprogress.js')}}"></script>
    <!-- iCheck -->
    <script src="{{url('vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{url('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{url('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{url('vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{url('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{url('vendors/pdfmake/build/vfs_fonts.js')}}"></script>

    <!-- Switchery -->
    <script src="{{url('vendors/switchery/dist/switchery.min.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{url('build/js/custom.min.js')}}"></script>


</body>

</html>