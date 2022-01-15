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
            @include('main_admin.sidebar.sidebar')
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="row">
                    <div class="page-title">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            {{-- <h2 style="font-size:25px;background:white">Welcome to Admin Dashboard...</h2> --}}
                        </div>
                    </div>
                    <div class="flash-message">
                        @if(Session::has('message1'))
                        <p class="alert {{ Session::get('alert-class', 'alert-success') }}" style="font-size: 17px">
                            {{ Session::get('message1') }}</p>
                        {{ Session::forget('message1') }}
                        @endif
                        @if(Session::has('error1'))
                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}" style="font-size: 17px">
                            {{ Session::get('error1') }}</p>
                        {{ Session::forget('error1') }}
                        @endif
                    </div>
                    <div class="row top_tiles">
                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Night Mode</h3>
                                <div style="padding: 10px">
                                    <a href="{{url('/night_mode')}}" class="btn btn-success" role="button">Switch</a>
                                    <h5>{{ Session::get('night_mode') }}</h5>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Prime Mode</h3>
                                <div style="padding: 10px">
                                    <a href="{{url('/prime_mode')}}" class="btn btn-success" role="button">Switch</a>
                                    <h5>{{ Session::get('prime_mode') }}</h5>
                                </div>
                            </div>
                        </div> -->

                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <div class="count">{{ Session::get('dist_count') }}</div>
                                <h3>Distributor</h3>
                                <p>Total Distributor in this game</p>
                            </div>
                        </div>

                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-delicious"></i></div>
                                <h3 style="padding: 10px">Joker</h3>
                                <div style="padding: 10px">
                                    <a href="{{url('/joker_mode')}}" class="btn btn-success" role="button">Switch</a>
                                    <h5>{{ Session::get('joker_mode') }}</h5>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                                <div class="count">10</div>
                                <h3>New Request</h3>
                                <p>Total User Request</p>
                            </div>
                        </div> --}}
                        {{-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-trophy"></i></div>
                                <div class="count">10</div>
                                <h3>Winners</h3>
                                <p>Todays Total Winners</p>
                            </div>
                        </div> --}}
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
                                            <a href="{{url('/AddNewDistributor')}}" title="Add New Player"
                                                class="btn btn-primary">
                                                <i class="fa fa-user-plus"></i>
                                            </a>
                                        </div>
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
                                        <br />
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
                            <div class="col-md-5">
                                <div class="animated flipInY x_panel navbar-right">
                                    <div class="tile-stats">
                                        {{--<div class="icon"><img src="{{url('GameImage\notification_icon.png')}}" width="25px" alt="notification icon"></div>--}}
                                        <div class="count">{{$admin_notify_count}}<span style="margin-left:10px;">Notification</span>
                                            <a href="{{url('DeleteNotify')}}" data-toggle="tooltip" title="Delete All"><img src="{{url('GameImage\delete (1).png')}}" width="35px" alt="delete notification icon"></a>
                                        </div>
                                        {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                            <img src="{{url('GameImage\notification_icon.png')}}" width="22px" alt="notification icon">
                                            &nbsp;<span class="badge">{{Session::get('notify_count')}}</span>
                                        </a> --}}
                                        <div class="dropdown-menu1">
                                            <div style="overflow-y: auto;max-height: 250px">
                                                <ul>
                                                    @if($admin_notify_count == 0)
                                                    <li style="padding:10px;text-align: left;border-bottom: 1px solid"><strong>Notification Not Found</strong></li>
                                                    @endif
                                                    @foreach($admin_notify_data as $notify)
                                                        <li style="padding:10px;text-align: left;border-bottom: 1px solid">
                                                    @if(($notify->status)==0)
                                                        <a href="{{url('MainAdminNotify/'.$notify->id)}}">{{$notify->distributor_id }}
                                                        Return {{$notify->points}} Points</a>
                                                    @elseif(($notify->status)==1)
                                                        <a href="{{url('MainAdminNotify/'.$notify->id)}}">You
                                                        Send {{$notify->points}} Points To {{$notify->distributor_id }}</a>
                                                    @elseif(($notify->status)==2)
                                                        <a href="{{url('MainAdminNotify/'.$notify->id)}}">{{$notify->distributor_id }}
                                                        Accepted Your {{$notify->points}} Points</a>
                                                    @elseif(($notify->status)==3)
                                                        <a href="{{url('MainAdminNotify/'.$notify->id)}}">{{$notify->distributor_id }}
                                                        Rejected Your {{$notify->points}} Points</a>
                                                    @elseif(($notify->status)==4)
                                                        <a href="{{url('MainAdminNotify/'.$notify->id)}}">{{$notify->distributor_id }}
                                                        logged into device</a>        
                                                    @endif
                                                </li>
                                                @endforeach
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
    @include('admin.script.script')
</body>
</html>


