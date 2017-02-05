@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Issue Edit</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@update', ['issue'=>$issue->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                        <label for="summary" class="col-md-4 control-label">Issue Summary</label>
                        <div class="col-md-6">
                            <input id="summary" type="text" class="form-control" name="summary" value="{{$issue->summary}}">
                            @if ($errors->has('summary'))
                                {{session()->flash('danger',$errors->first('summary'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control" name="description" value="{{$issue->description}}">
                            @if ($errors->has('description'))
                                {{session()->flash('danger',$errors->first('description'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Status:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="status_id" name="status_id" value="{{$issue->status_id}}">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('status_id'))
                                {{session()->flash('danger',$errors->first('status_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Project:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="project_id">
                            @foreach($projects as $project)
                                @if($issue->project['name'] === $project->name)
                                        <option selected value="{{$project->id}}">{{$project->name}}</option>
                                 @else
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('project_id'))
                                {{session()->flash('danger',$errors->first('project_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Type:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="type_id">
                                @foreach($types as $type)
                                    @if($issue->type['name'] === $type->name)
                                        <option selected value="{{$type->id}}">{{$type->name}}</option>
                                    @else
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('type_id'))
                                {{session()->flash('danger',$errors->first('type_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('priority_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Priority:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="priority_id" name="priority_id">
                                @foreach($priorities as $priority)
                                    @if($issue->priority['name'] === $priority->name)
                                    <option selected value="{{$priority->id}}">{{$priority->name}}</option>
                                    @else
                                    <option value="{{$priority->id}}">{{$priority->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('priority_id'))
                                {{session()->flash('danger',$errors->first('priority_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('reporter_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Reporter:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="reporter_id" name="reporter_id">
                                @foreach($users as $user)
                                    @if($issue->reporter['name'] === $user->name)
                                        <option selected value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('reporter_id'))
                                {{session()->flash('danger',$errors->first('reporter_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('assigned_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Assigned:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="assigned_id" name="assigned_id">
                                @foreach($users as $user)
                                    @if($issue->assigned['name'] === $user->name)
                                        <option selected value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('assigned_id'))
                                {{session()->flash('danger',$errors->first('assigned_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('original_estimate') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Original Estimate:</label>
                        <div class="col-md-6">
                            <input id="original_estimate" type="datetime" class="form-control" name="original_estimate" value="{{$issue->original_estimate}}">
                            @if ($errors->has('original_estimate'))
                                {{session()->flash('danger',$errors->first('original_estimate'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('remaining_estimate') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Remaining Estimate:</label>
                        <div class="col-md-6">
                            <input id="remaining_estimate" type="datetime" class="form-control" name="remaining_estimate" value="{{$issue->remaining_estimate}}">
                            @if ($errors->has('remaining_estimate'))
                                {{session()->flash('danger',$errors->first('remaining_estimate'))}}
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>

                            <a href="/issue/index" class="btn btn-success">
                                Back to Issues List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop