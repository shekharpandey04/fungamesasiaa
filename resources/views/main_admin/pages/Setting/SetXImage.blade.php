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


    @include('main_admin.sidebar.sidebar')

    <div class="container body">
        <div class="main_container">
            <div class="right_col" role="main" style="min-height:800px !important;">
                <div class="container x_panel">
                    <div class="row">
                        {{-- <div class="col-md-2"></div> --}}

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="x_panel" style="border:2px solid;">
                            <div class="x_title">
                                <h2>Update 2X Or 4X</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
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

                            </div>
                            <div class="x_content">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                   
                                    <div class="alert alert-success" style="font-size: 17px">Please Active First</div>
                                   
                                    <a title="Active 2X Image" class="btn btn-primary">
                                        <img src="{{url('AppImage\2x.png')}}" width="150" height="150" alt=""><br>
                                        <button onclick="Active(2);" class="btn btn-dark">Active</button>
                                        <button onclick="DeActive(2);" class="btn btn-danger">DeActive</button>
                                    </a>
                                    <span style="margin-left:20px;"></span>
                                    <a title="Active 4X Image" class="btn btn-info">
                                        <img src="{{url('AppImage\4x.png')}}" width="150" height="150" alt=""><br>
                                        <button onclick="Active(4);" class="btn btn-dark">Active</button>
                                        <button onclick="DeActive(4);" class="btn btn-danger">DeActive</button>
                                    </a>


                                </div>
                                <br />




                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    @include('admin.script.datatable')
    @include('admin.script.script')
    <script>
        $(document).ready(function () {
$('#dtHorizontalExample').DataTable({
"scrollX": true
});
$('.dataTables_length').addClass('bs-select');
});
    </script>
<script>
function Active(a){
    var url = window.location.origin+'/Active/'+a;
     window.location.replace(url);
}
function DeActive(a){
    var url = window.location.origin+'/DeActive/'+a;
     window.location.replace(url);
}
</script>
</body>

</html>
