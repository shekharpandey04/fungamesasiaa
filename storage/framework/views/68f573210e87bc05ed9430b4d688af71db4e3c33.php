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
            <?php echo $__env->make('admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="x_title">
                                <h2>Add New Player</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="text-right">
                                    <a href="<?php echo e(url('/AddNewUser')); ?>" title="Add New Player" class="btn btn-primary">
                                        <i class="fa fa-user-plus"></i>
                                    </a>
                                </div>
                                <br />
                                <form action="<?php echo e(url('AddNewPlayer')); ?>" method="post"
                                    class="form-horizontal form-label-left">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distributor</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="dist_id" style="cursor: not-allowed;" name="dist_id"
                                                readonly value="<?php echo e($dist_id); ?>" class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Player Id</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="player_id" style="cursor: not-allowed;"
                                                name="player_id" value="<?php echo e($user_id); ?>" readonly
                                                class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">User Name</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="username" autocomplete="off" name="username"
                                                value="<?php echo e(old('username')); ?>" placeholder="Enter UserName"
                                                class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter Password</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="password" id="password" name="password" autocomplete="off"
                                                required placeholder="Enter Password" class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                            
                                            <input class="btn btn-success" type="submit" name="btn_sub" value="Submit"
                                                id="btn_sub">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="container x_panel">
                    <div class="row">
                        
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
                            <table id="dtHorizontalExample" class="table  table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Player Id</th>
                                        <th>UserName</th>
                                        <th>Last Logged In</th>
                                        <th>Last Logged Out</th>
                                        <th>Balance</th>
                                        <th>Franchise</th>
                                        <th>IsBlocked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $player_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($player_data->user_id); ?>

                                            <?php if($player_data->active == 1): ?>
                                            <span style="height:8px;width:8px;background-color: #33F508;border-radius: 50%;display: inline-block;"></span>
                                            <?php else: ?>
                                            <span style="height:8px;width:8px;background-color: #bbb;border-radius: 50%;display: inline-block;"></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if($player_data->username == NULL): ?>
                                        <td>--</td>
                                        <?php else: ?>
                                        <td><?php echo e($player_data->username); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($player_data->last_logged_in); ?></td>
                                        <td><?php echo e($player_data->last_logged_out); ?></td>
                                        <td><?php echo e($player_data->points); ?></td>
                                        <td><?php echo e($player_data->distributor_id); ?></td>
                                        <?php if($player_data->IsBlocked == 0): ?>
                                        <td><a href="<?php echo e(url('BlockUser/'.$player_data->user_id)); ?>" class="btn btn-success">Active</a></td>
                                        <?php else: ?>
                                        <td><a href="<?php echo e(url('UnBlockUser/'.$player_data->user_id)); ?>" class="btn btn-danger">Block</a></td>
                                        <?php endif; ?>
                                        <td>
                                            <select name="select_action" class="form-control col-md-12"
                                                id="select_action"
                                                onchange="location = this.options[this.selectedIndex].value;">
                                                <option selected disabled>Select Action</option>
                                                <option value="<?php echo e(url('edit_player/'.$player_data->user_id)); ?>">Update
                                                    User Info</option>
                                                <option value="<?php echo e(url('/SendPointToPlayer/'.$player_data->user_id)); ?>">Send Points</option>
                                                <option value="<?php echo e(url('/CutPointsOfPlayer/'.$player_data->user_id)); ?>">Receive Points</option>
                                                <option value="<?php echo e(url('/userlogout/'.$player_data->user_id)); ?>">Logout</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Player Id</th>
                                        <th>UserName</th>
                                        <th>Last Logged In</th>
                                        <th>Last Logged Out</th>
                                        <th>Balance</th>
                                        <th>Franchise</th>
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
        $(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
    </script>

</body>

</html><?php /**PATH /var/www/html/fungames_asiaa/resources/views/admin/pages/AddPlayer/AddPlayer.blade.php ENDPATH**/ ?>