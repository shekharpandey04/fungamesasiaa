
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
            @include('admin.sidebar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Business Report</h2>
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
                                        <th>Franchise</th>
                                        <th>Total Points</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($data == 1)
                                    <tr>
                                        <td>
                                            <p data-toggle="modal" data-target="#popup_table" id="show_history"
                                                onclick="total_history('{{Session::get('user')}}')"
                                                style="cursor: pointer;">{{Session::get('user')}}</p></td>
                                        <td>{{$sum }}</td>
                                    </tr>
                                    @else
                                    <td colspan="2" class="text-center"
                                            style="background: lightgrey;color:#000;font-size:18px">Data Not Found</td>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Franchise</th>
                                        <th>Total Points</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="popup_table" role="dialog" style="margin-top:35px">
        <div class="col-md-2"></div>
        <div class=" col-md-8 col-xs-12 text-center">
            <div class="x_panel scrollmenu">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <table id="dtHorizontalExample" class="table table-bordered my-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Transfered To / User Id</th>
                            <th>Point</th>
                            <th>Transferred On / Date Time</th>
                            <th>Franchise</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>Sr.No</th>
                            <th>Transfered To / User Id</th>
                            <th>Point</th>
                            <th>Transferred On / Date Time</th>
                            <th>Franchise</th>
                        </tr>
                    </tfoot>
                </table>
            </div> {{-- End Of x_panel --}}
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








