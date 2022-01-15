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

        .sec-shade {
            position: absolute;
            display: block;
            padding: 5px 10px;
            border: 1px solid #870602;
            overflow: hidden;
            background-clip: padding-box;
            border-radius: 15px;
            background: linear-gradient(180deg, #f71918, #870602);
            transition: all .3s ease-in-out;
            box-shadow: 5px 5px 5px #0008;
            font-size: 24px;
            top:14px;
            right:55px;
        }

        @media (max-width: 480px) {
            .sec-shade {
                position: initial;
                width: 100px;
            }
        }

    </style>

</head>

<body class="nav-md">



    <div class="container body">
        <div class="main_container">
            <?php echo $__env->make('main_admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Show Current Bet Of Game</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12 col-xs-12">
                                    <a data-toggle="modal" class="btn btn-primary" data-target="#popup_table" id="show_history1" onclick="show_Bet_history()" style="cursor: pointer;"><i class="fa fa-calendar"></i> Show All History</a>
                                    <!--<a href="<?php echo e(url('SetWinNo')); ?>" class="btn btn-info">Set Win No</a>-->
                                </div>

                                <div class="col-md-6" style="margin-top: 25px;">
                                    <div class="flash-message">
                                        <?php if(Session::has('message')): ?>
                                        <p class="alert <?php echo e(Session::get('alert-class', 'alert-success')); ?>" style="font-size: 17px">
                                            <?php echo e(Session::get('message')); ?></p>
                                        <?php echo e(Session::forget('message')); ?>

                                        <?php endif; ?>
                                        <?php if(Session::has('error')): ?>
                                        <p class="alert <?php echo e(Session::get('alert-class', 'alert-danger')); ?>" style="font-size: 17px">
                                            <?php echo e(Session::get('error')); ?></p>
                                        <?php echo e(Session::forget('error')); ?>

                                        <?php endif; ?>
                                    </div>

                                </div>
                                <br />


                            </div>
                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        
                        <div class="col-md-12 col-xs-12">
                            
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Round Count</th>
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
                                        <th>Created At</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($data != 0): ?>
                                    <?php $__currentLoopData = $bet_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="text-center">
                                        <td><?php echo e($history_point->round_count); ?></td>
                                        <?php if($history_point->no_0 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_0); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_1 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_1); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_2 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_2); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_3 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_3); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_4 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_4); ?></td>
                                        <?php endif; ?>
                                        <?php if($history_point->no_5 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_5); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_6 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_6); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_7 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_7); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_8 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_8); ?></td>
                                        <?php endif; ?>

                                        <?php if($history_point->no_9 == null): ?>
                                        <td>0</td>
                                        <?php else: ?>
                                        <td><?php echo e($history_point->no_9); ?></td>
                                        <?php endif; ?>

                                        <td><?php echo e($history_point->created_at); ?></td>
                                        
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center" style="background: lightgrey;color:#000;font-size:18px">Data Not Found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Round Count</th>
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
                                        <th>Created At</th>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="animated flipInY">
                                <div class="tile-stats">
                                    <!-- <div class="icon"><i class="fa fa-delicious"></i></div> -->
                                    <!--  <div class="icon" id="sec" style="color: #fff;font-size: 24px;top:14px;"></div> --> 
                                    <?php $__currentLoopData = $bet_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <h1 class="ml-2" style="color: #fff">Round Number</h1>
                                    <div class="sec-shade" id="sec">--:--</div>
                                    <h2  style="color: #fff"><?php echo e($history_point->round_count); ?></h2>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="x_title">
                                <h2>Set Win Number And Win X</h2> <br>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <div class="flash-message">
                                    <?php if(Session::has('message')): ?>
                                    <p class="alert <?php echo e(Session::get('alert-class', 'alert-success')); ?>" style="font-size: 17px">
                                        <?php echo e(Session::get('message')); ?></p>
                                    <?php echo e(Session::forget('message')); ?>

                                    <?php endif; ?>
                                    <?php if(Session::has('error')): ?>
                                    <p class="alert <?php echo e(Session::get('alert-class', 'alert-danger')); ?>" style="font-size: 17px">
                                        <?php echo e(Session::get('error')); ?></p>
                                    <?php echo e(Session::forget('error')); ?>

                                    <?php endif; ?>
                                </div>
                                <form action="<?php echo e(url('AddWinNo')); ?>" method="post" class="form-horizontal form-label-left">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9">
                                            <div class="form-group button-size">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
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
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <div class="form-group button-size">
                                                <input type="radio" id="2x" name="win_x" value="2x">
                                                <label for="2x"> 2x</label><br>
                                                <input type="radio" id="4x" name="win_x" value="4x">
                                                <label for="4x"> 4x</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            
                                            
                                            <input class="btn btn-success" type="submit" name="btn_sub" value="Set Number And X" id="btn_sub">
                                            <a href="<?php echo e(url('SetMaxWinX')); ?>" class="btn btn-success">Set Win X Count</a>
                                            <!-- <a href="<?php echo e(url('ResetWinNumber')); ?>" class="btn btn-danger">Reset Win Number</a> -->
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



    <div class="modal fade" id="popup_table" role="dialog" style="margin-top:35px">
        <div class="col-md-2"></div>
        <div class=" col-md-8 col-xs-12 text-center">
            <div class="x_panel scrollmenu">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <table id="dtHorizontalExample" class="table table-bordered my-table" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th>Round Count</th>
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
                            <th>Created At</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>Round Count</th>
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
                            <th>Created At</th>
                            
                        </tr>
                    </tfoot>
                </table>
            </div> 
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo e(url('vendors/jquery/dist/jquery.min.js')); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo e(url('vendors/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo e(url('vendors/fastclick/lib/fastclick.js')); ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo e(url('vendors/nprogress/nprogress.js')); ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo e(url('vendors/iCheck/icheck.min.js')); ?>"></script>
    <!-- Datatables -->
    <script src="<?php echo e(url('vendors/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-buttons/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/jszip/dist/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/pdfmake/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(url('vendors/pdfmake/build/vfs_fonts.js')); ?>"></script>

    <!-- Switchery -->
    <script src="<?php echo e(url('vendors/switchery/dist/switchery.min.js')); ?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo e(url('build/js/custom.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });

    </script>


    <script type="text/javascript">

        let startTimer=setInterval("getGameTimer();",1000);

        function  getGameTimer(){
            let gameID = 3;
            var base_url = '<?php echo e(url('/')); ?>';
            var url = base_url+'/GamePlayTimer/'+gameID;
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(res) {
                    let timer = res;
                    if(timer<10){
                        timer = '0'+timer
                    }
                    document.getElementById('sec').innerHTML='00:'+timer;
                },
                error: function(data,msg,errorThrown){
                    clearInterval(startTimer);
                }
            });
        }
    
        // function  getGameTimer(){
        //     let playUrl = "<?php echo Config('constants.FUN_GAME_URL') ?>";
        //     let EndPoint = "/getTimer";
        //     let url = playUrl + EndPoint;
        //     $.ajax({
        //         url:url,
        //         type: 'POST',
        //         headers: {
        //             "content-type": "application/json",
        //         },
        //         data: JSON.stringify({"game_id":3}),
        //         success: function(res) {
        //             let timer = res.timer;
        //             if(timer<10){
        //                 timer = '0'+timer
        //             }

        //             document.getElementById('sec').innerHTML='00:'+timer;
        //         },
        //         error: function(data,msg,errorThrown){
        //             clearInterval(startTimer);
        //         }
        //     });
        // }
    </script>


    <script>
        function show_Bet_history() {
            //var url = window.location.origin + '/GetAllBetData';
            var url = "<?php echo e(url('GetAllBetData')); ?>";
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    var len = 0;
                    $('#popup_table').css('display', 'block');
                    $('.my-table tbody').empty();
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    for (var i = 0; i < len; i++) {
                        var no_0, no_1, no_2, no_3, no_4, no_5, no_6, no_7, no_8, no_9;
                        var round_count = response['data'][i].round_count;
                        if (response['data'][i].no_0 == null) {
                            no_0 = 0;
                        } else {
                            no_0 = response['data'][i].no_0;
                        }

                        if (response['data'][i].no_1 == null) {
                            no_1 = 0;
                        } else {
                            no_1 = response['data'][i].no_1;
                        }
                        if (response['data'][i].no_2 == null) {
                            no_2 = 0;
                        } else {
                            no_2 = response['data'][i].no_2;
                        }
                        if (response['data'][i].no_3 == null) {
                            no_3 = 0;
                        } else {
                            no_3 = response['data'][i].no_3;
                        }
                        if (response['data'][i].no_4 == null) {
                            no_4 = 0;
                        } else {
                            no_4 = response['data'][i].no_4;
                        }
                        if (response['data'][i].no_5 == null) {
                            no_5 = 0;
                        } else {
                            no_5 = response['data'][i].no_5;
                        }
                        if (response['data'][i].no_6 == null) {
                            no_6 = 0;
                        } else {
                            no_6 = response['data'][i].no_6;
                        }
                        if (response['data'][i].no_7 == null) {
                            no_7 = 0;
                        } else {
                            no_7 = response['data'][i].no_7;
                        }
                        if (response['data'][i].no_8 == null) {
                            no_8 = 0;
                        } else {
                            no_8 = response['data'][i].no_8;
                        }
                        if (response['data'][i].no_9 == null) {
                            no_9 = 0;
                        } else {
                            no_9 = response['data'][i].no_9;
                        }
                        var created_at = response['data'][i].created_at;

                        var tr_str = "<tr>" +
                            "<td align='center'>" + round_count + "</td>" +
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
                            //    "<td align='center'>Admin</td>" +
                            "</tr>";
                        $(".my-table tbody").append(tr_str);
                    }
                    // var tr_sum = "<tr>"+
                    //                 "<td colspan='2'><strong>Total Points</strong></td>"+
                    //                 "<td><strong>"+response['sum_points']+"</strong></td>"+
                    //                 "<td colspan='2'></td>"+
                    //                 "</tr>";
                    //                 $(".my-table tbody").append(tr_sum);
                },
                error(data) {
                    console.log(data);
                }
            });
        }
    </script>

</body>

</html>
<?php /**PATH /var/www/html/fungames_asiaa/resources/views/main_admin/pages/Setting/ShowCurrentBet.blade.php ENDPATH**/ ?>