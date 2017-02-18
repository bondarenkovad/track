<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="/select2-4.0.3/dist/css/select2.css">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css" >

    <!-- Styles -->
    <link type="text/css" href="/jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }
        p{
            color: #888;
            margin: 8px 0 12px 0;

        }
        #draggable{
            width: 125px;
            height: 125px;
            padding: 0.5em;
            border: 1px solid #ddd;
        }
        .fa-btn {
            margin-right: 6px;
        }

    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    TRACKER
                </a>
            </div>

            <div class="collapse navbar-collapse data" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->

                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>

                    <li class="dropdown">
                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            User
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/user/index">Users List</a></li>
                            <li><a href="/user/group/index">Groups List</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Issue
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/issue/type/index">Types List</a></li>
                            <li><a href="/issue/priority/index">Priorities List</a></li>
                            <li><a href="/issue/status/index">Statuses List</a></li>
                            <li><a href="/issue/index">Issues List</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Project
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/project/index">Projects List</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Boards
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/board/index">Boards List</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sprint
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/sprint/index">Sprints List</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if(Session::has('status'))
        <h3 id="flash" class="alert alert-success">{{Session::get('status')}}</h3>
        @endif
    @if(Session::has('danger'))
        <h3 id="flash" class="alert alert-danger">{{Session::get('danger')}}</h3>
        @endif
    @yield('content')

    <!-- JavaScripts -->
        <script src="/select2-4.0.3/vendor/jquery-2.1.0.js"></script>
        <script src="/select2-4.0.3/dist/js/select2.js"></script>
        <script>
            setTimeout(function(){
                $('#flash').fadeOut('fast');
            }, 2000);
        </script>
        <script>
          $("#project").select2({
              multiply:true
          });


//          $('#draggable').draggable();
//          $("#project").select2({
//
//          });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
        <script type="text/javascript" src="/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
        <script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script>
            $( function() {
                $( "#sortable1,#sortable2" ).sortable({
                    connectWith: ".connectedSortable"
                }).disableSelection();
            } );

            $( function() {
                $( "#sortable3,#sortable4" ).sortable({
                    connectWith: ".connectedSortable",
                    update:function(event, ui)
                    {
                       $m = [];
                       $('#sortable3 li').each(function() {
                           $m.push($(this).attr('data-value'));
                       });
                        $("#orderId").val($m);

                        var path = window.location.href;
                        var p = path.substring(21);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            }
                        });

                        $.ajax({
                            url: p,
                            type: 'PUT',
                            contentType:"application/json"
//                            beforeSend: function (xhr) {
//                                var token = $('meta[name="csrf_token"]').attr('content');
//                                if (token) {
//                                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
//                                }
//                            }
                        });
//                        alert(p);
//                        $.get(p);
//                        $(location).attr('href',p);
//                        $.post(p);
                    }
                }).disableSelection()
            } );

            $('#submitBtn').on('click', function()
            {
                $mass = [];

                $('#sortable1 li').each(function() {
                    $mass.push($(this).attr('data-value'));
                });

                $("#statusesId").val($mass);
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
