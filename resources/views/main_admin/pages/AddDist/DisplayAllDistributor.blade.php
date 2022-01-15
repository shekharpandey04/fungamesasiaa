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



    <div class="container body">
        <div class="main_container">
            @include('main_admin.sidebar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Distributor List</h2>
                                <div class="clearfix"></div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}
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
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Distributor Id</th>
                                        <th>UserName</th>
                                        <th>Pin</th>
                                        <th>Percentage</th>
                                        <th>LastLoggedIn</th>
                                        <th>LastLoggedOut</th>
                                        <th>IsBlocked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data != 0)
                                    @foreach ($dist_list as $player_data)
                                    <tr>
                                        <td>{{$player_data->distributor_id }}
                                            @if($player_data->active == 1)
                                            <span style="height:8px;width:8px;background-color: #33F508;border-radius: 50%;display: inline-block;"></span>
                                            @else
                                            <span style="height:8px;width:8px;background-color: #bbb;border-radius: 50%;display: inline-block;"></span>
                                            @endif
                                        </td>
                                        @if($player_data->username == NULL)
                                        <td>--</td>
                                        @else
                                        <td>{{$player_data->username}}</td>
                                        @endif
                                        <td>{{$player_data->pin}}</td>
                                        <td>{{$player_data->percentage}}</td>
                                        <td>{{$player_data->LastLoggedIn}}</td>
                                        <td>{{$player_data->LastLoggedOut}}</td>
                                        @if($player_data->IsBlocked == 0)
                                        <td><a href="{{url('BlockDist/'.$player_data->distributor_id)}}" class="btn btn-success">Active</a></td>
                                        @else
                                        <td><a href="{{url('UnBlockDist/'.$player_data->distributor_id)}}" class="btn btn-danger">Block</a></td>
                                        @endif
                                        <td>
                                            <select name="select_action" class="form-control col-md-12"
                                                id="select_action"
                                                onchange="location = this.options[this.selectedIndex].value;">
                                                <option selected disabled>Select Action</option>
                                                <option value="{{url('edit_distributor/'.$player_data->distributor_id)}}">Update
                                                    User Info</option>
                                                <option value="{{url('DistributorSendPoint')}}">Send Points</option>
                                                {{-- <option value="{{url('Distlogout/'.$player_data->distributor_id)}}">Logout</option> --}}
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td colspan="9">Data Not Found</td>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Distributor Id</th>
                                        <th>UserName</th>
                                        <th>Pin</th>
                                        <th>Percentage</th>
                                        <th>LastLoggedIn</th>
                                        <th>LastLoggedOut</th>
                                        <th>IsBlocked</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('admin.script.script') --}}
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
        $(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
    </script>

</body>

</html>
