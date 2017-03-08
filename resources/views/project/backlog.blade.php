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
                        <div>
                            {{--@if($sprint->isActiveSprint())--}}
                                <a href="/project/{{$project->key}}/board/{{$board->id}}/sprint/{{$sprint->id}}">
                                <span class="glyphicon glyphicon-dashboard"></span>
                                </a>
                            {{--@endif--}}
                            <label>Sprint - <span class="userName">{{$sprint->id}}</span></label>
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
                            <span class="badge">{{date("H",$issue->original_estimate)}}</span>
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
                    @endforeach
                @endif
                        <div>
                            <label>Backlog</label>
                            <a href="/sprint/add/{{$project->key}}">Create Sprint</a>
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
                                        <span class="badge">{{date("H",$issue->original_estimate)}}</span>
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
                            <a href="/issue/add/{{$project->key}}">Create Issue</a>
                        </div>
        </form>
    </div>
@endsection