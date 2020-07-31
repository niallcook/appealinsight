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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @yield('table')

            <div class="modal fade" id="uploadFile" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
{{--                            <h4 class="modal-title" id="modelHeading"></h4>--}}
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
        </main>
    </div>
    @yield('scripts')
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
