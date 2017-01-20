@extends('layouts.app')

@section('content')
    <div class="container col-md-6 col-md-offset-2">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$user->name}} ({{$user->email}})</h3>
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
                        You not have any role, contact to Administrator!
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection