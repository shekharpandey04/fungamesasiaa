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


    <?php echo $__env->make('admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container body">
        <div class="main_container">
            <div class="right_col" role="main" style="min-height:800px !important;">
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

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="x_title">
                                <h2>Transfer Points</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                    <?php $__currentLoopData = $user_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(url('/AddNewUser')); ?>" title="Add New Player" class="btn btn-primary">
                                        <i class="fa fa-user-plus"></i>Add New User
                                    </a>
                                    <a href="<?php echo e(url('/edit_player/'.$player_data->user_id)); ?>" title="Update Player" class="btn btn-warning">
                                        <i class="fa-7x fa fa-edit "></i>Update Player
                                    </a>
                                    <a href="<?php echo e(url('/BlockUser/'.$player_data->user_id)); ?>" title="Ban Player" class="btn btn-info">
                                        <i class="fa-7x fa fa-ban"></i>Block Player
                                    </a>
                                    <a href="<?php echo e(url('/ChangePassword/'.$player_data->user_id)); ?>" title="Change Password" class="btn btn-success">
                                        <i class="fa fa-lock"></i>Change Password
                                    </a>
                                    <a href="<?php echo e(url('/SendPointToPlayer/'.$player_data->user_id)); ?>" title="Transfer Point" class="btn btn-danger">
                                        <i class="fa fa-exchange"></i>Transfer Points
                                    </a>
                                    <a href="<?php echo e(url('/CutPointsOfPlayer/'.$player_data->user_id)); ?>" title="Transfer Point" class="btn btn-warning">
                                        <i class="fa fa-exchange"></i>Receive Points
                                    </a>
                                </div>
                                <br/>

                                <form method="post" action="<?php echo e(url('/AddUserPoints')); ?>" class="form-horizontal form-label-left" oncopy="return false" oncut="return false" onpaste="return false">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distributor</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="dist_id" style="cursor: not-allowed;" name="dist_id" readonly value="<?php echo e($player_data->distributor_id); ?>" class="form-control col-md-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter Id</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="user_id" style="text-transform:uppercase;" name="user_id" readonly value="<?php echo e($player_data->user_id); ?>" autocomplete="off" placeholder="Enter User Id" class="form-control col-md-10" maxlength="13" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Add Points</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="number" id="points" name="points" autocomplete="off" class="form-control col-md-10" placeholder="Enter Transfer Point" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter Pin</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="password" id="pin" name="pin" required autocomplete="off" placeholder="Enter PIN" class="form-control col-md-10" />
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                            <input type="submit" class="btn btn-success" id="btn_sub" name="btn_sub" value="Submit">
                                        </div>
                                    </div>
                                </form>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <?php echo $__env->make('admin.script.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        $(document).ready(function() {
            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

</body>

</html><?php /**PATH /var/www/html/fungames_asiaa/resources/views/admin/pages/SendPoint/SendPointToPlayer.blade.php ENDPATH**/ ?>