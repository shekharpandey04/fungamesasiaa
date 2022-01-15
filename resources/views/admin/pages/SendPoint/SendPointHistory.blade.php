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
            @include('admin.sidebar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Sort Transfer Report Data Using Follwing Option</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12 col-xs-12">
                                    <a href="{{url('/UserPointreport')}}" title="Add New Player"
                                        class="btn btn-primary">
                                        <i class="fa fa-calendar"></i>
                                        Show All
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'today')}}" title="Add New Player"
                                        class="btn btn-primary">
                                        <i class="fa fa-calendar"></i>
                                        Today
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'yesterday')}}" title="Add New Player"
                                        class="btn btn-info">
                                        <i class="fa fa-calendar"></i>
                                        Yesterday
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'this_week')}}" title="Add New Player"
                                        class="btn btn-success">
                                        <i class="fa fa-calendar"></i>
                                        This Week
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'last_week')}}" title="Add New Player"
                                        class="btn btn-warning">
                                        <i class="fa fa-calendar"></i>
                                        Last Week
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'this_month')}}" title="Add New Player"
                                        class="btn btn-danger">
                                        <i class="fa fa-calendar"></i>
                                        This Month
                                    </a>
                                    <a href="{{url('/SortUserPointHistory/'.'last_month')}}" title="Add New Player"
                                        class="btn btn-dark">
                                        <i class="fa fa-calendar"></i>
                                        Last Month
                                    </a>
                                </div>
                                <div class="col-md-6" style="margin-top: 25px;">
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
                                    <form method="post" action="{{url('/CustomUserPointHistory')}}"
                                        class="form-horizontal form-label-left" oncopy="return false"
                                        oncut="return false" onpaste="return false">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Start
                                                Date</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="date" id="StartDate" name="StartDate" autocomplete="off"
                                                     class="form-control col-md-10"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select End
                                                Date</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="date" id="EndDate" name="EndDate" autocomplete="off"
                                                    class="form-control col-md-10"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                                <button type="reset" class="btn btn-primary">Reset</button>
                                                <input type="submit" class="btn btn-success" id="btn_sub" name="btn_sub"
                                                    value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br />


                            </div>
                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}
                        <div class="col-md-12 col-xs-12">
                            {{-- <p class="alert alert-success text-center"><strong>{{$day}}</strong></p> --}}
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Transfered To / User Id</th>
                                        <th>Point</th>
                                        <th>Transferred On / Date Time</th>
                                        <th>Franchise</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data != 0)
                                    @foreach ($PointData as $history_point)
                                    <tr>
                                        <td>
                                            <p data-toggle="modal" data-target="#popup_table" id="show_history"
                                                onclick="show_history('{{$history_point->user_main_id}}')"
                                                style="color:#ddff21;cursor: pointer;">{{$history_point->user_id}}</p>
                                        </td>
                                        <td>{{$history_point->points}}</td>
                                        <td>{{$history_point->created_at}}</td>
                                        <td>{{$history_point->distributor_id}}</td>
                                    </tr>
                                    @endforeach
                                    {{-- <tr>
                                        <td class="text-right"><strong>Total Points</strong></td>
                                        <td><strong>{{$point_sum}}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr> --}}
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
                </div> {{-- End Of x_panel --}}
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

// $('.datepicker').datepicker({
//     startDate: '-3d'
// });

$(document).ready(function(){
    $('#UserPointHistory').click(function(){
        // alert("okkk");
        console.log("okkk");

    });
});
    </script>

    <script>
        function show_history(user_id){
            var url = window.location.origin+'/GetHistoryByUserId/'+user_id;
            var url = "{{url('/')}}"+'/GetHistoryByUserId/'+user_id;
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success:function(response){
                var len = 0;
                $('#popup_table').css('display','block');
                $('.my-table tbody').empty();
                if(response['data'] != null){
                    len = response['data'].length;
                }
                for(var i=0; i<len; i++){
                    var user_main_id = response['data'][i].user_main_id;
                    var user_id = response['data'][i].user_id;
                    var points = response['data'][i].points;
                    var created_at = response['data'][i].created_at;
                    var distributor_id  = response['data'][i].distributor_id ;
                    var tr_str = "<tr>" +
                        "<td align='center'>" + (i+1) + "</td>" +
                   "<td align='center'>" + user_id + "</td>" +
                   "<td align='center'>" + points + "</td>" +
                   "<td align='center'>" + created_at + "</td>" +
                   "<td align='center'>" + distributor_id + "</td>" +
                   "</tr>";
                   $(".my-table tbody").append(tr_str);
                   console.log(tr_str);

                }
            var tr_sum = "<tr>"+
                            "<td colspan='2'><strong>Total Points</strong></td>"+
                            "<td><strong>"+response['sum_points']+"</strong></td>"+
                            "<td colspan='2'></td>"+
                            "</tr>";
                            $(".my-table tbody").append(tr_sum);
            },error(data){
                // console.log(data);
            }
        });
	}
    </script>

</body>

</html>
