@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="height: 50px; display: table">
            @if($user->image_path != null)
                <img class="imgInfo" src="{{$user->image_path}}">
            @else
                <img class="imgInfo" src="/img/userPhoto/defaultPhoto.png">
            @endif
            <span style="display: table-cell; vertical-align: top; padding-top: 5px">
                <span class="bolder" style="font-size: 1.2em">{{$user->name}}</span> <span class="badge baDge-success">Enabled</span>
                <br>
                <span class="colorShade">Created At: {{date("M j, Y, g:i a",strtotime($user->created_at))}} | Updated At: {{date("M j, Y, g:i a",strtotime($user->updated_at))}}</span>
            </span>
            <br>
        </div>
        <div style="margin-top: 10px">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">General Information</a></li>
                <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <ul class="list-group">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Morbi leo risus</li>
                        <li class="list-group-item">Porta ac consectetur ac</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div>
        </div>

                    {{--<div>--}}
                        {{--<p><b>Group is:</b></p>--}}
                        {{--<ul>--}}
                            {{--@if($user->hasAnyGroup())--}}
                                {{--@foreach($user->groups()->get() as $group)--}}
                                    {{--<li>{{$group->name}}</li>--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--You not a member any Group!--}}
                            {{--@endif--}}
                        {{--</ul>--}}
                        {{--<p><b>And may:</b></p>--}}
                        {{--<ul class="list-group">--}}
                            {{--@if($user->hasAnyGroup())--}}
                                {{--@foreach($user->getActions() as $action)--}}
                                    {{--<li class="list-group-item">{{$action->name}}</li>--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--<li class="list-group-item">You not have any role, contact to Administrator!</li>--}}
                            {{--@endif--}}
                        {{--</ul>--}}
                    {{--</div>--}}

            {{--<a href="/user/index" class="btn btn-success">Back to User List</a>--}}
    </div>
@endsection