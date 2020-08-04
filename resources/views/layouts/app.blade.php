<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @yield('stylesheets')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skins/skin-blue.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
{{--                    <a href="../../index2.html" class="navbar-brand"><b>Admin</b>LTE</a>--}}
{{--                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">--}}
{{--                        <i class="fa fa-bars"></i>--}}
{{--                    </button>--}}
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Link</a></li>
{{--                        <li class="dropdown">--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
{{--                            <ul class="dropdown-menu" role="menu">--}}
{{--                                <li><a href="#">Action</a></li>--}}
{{--                                <li><a href="#">Another action</a></li>--}}
{{--                                <li><a href="#">Something else here</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">Separated link</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">One more separated link</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                        </div>
                    </form>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
{{--                        <li class="dropdown messages-menu">--}}
{{--                            <!-- Menu toggle button -->--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                                <i class="fa fa-envelope-o"></i>--}}
{{--                                <span class="label label-success">4</span>--}}
{{--                            </a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="header">You have 4 messages</li>--}}
{{--                                <li>--}}
{{--                                    <!-- inner menu: contains the messages -->--}}
{{--                                    <ul class="menu">--}}
{{--                                        <li><!-- start message -->--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <!-- User Image -->--}}
{{--                                                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <!-- Message title and timestamp -->--}}
{{--                                                <h4>--}}
{{--                                                    Support Team--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
{{--                                                </h4>--}}
{{--                                                <!-- The message -->--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <!-- end message -->--}}
{{--                                    </ul>--}}
{{--                                    <!-- /.menu -->--}}
{{--                                </li>--}}
{{--                                <li class="footer"><a href="#">See All Messages</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <!-- /.messages-menu -->

                        <!-- Notifications Menu -->
{{--                        <li class="dropdown notifications-menu">--}}
{{--                            <!-- Menu toggle button -->--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                                <i class="fa fa-bell-o"></i>--}}
{{--                                <span class="label label-warning">10</span>--}}
{{--                            </a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="header">You have 10 notifications</li>--}}
{{--                                <li>--}}
{{--                                    <!-- Inner Menu: contains the notifications -->--}}
{{--                                    <ul class="menu">--}}
{{--                                        <li><!-- start notification -->--}}
{{--                                            <a href="#">--}}
{{--                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <!-- end notification -->--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="footer"><a href="#">View all</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <!-- Tasks Menu -->
{{--                        <li class="dropdown tasks-menu">--}}
{{--                            <!-- Menu Toggle Button -->--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                                <i class="fa fa-flag-o"></i>--}}
{{--                                <span class="label label-danger">9</span>--}}
{{--                            </a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="header">You have 9 tasks</li>--}}
{{--                                <li>--}}
{{--                                    <!-- Inner menu: contains the tasks -->--}}
{{--                                    <ul class="menu">--}}
{{--                                        <li><!-- Task item -->--}}
{{--                                            <a href="#">--}}
{{--                                                <!-- Task title and progress text -->--}}
{{--                                                <h3>--}}
{{--                                                    Design some buttons--}}
{{--                                                    <small class="pull-right">20%</small>--}}
{{--                                                </h3>--}}
{{--                                                <!-- The progress bar -->--}}
{{--                                                <div class="progress xs">--}}
{{--                                                    <!-- Change the css width attribute to simulate progress -->--}}
{{--                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
{{--                                                        <span class="sr-only">20% Complete</span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <!-- end task item -->--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="footer">--}}
{{--                                    <a href="#">View all tasks</a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
{{--                        @endguest--}}
                    @else
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
{{--                                <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
{{--                                <span class="hidden-xs">Alexander Pierce</span>--}}
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
{{--                                <li class="user-header">--}}
{{--                                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

{{--                                    <p>--}}
{{--                                        Alexander Pierce - Web Developer--}}
{{--                                        <small>Member since Nov. 2012</small>--}}
{{--                                    </p>--}}
{{--                                </li>--}}
                                <!-- Menu Body -->
{{--                                <li class="user-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-xs-4 text-center">--}}
{{--                                            <a href="#">Followers</a>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xs-4 text-center">--}}
{{--                                            <a href="#">Sales</a>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xs-4 text-center">--}}
{{--                                            <a href="#">Friends</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <!-- /.row -->
{{--                                </li>--}}
                                <!-- Menu Footer-->
{{--                                <li class="user-footer">--}}
{{--                                    <div class="pull-left">--}}

{{--                                    @if (Auth::user()->role->id === 2)--}}

{{--                                        <button type="submit" class="btn btn-primary btn-upload-file"--}}
{{--                                                data-toggle="modal" data-target="#uploadFile">--}}
{{--                                            Upload file--}}
{{--                                        </button>--}}

{{--                                        <div class="pull-left">--}}
{{--                                            <a type="submit" class="btn btn-primary btn-upload-file"--}}
{{--                                                    data-toggle="modal" data-target="#uploadFile">--}}
{{--                                                Upload file--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                        <li class="nav-item dropdown">--}}
{{--                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
{{--                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                                {{ Auth::user()->name }} <span class="caret"></span>--}}
{{--                                            </a>--}}

{{--                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                                <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                                   onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                                    {{ __('Logout') }}--}}
{{--                                                </a>--}}

{{--                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                                                      style="display: none;">--}}
{{--                                                    @csrf--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
                                @endguest
{{--                                        <a href="#" class="btn btn-default btn-flat">Profile</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="pull-right">--}}
{{--                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
{{--                                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}"--}}
{{--                                           onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                            {{ __('Logout') }}--}}
{{--                                        </a>--}}

{{--                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                                              style="display: none;">--}}
{{--                                            @csrf--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
        @yield('content')
            <!-- Content Header (Page header) -->
{{--            <section class="content-header">--}}
{{--                <h1>--}}
{{--                    Top Navigation--}}
{{--                    <small>Example 2.0</small>--}}
{{--                </h1>--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
{{--                    <li><a href="#">Layout</a></li>--}}
{{--                    <li class="active">Top Navigation</li>--}}
{{--                </ol>--}}
{{--            </section>--}}

            <!-- Main content -->
{{--            <section class="content">--}}
{{--                <div class="callout callout-info">--}}
{{--                    <h4>Tip!</h4>--}}

{{--                    <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a--}}
{{--                        sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular--}}
{{--                        links instead.</p>--}}
{{--                </div>--}}
{{--                <div class="callout callout-danger">--}}
{{--                    <h4>Warning!</h4>--}}

{{--                    <p>The construction of this layout differs from the normal one. In other words, the HTML markup of the navbar--}}
{{--                        and the content will slightly differ than that of the normal layout.</p>--}}
{{--                </div>--}}
{{--                <div class="box box-default">--}}
{{--                    <div class="box-header with-border">--}}
{{--                        <h3 class="box-title">Blank Box</h3>--}}
{{--                    </div>--}}
{{--                    <div class="box-body">--}}
{{--                        The great content goes here--}}
{{--                    </div>--}}
{{--                    <!-- /.box-body -->--}}
{{--                </div>--}}
                <!-- /.box -->
{{--            </section>--}}
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
            reserved.
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->
{{--    <div id="app" class="wrapper" style="height: auto; min-height: 100%;">--}}

{{--        <header class="main-header">--}}
{{--            <nav class="navbar navbar-static-top">--}}
{{--            <div class="container">--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    {{ config('app.name', 'Laravel') }}--}}
{{--                </a>--}}
{{--                <button class="navbar-toggler" type="button" data-toggle="collapse"--}}
{{--                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"--}}
{{--                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

{{--                <!-- Collect the nav links, forms, and other content for toggling -->--}}
{{--                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">--}}
{{--                    <ul class="nav navbar-nav">--}}
{{--                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>--}}
{{--                        <li><a href="#">Link</a></li>--}}
{{--                        <li class="dropdown">--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
{{--                            <ul class="dropdown-menu" role="menu">--}}
{{--                                <li><a href="#">Action</a></li>--}}
{{--                                <li><a href="#">Another action</a></li>--}}
{{--                                <li><a href="#">Something else here</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">Separated link</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">One more separated link</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                    <form class="navbar-form navbar-left" role="search">--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                            @if (Auth::user()->role->id === 2)
                                <button type="submit" class="btn btn-primary btn-upload-file"
                                        data-toggle="modal" data-target="#uploadFile">
                                    Upload file
                                </button>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
                        @endguest
                    </ul>
                </div>
{{--            </div>--}}
{{--        </nav>--}}
{{--        </header>--}}

{{--        <main class="py-4 content-wrapper">--}}
{{--            <div class="container-fluid">--}}
{{--            @yield('content')--}}
{{--            @yield('most_active_planning_agents_diagram')--}}
{{--            @yield('table')--}}

            <div class="modal fade" id="uploadFile" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h4 class="modal-title" id="modelHeading"></h4>
                            <div class="responseInfo" role="alert"></div>
                        </div>
                        <div class="modal-body">
                            <form id="fileForm" name="fileForm" class="form-horizontal">
                                <div class="form-group form-container">
                                    <label for="csv_file" class="col-md-4 control-label">Import CSV</label>
                                    <input type="file" id="csv_file" name="csv_file">
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="send" value="send">Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
{{--            </div>--}}
{{--        </main>--}}
{{--    </div>--}}
{{--    @yield('scripts')--}}

{{--<script src="../../bower_components/jquery/dist/jquery.min.js"></script>--}}
<!-- Bootstrap 3.3.7 -->
{{--<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js'}}"></script>--}}
{{--<!-- SlimScroll -->--}}
{{--<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js'}}"></script>--}}
{{--<!-- FastClick -->--}}
{{--<script src="{{ asset('bower_components/fastclick/lib/fastclick.js'}}"></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="{{ asset('js/dist/js/adminlte.min.js"}}"></script>--}}
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
                        }, 1200);
                    },
                    error: function (data) {
                        console.log(data)
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
