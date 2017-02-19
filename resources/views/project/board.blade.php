@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <h1 class="text-center text-muted"><span class="title">{{$project->name}}</span> Board</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@refresh', ['key'=> $project->key])}}">
                    <input type="hidden" name="_method" value="put"/>
                    <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
                    {{ csrf_field() }}
                    @if($project->hasSprints())
                        <div class="form-group">
                            @foreach($project->getSprints() as $sprint)
                                @if($sprint->isActiveSprint())
                                    <div>
                                        <a href="/project/{{$project->key}}/board/sprint/{{$sprint->id}}" class="btn btn-success">
                                            To Active Sprint
                                        </a>
                                    </div>
                                @endif
                                <h3>Sprint - {{$sprint->id}}</h3>
                                @if($sprint->order != null)
                                    <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]" value="{{implode(',',json_decode($sprint->order))}}">
                                @else
                                    <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]">
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul id="sprint-{{$sprint->id}}" class="connectedSortable sprintContainer" data-value="{{$sprint->id}}">
                                         @foreach($sprint->getIssueForSprint() as $issue)
                                                <li class="ui-state-default" data-value="{{$issue->id}}">
                                                <span class="imageSpan">
                                                @if($issue->type['name'] === 'task')
                                                    <img src="/img/status_icon/task.png" class="img">
                                                @elseif($issue->type['name'] === 'story')
                                                    <img src="/img/status_icon/story.png" class="img">
                                                @elseif($issue->type['name'] === 'bug')
                                                    <img src="/img/status_icon/bug.png" class="img">
                                                @endif
                                                </span>
                                                <span class="summary">{{$issue->summary}}</span>
                                                <span class="assign">{{$issue->assigned['name']}}</span>
                                                <span class="key">{{$project->key}} - {{$issue->id}}</span>
                                                <span class="prioritySpan">
                                                @if($issue->priority['name'] === 'trivial')
                                                    <img src="/img/status_icon/trivial.png" class="img">
                                                @elseif($issue->priority['name'] === 'minor')
                                                    <img src="/img/status_icon/minor.png" class="img">
                                                @elseif($issue->priority['name'] === 'major')
                                                    <img src="/img/status_icon/major.png" class="img">
                                                @elseif($issue->priority['name'] === 'critical')
                                                    <img src="/img/status_icon/critical.png" class="img">
                                                @elseif($issue->priority['name'] === 'blocker')
                                                    <img src="/img/status_icon/blocker.png" class="img">
                                                @endif
                                                </span>
                                                <span class="original">{{date("d \d\. H \h\. i \m\. s \s\.",$issue->original_estimate)}}</span>
                                                </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="active" class="col-md-4">Backlog</label>
                            <a href="/sprint/add/{{$project->key}}" class="btn btn-default col-md-offset-6">Create Sprint</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @if($project->order != null)
                                <input id="issueData-backlog" type="hidden" name="issueData[backlog]" value="{{implode(',',json_decode($project->order))}}">
                            @else
                                <input id="issueData-backlog" type="hidden" name="issueData[backlog]">
                            @endif
                            <ul id="backlog" class="connectedSortable sprintContainer" data-value="backlog">
                                    @foreach($project->SortIssueByOrder() as $issue)
                                        <li class="ui-state-default" data-value="{{$issue->id}}">
                                             <span class="imageSpan">
                                                @if($issue->type['name'] === 'task')
                                                    <img src="/img/status_icon/task.png" class="img">
                                                @elseif($issue->type['name'] === 'story')
                                                    <img src="/img/status_icon/story.png" class="img">
                                                @elseif($issue->type['name'] === 'bug')
                                                    <img src="/img/status_icon/bug.png" class="img">
                                                @endif
                                            </span>
                                            <span class="summary">{{$issue->summary}}</span>
                                            <span class="assign">{{$issue->assigned['name']}}</span>
                                            <span class="key">{{$project->key}} - {{$issue->id}}</span>
                                            <span class="prioritySpan">
                                                 @if($issue->priority['name'] === 'trivial')
                                                    <img src="/img/status_icon/trivial.png" class="img">
                                                @elseif($issue->priority['name'] === 'minor')
                                                    <img src="/img/status_icon/minor.png" class="img">
                                                @elseif($issue->priority['name'] === 'major')
                                                    <img src="/img/status_icon/major.png" class="img">
                                                @elseif($issue->priority['name'] === 'critical')
                                                    <img src="/img/status_icon/critical.png" class="img">
                                                @elseif($issue->priority['name'] === 'blocker')
                                                    <img src="/img/status_icon/blocker.png" class="img">
                                                @endif
                                            </span>
                                            <span class="original">{{date("d \d\. H \h\. i \m\. s \s\.",$issue->original_estimate)}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection