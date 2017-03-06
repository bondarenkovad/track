@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-muted"><span class="title">{{$user->name}}</span> Issues:</h1>
    <div class="row">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group">
                    <div class="row">
                        @if($user->hasAnyProject())
                            @foreach($user->getUserProjects() as $project)
                                @if(count($project->getIssueForUserById($user->id)) > 0)
                                    <div class="col-md-12">
                                        <h4  class="title">Project - {{$project->key}}</h4>
                                        <ul class="issue">
                                            @foreach($project->getIssueForUserById($user->id) as $issue)
                                                <li class="ui-state-default" data-value="{{$issue->id}}">
                                                    <span class="imageSpan">
                                                        @if($issue->type['name'] === 'task')
                                                            <img src="/img/status_icon/task.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                        @elseif($issue->type['name'] === 'story')
                                                            <img src="/img/status_icon/story.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                        @elseif($issue->type['name'] === 'bug')
                                                            <img src="/img/status_icon/bug.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                        @endif
                                                    </span>
                                                    <span class="summary">{{$issue->summary}}</span>
                                                    <span class="description">{{$issue->description}}</span>
                                                    <span class="assign">
                                                        R:
                                                            @if($issue->reporter['image_path'] != null)
                                                                <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                                            @else
                                                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                                            @endif
                                                    </span>
                                                    <span class="assign">
                                                        A:
                                                            @if($issue->assigned['image_path'] != null)
                                                                <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                                            @else
                                                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                                            @endif
                                                        </span>
                                                    <span class="prioritySpan">
                                                        @if($issue->priority['name'] === 'trivial')
                                                            <img src="/img/status_icon/trivial.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                        @elseif($issue->priority['name'] === 'minor')
                                                            <img src="/img/status_icon/minor.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                        @elseif($issue->priority['name'] === 'major')
                                                            <img src="/img/status_icon/major.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                        @elseif($issue->priority['name'] === 'critical')
                                                            <img src="/img/status_icon/critical.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                        @elseif($issue->priority['name'] === 'blocker')
                                                            <img src="/img/status_icon/blocker.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                        @endif
                                                    </span>
                                                    <span>
                                                    <span class="badge">{{date("H",$issue->original_estimate)}}</span>
                                                    </span>
                                                    <span class="text-right">
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
            </form>
        </div>
    </div>
</div>
@endsection
