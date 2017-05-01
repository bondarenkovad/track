<nav class="navbar navbar navbar-inverse bg-inverse navbar-static-top">
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
            <a class="navbar-brand" data-toggle="tooltip" title="Tracker">
                <img src="/img/status_icon/logo.png" class="logo img-circle">
            </a>
        </div>

        <div class="collapse navbar-collapse data" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            <ul class="nav navbar-nav">
                @if(Auth::check())
                    <li><a href="{{ url('/') }}">Home</a></li>

                    <li class="dropdown">
                        <a id="dLabel"  href="" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Project
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            @if(Auth::user()->hasAnyProject())
                                @foreach(Auth::user()->getUserProjects() as $project)
                                    <li><a href="/project/{{$project->id}}/view">{{$project->name}}</a></li>
                                @endforeach
                            @else
                                <li>No Project found</li>
                            @endif
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a id="dLabel" href="" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: hand">
                            Board
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            @if(Auth::check())
                                @foreach(Auth::user()->getUserBoards() as $board)
                                    <li><a href="/project/{{$board->project['key']}}/board/{{$board->id}}/backlog">{{$board->name}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    @if( Auth::user()->ifAdmin())
                        <li class="dropdown">
                            <a id="dLabel" href="" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: hand">
                                Administrator panel
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/board/index">Boards List</a></li>
                                <li><a href="/user/group/index">Groups List</a></li>
                                <li><a href="/issue/index">Issues List</a></li>
                                <li><a href="/issue/priority/index">Priorities List</a></li>
                                <li><a href="/project/index">Projects List</a></li>
                                <li><a href="/sprint/index">Sprints List</a></li>
                                <li><a href="/issue/status/index">Statuses List</a></li>
                                <li><a href="/issue/type/index">Types List</a></li>
                                <li><a href="/user/index">Users List</a></li>
                            </ul>
                        </li>
                    @endif
                @endif
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
                            @if(Auth::user()->image_path != null)
                                <img src="{{Auth::user()->image_path}}" class="img img-circle" data-toggle="tooltip" title="{{Auth::user()->name}}">
                            @else
                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{Auth::user()->name}}">
                            @endif
                            <span class="caret"></span>
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