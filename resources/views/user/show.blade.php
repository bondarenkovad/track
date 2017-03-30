@extends('layouts.app')

@section('content')
    <div class="container">
                    <div style="height: 50px">
                        <div style="width: 271px">
                            <span style="float: left">
                            @if($user->image_path != null)
                                <img class="imgInfo" src="{{$user->image_path}}">
                            @else
                                <img class="imgInfo" src="/img/userPhoto/defaultPhoto.png">
                            @endif
                            </span>
                            <span style="vertical-align: top; float: left; display: block">{{$user->name}} ({{$user->email}})</span>
                            <span style="float: left; display: block; padding-top: 10px">created at</span>
                        </div>
                        {{--|--}}
                        {{--@if($user->active)--}}
                            {{--<img src="/img/status_icon/on.png">--}}
                        {{--@else--}}
                            {{--<img src="/img/status_icon/off.png">--}}
                        {{--@endif--}}
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

            <a href="/user/index" class="btn btn-success">Back to User List</a>
    </div>
@endsection