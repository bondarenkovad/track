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
                <li class="active"><a data-toggle="tab" href="#home">User issues</a></li>
                <li><a data-toggle="tab" href="#menu1">General Information</a></li>
            </ul>

            <div class="tab-content">
                <div id="menu1" class="tab-pane fade ">
                    <div class="userGeneral">
                        <dl class="dl-horizontal">
                            <dt>E-mail</dt>
                            <dd>{{$user->email}}</dd>
                            <dt>Status</dt>
                            <dd>
                                @if($user->active === 1)
                                    <img class="img" src="/img/status_icon//on.png">
                                @else
                                    <img class="img" src="/img/status_icon/off.png">
                                @endif
                            </dd>
                            <dt>User Groups</dt>
                            <dd>
                                @foreach($user->groups()->get() as $group)
                                    {{$group->name}}<br>
                                @endforeach
                            </dd>
                            <dt>User Projects</dt>
                            <dd>
                                @foreach($user->projects()->get() as $project)
                                    {{$project->name}}<br>
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>
                <div id="home" class="tab-pane fade in active">
                    <table class="table table-hover">
                        <thead>
                        <th>Summary</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Project</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Reporter</th>
                        <th>Assigned</th>
                        <th>Comments</th>
                        <th>Work Log</th>
                        <th>Files</th>
                        <th>Original estimate</th>
                        <th>Remaining estimate</th>
                        </thead>
                        <tbody>
                        @foreach($issues as $issue)
                            <tr>
                                <td>{{$issue->summary}}</td>
                                <td>{!! $issue->description !!}</td>
                                <td>{{$issue->status['name']}}</td>
                                <td>{{$issue->project['name']}}</td>
                                <td>{{$issue->type['name']}}</td>
                                <td>{{$issue->priority['name']}}</td>
                                <td>
                                    @if($issue->reporter['image_path'] != null)
                                        <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                    @else
                                        <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                    @endif
                                </td>
                                <td>
                                    @if($issue->assigned['image_path'] != null)
                                        <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                    @else
                                        <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                    @endif
                                </td>
                                <td>{{$issue->CountComments()}}</td>
                                <td>{{$issue->CountLogs()}}</td>
                                <td>{{$issue->CountAttachments()}}</td>
                                <td>{{$issue->original_estimate}}</td>
                                <td>{{$issue->remaining_estimate}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{$issues->links()}}
                    </div>
                </div>
        </div>
            <hr>
    </div>
        <a href="{{ URL::previous() }}" class="btn btn-success"><<< Back</a>
    </div>
@endsection