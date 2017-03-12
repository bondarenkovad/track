@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-left text-muted"><span class="userName">{{$user->name}}</span> Issues:</h4>
    <hr>
    <div class="row">
        @if($user->hasAnyProject())
            @foreach($user->getUserProjects() as $project)
                @if(count($project->getIssueForUserById($user->id)) > 0)
                    <div class="col-md-12">
                        <span  class="title">Project - {{$project->key}}</span> <span class="badge floatRight" style="margin-right: 157px">{{$project->getUserInProjectTime($user->id)}}h</span>
                        <ul class="issue">
                            @foreach($project->getIssueForUserById($user->id) as $issue)
                                <li class="ui-state-default" data-value="{{$issue->id}}">
                                    <span class="imageSpan">
                                    @if($issue->type['name'] === 'task')
                                        <span class="img glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                        @elseif($issue->type['name'] === 'story')
                                        <span class="img glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                        @elseif($issue->type['name'] === 'bug')
                                        <span class="img glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                    @endif
                                    </span>
                                    <span class="summary">{{$issue->summary}}</span>
                                    <span class="description">{{$issue->description}}</span>
                                    <span class="assign">
                                         <span>
                                            R:
                                             @if($issue->reporter['image_path'] != null)
                                                 <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                             @else
                                                 <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                             @endif
                                        </span>
                                        <span>
                                            A:
                                            @if($issue->assigned['image_path'] != null)
                                                <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                            @else
                                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                            @endif
                                        </span>
                                    </span>
                                    <span class="prioritySpan">
                                        @if($issue->priority['name'] === 'trivial')
                                            <span class="img glyphicon glyphicon-triangle-bottom low" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                        @elseif($issue->priority['name'] === 'minor')
                                            <span class="img glyphicon glyphicon-menu-down" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                        @elseif($issue->priority['name'] === 'major')
                                            <span class="img glyphicon glyphicon-menu-up high" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                        @elseif($issue->priority['name'] === 'critical')
                                             <span class="img glyphicon glyphicon-alert danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                        @elseif($issue->priority['name'] === 'blocker')
                                            <span class="img glyphicon glyphicon-ban-circle danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                        @endif
                                    </span>
                                    <span>
                                    <span class="badge">{{$issue->remaining_estimate}}h</span>
                                    </span>
                                    <span class="statusColor">
                                        @if($issue->status['name'] === 'open')
                                            <span class="statusBGColorO">{{$issue->status['name']}}</span>
                                        @elseif($issue->status['name'] === 'inProgress')
                                            <span class="statusBGColorI">{{$issue->status['name']}}</span>
                                        @elseif($issue->status['name'] === 'review')
                                            <span class="statusBGColorR">{{$issue->status['name']}}</span>
                                        @elseif($issue->status['name'] === 'testing')
                                            <span class="statusBGColorT">{{$issue->status['name']}}</span>
                                        @elseif($issue->status['name'] === 'done')
                                            <span class="statusBGColorD">{{$issue->status['name']}}</span>
                                        @endif
                                    </span>
                                    <span class="linkIssue">
                                        <a href="/project/{{$project->key}}/issue/{{$issue->id}}/view">View Issue</a>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection
