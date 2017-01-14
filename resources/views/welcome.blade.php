@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <p>You are {{$user->name}} and your groups is:</p>
                    <ul>
                        @foreach($user->groups()->get() as $group)
                            <li>{{$group->name}}</li>
                            @endforeach
                    </ul>
                    <p>You may:</p>
                    @if($user->hasRole())
                        <ul>@foreach($user->getActions() as $action)</ul>
                        <li>{{$action->name}}</li>
                        @endforeach
                            @else
                         You not have any role, contact to Administrator!
                     @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
