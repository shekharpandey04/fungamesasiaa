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
        table.dataTable thead .sorting_desc_disabled:Fafter,
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
            @include('WebLogin.SideBar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="col-md-12">
                         <div class="x_panel">
                        <div align="right"><a href="{{url('/')}}" class="btn btn-danger"> Logout</a></div>
                        <div class="x_title">
                            <h2>Information About {{$user_id}} User</h2>
                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
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
                        <div class="x_panel scrollmenu">
                        <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>User Id</th>
                                    <th>Franchise Id / Distributor Id</th>
                                    <th>User Name</th>
                                    <th>Last Logged In</th>
                                    <th>Last Logged Out</th>
                                    <th>Is Blocked</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $log_data)
                                <tr>
                                    <td>{{$log_data->user_id}}</td>
                                    <td>{{$log_data->distributor_id }}</td>
                                    <td>{{$log_data->username }}</td>
                                    <td>{{$log_data->last_logged_in }}</td>
                                    <td>{{$log_data->last_logged_out }}</td>
                                    @if($log_data->IsBlocked == 0)
                                    <td><a class="btn btn-success">Active</a></td>
                                    @else
                                    <td><a class="btn btn-danger">Block</a></td>
                                    @endif
                                    <td>{{$log_data->created_at}}</td>
                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>User Id</th>
                                    <th>Franchise Id / Distributor Id</th>
                                    <th>User Name</th>
                                    <th>Last Logged In</th>
                                    <th>Last Logged Out</th>
                                    <th>Is Blocked</th>
                                    <th>Created At</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
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
    <script>
        $(document).ready(function() {
            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

</body>

</html>