@extends('layouts.app')

@section('content')
    <div class="container col-md-6 col-md-offset-2">
        <h1 class="text-center text-muted">User Show</h1>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$user->name}} ({{$user->email}}) |
                        @if($user->active)
                            <img src="/img/status_icon/on.png">
                            {{--<i class="glyphicon glyphicon-ok-sign"></i>--}}
                        @else
                            <img src="/img/status_icon/off.png">
                        {{--<i class="glyphicon glyphicon-remove-sign"></i>--}}
                        @endif
                    </h3>
                </div>
                <div class="panel-body">
                    <p><b>Group is:</b></p>
                    <ul>
                        @if($user->hasAnyGroup())
                        @foreach($user->groups()->get() as $group)
                        <li>{{$group->name}}</li>
                        @endforeach
                            @else
                            You not a member any Group!
                        @endif
                    </ul>
                    <p><b>And may:</b></p>
                </div>
                <ul class="list-group">
                    @if($user->hasAnyGroup())
                        @foreach($user->getActions() as $action)
                                <li class="list-group-item">{{$action->name}}</li>
                        @endforeach
                    @else
                        <li class="list-group-item">You not have any role, contact to Administrator!</li>
                    @endif
                </ul>
            </div>
            <a href="/user/index" class="btn btn-success">Back to User List</a>
        </div>
    </div>
@endsection