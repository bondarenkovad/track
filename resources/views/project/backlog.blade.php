@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <h4 class="text-left text-muted"><span class="userName">{{$project->name}}</span> Board</h4>
        <form role="form" method="POST" action="{{action('ProjectController@refresh', ['key'=> $project->key, 'id'=>$board->id])}}">
            <input type="hidden" name="_method" value="put"/>
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
                {{ csrf_field() }}
                @if($project->hasSprints())
                    @foreach($project->getSprints() as $sprint)
                        @if($sprint->status != 0)
                        <div>
                            @if($sprint->isActiveSprint())
                                <a href="/project/{{$project->key}}/board/{{$board->id}}/sprint/{{$sprint->id}}">
                                    <span class="glyphicon glyphicon-hand-left"></span>
                                </a>
                            @endif
                            @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
                                <span class="floatR">
                                    <div class="dropdown pull-right">
                                        <span class="dropdown-toggle colorShade" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="glyphicon glyphicon-option-horizontal"></i>
                                            <span class="caret"></span>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="/sprint/delete/{{$sprint->id}}"><span class="colorShade">Delete Sprint</span></a></li>
                                                @if($sprint->status === 2)
                                                    <li><a href="/sprint/{{$sprint->id}}/makeFinish"><span class="colorShade">Finish Sprint</span></a></li>
                                                @else
                                                    <li><a href="/sprint/{{$sprint->id}}/makeActive"><span class="colorShade">Start Sprint</span></a></li>
                                                @endif
                                        </ul>
                                    </div>
                                </span>
                            @else
                                <span class="floatR"  style="visibility: hidden">
                                    <div class="dropdown pull-right">
                                        <span class="dropdown-toggle colorShade" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="glyphicon glyphicon-option-horizontal"></i>
                                            <span class="caret"></span>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="/sprint/delete/{{$sprint->id}}"><span class="colorShade">Delete Sprint</span></a></li>
                                            @if($sprint->status === 2)
                                                <li><a href="/sprint/{{$sprint->id}}/makeFinish"><span class="colorShade">Finish Sprint</span></a></li>
                                            @else
                                                <li><a href="/sprint/{{$sprint->id}}/makeActive"><span class="colorShade">Start Sprint</span></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </span>
                            @endif
                            <label>Sprint - <span class="userName">{{$sprint->id}}</span> <span class="colorShade">issues:{{count($sprint->getIssueForSprint())}}</span></label><span class="badge floatRight bWidth" style="margin-right: 102px">{{$project->getSprintTime($sprint->id)}}h</span>
                            @if($sprint->order != null)
                                <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]" value="{{implode(',',json_decode($sprint->order))}}">
                            @else
                                <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]">
                            @endif
                            <ul id="sprint-{{$sprint->id}}" class="connectedSortable sprintContainer" data-value="{{$sprint->id}}">
                                @foreach($sprint->getIssueForSprint() as $issue)
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
                                        <span class="badge floatLeft" style="display: block; width: 40px">Id:{{$issue->id}}</span>
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
                                                <span class="baDge" style=" background-color: #f89406">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'inProgress')
                                                <span class="baDge" style="background-color: #3a87ad">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'review')
                                                <span class="baDge" style="background-color: #1a1a1a">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'testing')
                                                <span class="baDge" style="background-color: #953b39">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'done')
                                                <span class="baDge" style="background-color: #468847">{{$issue->status['name']}}</span>
                                            @endif
                                        </span>
                                        <span class="linkIssue">
                                        <a href="/project/{{$project->key}}/issue/{{$issue->id}}/view">View</a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @else
                        @endif
                    @endforeach
                @endif
                        <div>
                        <span class="floatLeft"><b>Backlog</b> <span class="colorShade">issues: {{count($project->SortIssueByOrder())}}</span></span>
                        <span class="badge floatLeft bWidth" style="margin-left: 860px">{{$project->getBacklogTime()}}h</span>
                        @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
                                <a href="/sprint/add/project/{{$project->key}}/board/{{$board->id}}" class="colorShade floatR" style="text-decoration: none">Create Sprint</a>
                        @endif
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
                                            <span class="img glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                        @elseif($issue->type['name'] === 'story')
                                            <span class="img glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                        @elseif($issue->type['name'] === 'bug')
                                            <span class="img glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                        @endif
                                    </span>
                                    <span class="badge floatLeft" style="display: block; width: 40px">Id:{{$issue->id}}</span>
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
                                        <span class="badge marginL bWidth">{{$issue->original_estimate}}h</span>
                                        </span>
                                        <span class="marginL">
                                            @if($issue->status['name'] === 'open')
                                                <span class="baDge" style=" background-color: #f89406">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'inProgress')
                                                <span class="baDge" style="background-color: #3a87ad">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'review')
                                                <span class="baDge" style="background-color: #1a1a1a">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'testing')
                                                <span class="baDge" style="background-color: #953b39">{{$issue->status['name']}}</span>
                                            @elseif($issue->status['name'] === 'done')
                                                <span class="baDge" style="background-color: #468847">{{$issue->status['name']}}</span>
                                            @endif
                                        </span>
                                        <span class="linkIssue">
                                        <a href="/project/{{$project->key}}/issue/{{$issue->id}}/view">View</a>
                                        </span>
                                </li>
                            @endforeach
                        </ul>
                            <span class="floatLeft ">
                                <a href="/issue/add/{{$project->key}}" class="colorShade"><span class="glyphicon glyphicon-plus-sign colorShade"></span>Create Issue</a>
                            </span>
                    </div>
        </form>
    </div>
@endsection