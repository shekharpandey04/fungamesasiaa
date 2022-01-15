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
                                <h2>Send Points to Distributor</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="text-right">
                                    <a href="{{url('/AddNewDistributor')}}" title="Add New Player" class="btn btn-primary">
                                        <i class="fa fa-user-plus"></i>
                                    </a>
                                </div>
                                <br />
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
                                <form method="post" action="{{url('/AddDistPoints')}}"
                                            class="form-horizontal form-label-left" oncopy="return false"
                                            oncut="return false" onpaste="return false">
                                            @csrf
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter Distributor
                                                    Id</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="text" id="dist_id" name="dist_id" autocomplete="off"
                                                        placeholder="Enter Distributor Id" maxlength="13" class="form-control col-md-10"
                                                        required style="text-transform: uppercase"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Add
                                                    Points</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="number" min="1" id="points" name="points" autocomplete="off"
                                                        placeholder="How Many Point Transfer" required
                                                        class="form-control col-md-10" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter
                                                    Pin</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="password" id="pin" name="pin" required autocomplete="off"
                                                        placeholder="Enter PIN" class="form-control col-md-10" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                                    <button type="reset" class="btn btn-primary">Reset</button>
                                                    <input type="submit" class="btn btn-success" id="btn_sub"
                                                        name="btn_sub" value="Submit">
                                                </div>
                                            </div>
                                        </form>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}
                        <div class="col-md-12 col-xs-12">
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Transfered To / Distributor Id</th>
                                        <th>Point</th>
                                        <th>Transferred On / Date Time</th>
                                        <th>Franchise</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data != 0)
                                    @foreach ($PointData as $history_point)
                                    <tr>
                                        <td>{{$history_point->distributor_id }}</td>
                                        <td>{{$history_point->points}}</td>
                                        <td>{{$history_point->created_at}}</td>
                                        <td><strong>Admin</strong></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right"><strong>Total Points</strong></td>
                                        <td><strong>{{$total_points}}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center"
                                            style="background: lightgrey;color:#000;font-size:18px">Data Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Transfered To</th>
                                        <th>Point</th>
                                        <th>Transferred On</th>
                                        <th>Franchise</th>
                                    </tr>
                                </tfoot>
                            </table>
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
        $(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
    </script>

</body>

</html>
