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
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Casino Game Report</h2>
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
                                    <tr class="text-center">
                                        <th>Round Count</th>
                                        <th>User Id</th>
                                        <th>Game Name</th>
                                        <th>Win By Multiple</th>
                                        <th>Win Number</th>
                                        <th>Date And Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data12 == 1)
                                    @foreach ($round_data as $data)
                                    <tr class="text-center">
                                        <td>
                                            <p data-toggle="modal" data-target="#popup_table" id="show_history" onclick="show_data('{{$data->round_count}}','{{$data->player_id}}')" style="color:#ddff21;cursor:pointer;">{{$data->round_count }}</p>
                                        </td>
                                        <td>
                                            <p data-toggle="modal" data-target="#userpopup_table12" id="get_data_by_user" onclick="get_data_by_user('{{$data->player_id}}')" style="color:#ddff21;cursor:pointer;">{{$data->player_id}}</p>
                                        </td>
                                        <td>{{$data->game_name }}</td>
                                        
                                         @if(($data->win_no) == 100)
                                        <td>
                                            Pending <span style="height:8px;width:8px;background-color: red;border-radius: 50%;display: inline-block;"></span>
                                        </td>
                                        <td>
                                            Pending <span style="height:8px;width:8px;background-color: red;border-radius: 50%;display: inline-block;"></span>
                                        </td>
                                        @else
                                        <td>{{$data->win_X}}</td>
                                        <td>{{$data->win_no}}</td>
                                        @endif
                                        
                                        <td>{{$data->created_at}}</td>

                                        @endforeach
                                        @else
                                        <td colspan="6" class="text-center" style="background: lightgrey;color:#000;font-size:18px">Data Not Found</td>
                                        @endif
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Round Count</th>
                                        <th>User Id</th>
                                        <th>Game Name</th>
                                        <th>Win By Multiple</th>
                                        <th>Win Number</th>
                                        <th>Date And Time</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    {{-- PoPUp Table --}}
    <div class="modal fade" id="popup_table" role="dialog" style="margin-top:35px">
        <div class="col-md-2"></div>
        <div class=" col-md-8 col-xs-12 text-center">
            <div class="x_panel scrollmenu">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <table id="dtHorizontalExample" class="table table-bordered my-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>round_count</th>
                            <th>player id</th>
                            <th>win x</th>
                            <th>game name</th>
                            <th>win no</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>date and time</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>round_count</th>
                            <th>player id</th>
                            <th>win x</th>
                            <th>game name</th>
                            <th>win no</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>date and time</th>
                        </tr>
                    </tfoot>
                </table>
            </div> {{-- End Of x_panel --}}
        </div>
    </div>
    {{-- End Of PoPUp Table --}}

    {{-- PoPUp Table --}}
    <div class="modal fade" id="userpopup_table12" role="dialog" style="margin-top:35px">
        <div class="col-md-2"></div>
        <div class=" col-md-8 col-xs-12 text-center">
            <div class="x_panel scrollmenu">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <table id="dtHorizontalExample" class="table table-bordered " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>round_count</th>
                            <th>player id</th>
                            <th>win x</th>
                            <th>win no</th>
                            <!--<th>game name</th>-->
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>date and time</th>
                        </tr>
                    </thead>
                    <tbody id="my-table">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>round_count</th>
                            <th>player id</th>
                            <th>win x</th>
                            <!--<th>game name</th>-->
                            <th>win no</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>date and time</th>
                        </tr>
                    </tfoot>
                </table>
            </div> {{-- End Of x_panel --}}
        </div>
    </div>
    {{-- End Of PoPUp Table --}}


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
        $(document).ready(function() {
            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

    <script>
        function show_data(round_count, user_id) {
            //var url = window.location.origin + '/GetRoundData';
            var url = "{{url('/GetRoundData/')}}"
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    round_count: round_count,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);

                    var len = 0;
                    $('#popup_table').css('display', 'block');
                    $('.my-table tbody').empty();
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    for (var i = 0; i < len; i++) {
                        var round_count = response['data'][i].round_count;
                        var user_id = response['data'][i].player_id;
                        var win_x = response['data'][i].win_X;
                        var game_name = response['data'][i].game_name;
                        var win_no = response['data'][i].win_no;
                        var no_0 = response['data'][i].no_0;
                        var no_1 = response['data'][i].no_1;
                        var no_2 = response['data'][i].no_2;
                        var no_3 = response['data'][i].no_3;
                        var no_4 = response['data'][i].no_4;
                        var no_5 = response['data'][i].no_5;
                        var no_6 = response['data'][i].no_6;
                        var no_7 = response['data'][i].no_7;
                        var no_8 = response['data'][i].no_8;
                        var no_9 = response['data'][i].no_9;
                        var created_at = response['data'][i].created_at;

                        var tr_str = "<tr>" +
                            "<td align='center'>" + (i + 1) + "</td>" +
                            "<td align='center'>" + round_count + "</td>" +
                            "<td align='center'>" + user_id + "</td>" +
                            "<td align='center'><strong style='color:red'>" + win_x + "</strong></td>" +
                            "<td align='center'><strong style='color:red'>" + game_name + "</strong></td>" +
                            "<td align='center'><strong style='color:red'>" + win_no + "</strong></td>" +
                            "<td align='center'>" + no_0 + "</td>" +
                            "<td align='center'>" + no_1 + "</td>" +
                            "<td align='center'>" + no_2 + "</td>" +
                            "<td align='center'>" + no_3 + "</td>" +
                            "<td align='center'>" + no_4 + "</td>" +
                            "<td align='center'>" + no_5 + "</td>" +
                            "<td align='center'>" + no_6 + "</td>" +
                            "<td align='center'>" + no_7 + "</td>" +
                            "<td align='center'>" + no_8 + "</td>" +
                            "<td align='center'>" + no_9 + "</td>" +
                            "<td align='center'>" + created_at + "</td>" +
                            "</tr>";
                        $(".my-table tbody").append(tr_str);
                    }
                },
                error(data) {
                    console.log(data);
                }
            });
        }
    </script>

    <script>
        function get_data_by_user(user_id) {
            // var url = window.location.origin + '/GetDataByUserId';
            var url =  "{{url('/GetDataByUserId/')}}"
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);

                    var len = 0;
                    $('#userpopup_table12').css('display', 'block');
                    $('#my-table').empty();
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    for (var i = 0; i < len; i++) {
                        var round_count = response['data'][i].round_count;
                        var user_id = response['data'][i].player_id;
                        var win_x = response['data'][i].win_X;
                        var win_no = response['data'][i].win_no;
                        var no_0 = response['data'][i].no_0;
                        var no_1 = response['data'][i].no_1;
                        var no_2 = response['data'][i].no_2;
                        var no_3 = response['data'][i].no_3;
                        var no_4 = response['data'][i].no_4;
                        var no_5 = response['data'][i].no_5;
                        var no_6 = response['data'][i].no_6;
                        var no_7 = response['data'][i].no_7;
                        var no_8 = response['data'][i].no_8;
                        var no_9 = response['data'][i].no_9;
                        var created_at = response['data'][i].created_at;

                        var tr_str = "<tr>" +
                            "<td align='center'>" + (i + 1) + "</td>" +
                            "<td align='center'>" + round_count + "</td>" +
                            "<td align='center'>" + user_id + "</td>" +
                            "<td align='center'><strong style='color:red'>" + win_x + "</strong></td>" +
                            //    "<td align='center'><strong style='color:red'>" + game_name + "</strong></td>" +
                            "<td align='center'><strong style='color:red'>" + win_no + "</strong></td>" +
                            "<td align='center'>" + no_0 + "</td>" +
                            "<td align='center'>" + no_1 + "</td>" +
                            "<td align='center'>" + no_2 + "</td>" +
                            "<td align='center'>" + no_3 + "</td>" +
                            "<td align='center'>" + no_4 + "</td>" +
                            "<td align='center'>" + no_5 + "</td>" +
                            "<td align='center'>" + no_6 + "</td>" +
                            "<td align='center'>" + no_7 + "</td>" +
                            "<td align='center'>" + no_8 + "</td>" +
                            "<td align='center'>" + no_9 + "</td>" +
                            "<td align='center'>" + created_at + "</td>" +
                            "</tr>";
                        $("#my-table").append(tr_str);
                    }
                },
                error(data) {
                    console.log(data);
                }
            });
        }
    </script>

</body>

</html>