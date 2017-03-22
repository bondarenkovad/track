@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <div class="modal fade" id="sprintCreate" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="sprintCreate" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title" id="exampleModalLabel">Create Sprint</label>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{action('SprintController@store', ['project'=>$project->key, 'board'=>$board->id])}}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Sprint Name</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="name">
                                    @if ($errors->has('name'))
                                        {{session()->flash('danger',$errors->first('name'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-12">Description</label>
                                <div class="col-md-12">
                                    <textarea id="description" class="form-control mytextarea" name="description"></textarea>
                                    @if ($errors->has('description'))
                                        {{session()->flash('danger',$errors->first('description'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="col-md-12">Status</label>
                                <div class="col-md-12">
                                    <label class="radio-inline"><input type="radio" name="status" value="1">toDo</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="2">active</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="0">finish</label>
                                    @if ($errors->has('status'))
                                        {{session()->flash('danger',$errors->first('status'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                                <label for="project_id" class="col-md-12">Project:</label>
                                <div class="col-md-12">
                                    <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                                    @if ($errors->has('project_id'))
                                        {{session()->flash('danger',$errors->first('project_id'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                                <label for="date_start" class="col-md-12">Date start:</label>
                                <div class="col-md-12">
                                    <input id="date_start" type="datetime-local" class="form-control" name="date_start">
                                    @if ($errors->has('date_start'))
                                        {{session()->flash('danger',$errors->first('date_start'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('date_finish') ? ' has-error' : '' }}">
                                <label for="date_finish" class="col-md-12">Date finish:</label>
                                <div class="col-md-12">
                                    <input id="date_finish" type="datetime-local" class="form-control" name="date_finish">
                                    @if ($errors->has('date_finish'))
                                        {{session()->flash('danger',$errors->first('date_finish'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Sprint</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="issueCreate" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueCreate" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title" id="exampleModalLabel">Create Issue</label>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@modalStore', ['project'=>$project->id])}}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                <label for="summary" class="col-md-12">Issue Summary</label>
                                <div class="col-md-12">
                                    <input id="summary" type="text" class="form-control" name="summary">
                                    @if ($errors->has('summary'))
                                        {{session()->flash('danger',$errors->first('summary'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Description</label>
                                <div class="col-md-12">
                                    <textarea id="description" class="form-control mytextarea" name="description"></textarea>
                                    @if ($errors->has('description'))
                                        {{session()->flash('danger',$errors->first('description'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Status:</label>
                                <div class="col-md-12">
                                    <select class="form-control" id="status_id" name="status_id">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status_id'))
                                        {{session()->flash('danger',$errors->first('status_id'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-12">Project:</label>
                                <div class="col-md-12">
                                    <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Type:</label>
                                <div class="col-md-12">
                                    <select class="form-control" id="type_id" name="type_id">
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_id'))
                                        {{session()->flash('danger',$errors->first('type_id'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('priority_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Priority:</label>
                                <div class="col-md-12">
                                    <select class="form-control" id="priority_id" name="priority_id">
                                        @foreach($priorities as $priority)
                                            <option value="{{$priority->id}}">{{$priority->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('priority_id'))
                                        {{session()->flash('danger',$errors->first('priority_id'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-12">Reporter:</label>
                                <div class="col-md-12">
                                    <input id="reporter_id" type="text" class="form-control" name="reporter_id" readonly value="{{Auth::user()->name}}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('assigned_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Assigned:</label>
                                <div class="col-md-12">
                                    <select class="form-control" id="assigned_id" name="assigned_id">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('assigned_id'))
                                        {{session()->flash('danger',$errors->first('assigned_id'))}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('original_estimate') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Original Estimate:</label>
                                    <div class="col-md-11">
                                        <input id="original_estimate" type="number" class="form-control" name="original_estimate">
                                        @if ($errors->has('original_estimate'))
                                            {{session()->flash('danger',$errors->first('original_estimate'))}}
                                        @endif
                                    </div>
                                    <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                         title="The original estimate in hours of how much work is involved resolving this issue">
                            </div>

                            <div class="form-group{{ $errors->has('remaining_estimate') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-12">Remaining Estimate:</label>
                                    <div class="col-md-11">
                                        <input id="remaining_estimate" type="number" class="form-control" name="remaining_estimate">
                                        @if ($errors->has('remaining_estimate'))
                                            {{session()->flash('danger',$errors->first('remaining_estimate'))}}
                                        @endif
                                    </div>
                                    <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                         title="An estimate of how much work remains until this issue will be resolved in hours">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Issue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="text-left text-muted"><a href="/project/{{$project->id}}/view" style="text-decoration: none"><span class="userName">{{$project->name}}</span></a> Board</h4>
        <form role="form" method="POST" action="{{action('ProjectController@refresh', ['key'=> $project->key, 'id'=>$board->id])}}">
            <input type="hidden" name="_method" value="put"/>
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
                {{ csrf_field() }}
                @if($project->hasSprints())
                    @foreach($project->getSprints() as $sprint)
                        @if($sprint->status != 0)
                            <div>
                            @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
                                <span class="floatR" style="margin-left: 5px">
                                    <div class="dropdown pull-right">
                                        <span class="dropdown-toggle colorShade" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="glyphicon glyphicon-option-horizontal"></i>
                                            <span class="caret"></span>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="/sprint/edit/{{$sprint->id}}/board/{{$board->id}}"><span class="colorShade">Edit Sprint</span></a></li>
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
                            <label>
                                @if($sprint->isActive())
                                    <a href="/project/{{$project->key}}/board/{{$board->id}}/sprint/{{$sprint->id}}"  style="text-decoration: none">
                                        <span class="glyphicon glyphicon-hand-left"></span> Sprint - <span class="userName">{{$sprint->id}}</span>
                                    </a>
                                    @else
                                    Sprint - <span class="userName">{{$sprint->id}}</span>
                                @endif
                                     <span class="colorShade">issues:{{count($sprint->getIssueForSprint())}}</span></label><span class="badge baDge-success floatR bWidth marginL">{{$project->getSprintTime($sprint->id)}}h</span><span class="badge baDge-warning floatR bWidth marginL">{{$project->getSprintOE($sprint->id)}}h</span>
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
                                        <span class="badge floatLeft" style="display: block; width: 100px">{{$project->key}} - {{$issue->id}}</span>
                                        <span class="summary">{{$issue->summary}}</span>
                                        <span class="description">{{strip_tags($issue->description)}}</span>
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
                        @endif
                    @endforeach
                @endif
                <div>
                    @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
                        <a class="floatR" style="text-decoration: none; margin-left: 5px" data-toggle="modal" data-target="#sprintCreate"><span class="glyphicon glyphicon-plus-sign"></span>Sprint</a>
                    @endif
                        <span class="floatLeft"><b>Backlog</b> <span class="colorShade"><b>issues: {{count($project->SortIssueByOrder())}}</b></span></span>
                        <span class="badge baDge-success floatR bWidth marginL">{{$project->getBacklogTime()}}h</span><span class="badge baDge-warning floatR bWidth marginL">{{$project->getBacklogOE()}}h</span>
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
                        <span class="floatR">
                            <a style="text-decoration: none" data-toggle="modal" data-target="#issueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
                        </span>
                </div>
        </form>
    </div>
@endsection