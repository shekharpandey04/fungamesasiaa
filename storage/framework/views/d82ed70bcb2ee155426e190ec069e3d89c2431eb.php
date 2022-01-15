<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        .tile-stats .count a {
            width: 38px;
            height: 38px;
            color: #5e0019;
            position: absolute;
            right: 26px;
            top: 13px;
            z-index: 1;
            cursor: pointer;
        }   
        .tile-stats .count a:hover,.tile-stats .count a:focus{
            background-color:#c5ced6;
        }
        .tile-stats .count a>img{
            vertical-align: top;
        }
    </style>
</head>


<body>
    <div class="container body">
        <div class="main_container">
            <?php echo $__env->make('main_admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="page-title">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            
                        </div>
                    </div>
                    <div class="flash-message">
                        <?php if(Session::has('message1')): ?>
                        <p class="alert <?php echo e(Session::get('alert-class', 'alert-success')); ?>" style="font-size: 17px">
                            <?php echo e(Session::get('message1')); ?></p>
                        <?php echo e(Session::forget('message1')); ?>

                        <?php endif; ?>
                        <?php if(Session::has('error1')): ?>
                        <p class="alert <?php echo e(Session::get('alert-class', 'alert-danger')); ?>" style="font-size: 17px">
                            <?php echo e(Session::get('error1')); ?></p>
                        <?php echo e(Session::forget('error1')); ?>

                        <?php endif; ?>
                    </div>
                    <div class="row top_tiles">
                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Night Mode</h3>
                                <div style="padding: 10px">
                                    <a href="<?php echo e(url('/night_mode')); ?>" class="btn btn-success" role="button">Switch</a>
                                    <h5><?php echo e(Session::get('night_mode')); ?></h5>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Prime Mode</h3>
                                <div style="padding: 10px">
                                    <a href="<?php echo e(url('/prime_mode')); ?>" class="btn btn-success" role="button">Switch</a>
                                    <h5><?php echo e(Session::get('prime_mode')); ?></h5>
                                </div>
                            </div>
                        </div> -->

                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <div class="count"><?php echo e(Session::get('dist_count')); ?></div>
                                <h3>Distributor</h3>
                                <p>Total Distributor in this game</p>
                            </div>
                        </div>

                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Joker</h3>
                                <div style="padding: 10px">
                                    <a href="<?php echo e(url('/joker_mode')); ?>" class="btn btn-success" role="button">Switch</a>
                                    <h5><?php echo e(Session::get('joker_mode')); ?></h5>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        
                    </div> <br> <br>
                    <div class="clearfix w_center">
                        <div class="col-md-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="x_panel" style="border:2px solid;">
                                    <div class="x_title">
                                        <h2>Send Points to Distributor</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="text-right">
                                            <a href="<?php echo e(url('/AddNewDistributor')); ?>" title="Add New Player"
                                                class="btn btn-primary">
                                                <i class="fa fa-user-plus"></i>
                                            </a>
                                        </div>
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
                                        <br />
                                        <form method="post" action="<?php echo e(url('/AddDistPoints')); ?>"
                                            class="form-horizontal form-label-left" oncopy="return false"
                                            oncut="return false" onpaste="return false">
                                            <?php echo csrf_field(); ?>
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
                            <div class="col-md-5">
                                <div class="animated flipInY x_panel navbar-right">
                                    <div class="tile-stats">
                                        
                                        <div class="count"><?php echo e($admin_notify_count); ?><span style="margin-left:10px;">Notification</span>
                                            <a href="<?php echo e(url('DeleteNotify')); ?>" data-toggle="tooltip" title="Delete All"><img src="<?php echo e(url('GameImage\delete (1).png')); ?>" width="35px" alt="delete notification icon"></a>
                                        </div>
                                        
                                        <div class="dropdown-menu1">
                                            <div style="overflow-y: auto;max-height: 250px">
                                                <ul>
                                                    <?php if($admin_notify_count == 0): ?>
                                                    <li style="padding:10px;text-align: left;border-bottom: 1px solid"><strong>Notification Not Found</strong></li>
                                                    <?php endif; ?>
                                                    <?php $__currentLoopData = $admin_notify_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li style="padding:10px;text-align: left;border-bottom: 1px solid">
                                                    <?php if(($notify->status)==0): ?>
                                                        <a href="<?php echo e(url('MainAdminNotify/'.$notify->id)); ?>"><?php echo e($notify->distributor_id); ?>

                                                        Return <?php echo e($notify->points); ?> Points</a>
                                                    <?php elseif(($notify->status)==1): ?>
                                                        <a href="<?php echo e(url('MainAdminNotify/'.$notify->id)); ?>">You
                                                        Send <?php echo e($notify->points); ?> Points To <?php echo e($notify->distributor_id); ?></a>
                                                    <?php elseif(($notify->status)==2): ?>
                                                        <a href="<?php echo e(url('MainAdminNotify/'.$notify->id)); ?>"><?php echo e($notify->distributor_id); ?>

                                                        Accepted Your <?php echo e($notify->points); ?> Points</a>
                                                    <?php elseif(($notify->status)==3): ?>
                                                        <a href="<?php echo e(url('MainAdminNotify/'.$notify->id)); ?>"><?php echo e($notify->distributor_id); ?>

                                                        Rejected Your <?php echo e($notify->points); ?> Points</a>
                                                    <?php elseif(($notify->status)==4): ?>
                                                        <a href="<?php echo e(url('MainAdminNotify/'.$notify->id)); ?>"><?php echo e($notify->distributor_id); ?>

                                                        logged into device</a>        
                                                    <?php endif; ?>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('admin.script.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>


<?php /**PATH /var/www/html/fungames_asiaa/resources/views/main_admin/Main_Dashboard.blade.php ENDPATH**/ ?>