@extends('layouts.app')

@section('content')
    <div class="container">
        <span class="text-left text-muted"><span class="userName">{{$project->name}}</span>/<span class="userName">{{$project->key}}</span> Issues:</span>
        <a href="/issue/add/{{$project->key}}" class="floatR" style="margin-left: 5px; text-decoration: none"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
        <span class="badge baDge-success floatR bWidth marginL">{{$project->getProjectTime()}}h</span><span class="badge baDge-warning floatR bWidth marginL">{{$project->getProjectOE()}}h</span>
        <ul class="issue">
            @if(count( $project->countIssues() > 0))
                @foreach($issues as $issue)
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
                        <span class="badge floatLeft" style="display: block; width: 100px">{{$project->key}} - {{$issue->id}}</span>
                        <span class="summary">{{$issue->summary}}</span>
                        <span class="description">{{$issue->description}}</span>
                        <span class="assign">
                             <span class="marginL">
                                R:
                                 @if($issue->reporter['image_path'] != null)
                                     <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                 @else
                                     <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                 @endif
                            </span>
                            <span class="marginL">
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
                        <span class="badge marginL bWidth">{{$issue->remaining_estimate}}h</span>
                        </span>
                        <span class="marginL">
                            @if($issue->status['name'] === 'open')
                                <span class="baDge baDge-warning">{{$issue->status['name']}}</span>
                            @elseif($issue->status['name'] === 'inProgress')
                                <span class="baDge baDge-info">{{$issue->status['name']}}</span>
                            @elseif($issue->status['name'] === 'review')
                                <span class="baDge baDge-inverse">{{$issue->status['name']}}</span>
                            @elseif($issue->status['name'] === 'testing')
                                <span class="baDge baDge-error">{{$issue->status['name']}}</span>
                            @elseif($issue->status['name'] === 'done')
                                <span class="baDge baDge-success">{{$issue->status['name']}}</span>
                            @endif
                        </span>
                        <span class="linkIssue">
                            <a href="/project/{{$project->key}}/issue/{{$issue->id}}/view">View</a>
                        </span>
                    </li>
                @endforeach
            @else
                <li class="ui-state-default">No issue assigned to Project </li>
            @endif
        </ul>
        <div class="text-center">
            {{$issues->links()}}
        </div>
    </div>
@endsection