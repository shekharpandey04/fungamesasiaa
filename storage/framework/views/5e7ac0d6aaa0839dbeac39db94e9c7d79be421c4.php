<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div class="container body">
        <div class="main_container">
            <?php echo $__env->make('admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="page-title">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            
                        </div>
                    </div>
                    <div class="row top_tiles">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <div class="count"><?php echo e($player_count); ?></div>
                                <h3>Player</h3>
                                <p>Total Player in this game</p>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                                <div class="count">10</div>
                                <h3>New Request</h3>
                                <p>Total User Request</p>
                            </div>
                        </div> -->
                    <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">


                                <div class="icon"><i class="fa fa-trophy"></i></div>
                                <div class="count">10</div>
                                <h3>Winners</h3>
                                <p>Todays Total Winners</p>
                            </div>
                        </div>  -->
                </div> <br> <br>
                <div class="clearfix w_center">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="x_panel" style="border:2px solid;">
                                <div class="x_title">
                                    <h2>Send Points to User</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="text-right">
                                        <a href="<?php echo e(url('/AddNewUser')); ?>" title="Add New Player" class="btn btn-primary">
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
                                    <form method="post" action="<?php echo e(url('/AddUserPoints')); ?>" class="form-horizontal form-label-left" oncopy="return false" oncut="return false" onpaste="return false">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Distributor</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" id="dist_id" style="cursor: not-allowed;" name="dist_id" readonly value="<?php echo e(Session::get('user')); ?>" class="form-control col-md-10" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter
                                                Id</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" id="user_id" name="user_id" autocomplete="off" placeholder="Enter User Id" maxlength="13" class="form-control col-md-10" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Add
                                                Points</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="number" min="1" id="points" name="points" autocomplete="off" placeholder="How Many Point Transfer" required class="form-control col-md-10" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Enter
                                                Pin</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" id="pin" name="pin" required autocomplete="off" placeholder="Enter PIN" class="form-control col-md-10" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                                <button type="reset" class="btn btn-primary">Reset</button>
                                                <input type="submit" class="btn btn-success" id="btn_sub" name="btn_sub" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="animated flipInY x_panel navbar-right">
                                <div class="tile-stats">
                                    <div class="icon"><img src="<?php echo e(url('GameImage\notification_icon.png')); ?>" width="25px" alt="notification icon"></div>
                                    <div class="count"><?php echo e(Session::get('notify_count')); ?><span style="margin-left:10px;">Notification</span></div>
                                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                            <img src="<?php echo e(url('GameImage\notification_icon.png')); ?>" width="22px" alt="notification icon">
                                    &nbsp;<span class="badge"><?php echo e(Session::get('notify_count')); ?></span>
                                    </!--> -->
                                    <div class="dropdown-menu1">
                                        <div style="overflow-y: auto;max-height: 250px">
                                            <ul>
                                                <?php if(Session::get('notify_count') == 0): ?>
                                                <li style="padding:10px;text-align: left;border-bottom: 1px solid"><strong>Notification Not Found</strong></li>
                                                <?php endif; ?>
                                                <?php if($no_data == 0): ?>
                                                <li style="padding:10px;text-align: left;border-bottom: 1px solid"><strong>Notification Not Found</strong></li>
                                                <?php else: ?>
                                                <?php $__currentLoopData = $dist_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li style="padding:10px;text-align: left;border-bottom: 1px solid">
                                                    <?php if(($notify->status)==0): ?>
                                                    
                                                    <?php if(($notify->reciever)== 'Main Admin'): ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>">You
                                                    Return <?php echo e($notify->points); ?> Points To Main Admin</a>
                                                    <?php else: ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>"><?php echo e($notify->sender); ?>

                                                        Return <?php echo e($notify->points); ?> Points</a>
                                                    <?php endif; ?>

                                                    <?php elseif(($notify->status)==1): ?>
                                                    
                                                    <?php if(($notify->sender)== 'Main Admin'): ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>"><?php echo e($notify->sender); ?>

                                                        Send <?php echo e($notify->points); ?> Points</a>
                                                    <?php else: ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>">You
                                                        Send <?php echo e($notify->points); ?> Points To <?php echo e($notify->reciever); ?></a>
                                                    <?php endif; ?>

                                                    <?php elseif(($notify->status)==2): ?>

                                                    <?php if(($notify->sender)== 'Main Admin'): ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>">You
                                                        Accepted <?php echo e($notify->points); ?> Points From <?php echo e($notify->sender); ?></a>
                                                    <?php else: ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>"><?php echo e($notify->reciever); ?>

                                                        Accepted Your <?php echo e($notify->points); ?> Points</a>
                                                    <?php endif; ?>

                                                    <?php elseif(($notify->status)==3): ?>

                                                    <?php if(($notify->sender)== 'Main Admin'): ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>">You
                                                        Rejected <?php echo e($notify->points); ?> Points From <?php echo e($notify->sender); ?></a>
                                                    <?php else: ?>
                                                    <a href="<?php echo e(url('DisplayNotify/'.$notify->id)); ?>"><?php echo e($notify->reciever); ?>

                                                        Rejected Your <?php echo e($notify->points); ?> Points</a>
                                                    <?php endif; ?>

                                                    <?php endif; ?>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
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
<?php /**PATH /var/www/html/fungames_asiaa/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>