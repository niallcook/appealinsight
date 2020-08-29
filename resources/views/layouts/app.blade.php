<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}"></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @yield('stylesheets')

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- DataTables -->
{{--    <link rel="stylesheet" href="{{ asset('css/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/select2/dist/css/select2.css') }}">

    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skins/skin-blue.css') }}" rel="stylesheet">
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

{{--    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
{{--    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
    <style>
        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }
    </style>
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
{{--                        {{ config('app.name', 'Laravel') }}--}}
                        Appeal Insight
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
{{--                    <ul class="nav navbar-nav">--}}
{{--                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>--}}
{{--                        <li><a href="#">Link</a></li>--}}
{{--                    </ul>--}}
{{--                    <form class="navbar-form navbar-left" role="search">--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </div>
                <!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
{{--                                <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        @if (Auth::user()->role->id === 2)
                                            <button type="submit" class="btn btn-primary btn-upload-file" data-toggle="modal" data-target="#uploadFile">
                                                Upload file
                                            </button>
                                        @endif
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        @auth
        <div class="custom-style-content-header">
            <div class="">
                <section class="">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Planning Agent Analytics {{ isset($agent) ?  ' / ' . $agent->name : '' }}</h4>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @endauth

        <div class="container-fluid">
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="uploadFile">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="fileForm" name="fileForm" class="form-inline">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal</h4>
                        <div class="responseInfo" role="alert"></div>
                    </div>
                    <div class="modal-body">
                            <div class="form-group mb-12">
                                <label for="csv_file" class="sr-only">Import CSV</label>
                                <input type="file" id="csv_file" name="csv_file">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="send" value="send">Send
                        </button>
    {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</div>
@yield('scripts')

@guest
<script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js')}}"></script>
@endguest
<script>
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#fileForm').submit(function (e) {
            e.preventDefault();
            $('.responseInfo').empty();
            let formData = new FormData(this);
            $('#send').prop('disabled', true);
            $.ajax({
                url: "{{ url('upload-file') }}",
                type: "POST",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data)
                    $('.responseInfo').append('<div class="alert alert-success" role="alert">\n' +
                        data.message + '</div>');
                    $('.btn-upload-file').prop('disabled', true);
                    setTimeout(() => {
                        $('#fileForm').trigger("reset");
                        $('.responseInfo').empty();
                        $('#uploadFile').modal('hide');
                        $('#send').prop('disabled', false);
                    }, 1500);
                },
                error: function (data) {
                    console.log(data)
                    $('#send').prop('disabled', false);
                    const errors = data.responseJSON.errors.csv_file;
                    errors.forEach(function (element) {
                        $('.responseInfo').append('<div class="alert alert-danger" role="alert">\n' +
                            element + '</div>');
                    });
                }
            });
        });
    });
</script>
</body>
</html>
