@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal fade" id="projectIssueCreate" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueCreate" aria-hidden="true">
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

        <span class="text-left text-muted">
            <span class="userName">{{$project->name}}</span>
            /
            <span class="userName">{{$project->key}}
            </span>
        </span>
        <span class="colorShade">issues:{{$project->countIssues()}}</span>
        <a href="#" class="floatR" style="margin-left: 5px; text-decoration: none;" data-toggle="modal" data-target="#projectIssueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
        @if($project->getProjectTime() < 0)
            <span class="badge baDge-error floatR bWidth marginL">{{$project->getProjectTime()}}h</span>
        @else
            <span class="badge baDge-success floatR bWidth marginL">{{$project->getProjectTime()}}h</span>
        @endif
        <span class="badge baDge-warning floatR bWidth marginL">{{$project->getProjectOE()}}h</span>
        <ul class="issue">
            @if( $project->countIssues() > 0)
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
                        <span class="description">{!! strip_tags($issue->description, '<a><b><strong>') !!} </span>
                        <span class="assign">
                             <span class="marginL">
                                R:
                                 @if($issue->reporter['image_path'] != null)
                                     <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none"><img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}"></a>
                                 @else
                                     <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none"><img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}"></a>
                                 @endif
                            </span>
                            <span class="marginL">
                                A:
                                @if($issue->assigned['image_path'] != null)
                                    <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
                                @else
                                    <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
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
                        <span class="badge marginL bWidth">{{$issue->calcRE()}}h</span>
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