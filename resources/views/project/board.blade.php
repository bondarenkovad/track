@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <h1 class="text-center text-muted"><span class="title">{{$project->name}}</span> Board</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@refresh', ['key'=> $project->key])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}
                <div class="form-group">
                    @if($project->hasActiveSprint())
                        <label for="active" class="col-md-4"> Active Sprint - {{$project->getFirstActiveSprint()->id}}</label>
                    @else
                        <label for="active" class="col-md-4"> Active Sprint - none</label>
                    @endif
                        <div class="col-md-12">
                            <div class="row">
                                <ul id="sortable4" class="connectedSortable">
                                    @if($project->hasActiveSprint())
                                    @foreach($project->getFirstActiveSprint()->SortIssueByOrder() as $issue)
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
                                    @endif
                                </ul>
                            </div>
                            @if($project->hasActiveSprint())
                            <input id="activeSprint" type="hidden" name="activeSprint" value="{{$project->getFirstActiveSprint()->id}}">
                            @endif
                            <input id="activeSprintId" type="hidden" name="activeSprintId">
                        </div>
                    </div>
                    <div class="form-group">
                        <hr>
                        @if($project->hasToDoSprint())
                            <label for="active" class="col-md-4"> toDo Sprint - {{$project->getFirstToDoSprint()->id}}</label>
                        @else
                            <label for="active" class="col-md-4"> toDo Sprint - none</label>
                        @endif
                        <div class="col-md-12">
                            <div class="row">
                                <ul id="sortable4" class="connectedSortable">
                                    @if($project-> hasToDoSprint())
                                        @foreach($project->getFirstToDoSprint()->SortIssueByOrder() as $issue)
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
                                    @endif
                                </ul>
                            </div>
                            @if($project->hasToDoSprint())
                                <input id="toDoSprint" type="hidden" name="toDoSprint" value="{{$project->getFirstToDoSprint()->id}}">
                            @endif
                            <input id="toDoSprintId" type="hidden" name="toDoSprintId">
                        </div>
                    </div>
                    <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="active" class="col-md-4">Backlog</label>
                            <a href="/sprint/add/{{$project->key}}" class="btn btn-default col-md-offset-6">Create Sprint</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                                <ul id="sortable3" class="connectedSortable">
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
                        <input id="orderId" type="hidden" name="orderId">
                    </div>
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>

                        <a href="/project/index" class="btn btn-success">
                            Back to Project List
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection