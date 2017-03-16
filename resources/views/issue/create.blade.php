@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Issue Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@store', ['project'=>$project->id])}}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                        <label for="summary" class="col-md-4 control-label">Issue Summary</label>
                        <div class="col-md-6">
                            <input id="summary" type="text" class="form-control" name="summary">
                            @if ($errors->has('summary'))
                                {{session()->flash('danger',$errors->first('summary'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea id="description" class="form-control mytextarea" name="description"></textarea>
                            @if ($errors->has('description'))
                                {{session()->flash('danger',$errors->first('description'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Status:</label>
                        <div class="col-md-6">
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
                        <label for="name" class="col-md-4 control-label">Project:</label>
                        <div class="col-md-6">
                            <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Type:</label>
                        <div class="col-md-6">
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
                        <label for="name" class="col-md-4 control-label">Priority:</label>
                        <div class="col-md-6">
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
                        <label for="name" class="col-md-4 control-label">Reporter:</label>
                        <div class="col-md-6">
                            <input id="reporter_id" type="text" class="form-control" name="reporter_id" readonly value="{{Auth::user()->name}}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('assigned_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Assigned:</label>
                        <div class="col-md-6">
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
                        <label for="name" class="col-md-4 control-label">Original Estimate:</label>
                        <div class="row">
                            <div class="col-md-2">
                                <input id="original_estimate" type="number" class="form-control" name="original_estimate">
                                @if ($errors->has('original_estimate'))
                                    {{session()->flash('danger',$errors->first('original_estimate'))}}
                                @endif
                            </div>
                            <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                 title="The original estimate in hours of how much work is involved resolving this issue">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('remaining_estimate') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Remaining Estimate:</label>
                        <div class="row">
                            <div class="col-md-2">
                                <input id="remaining_estimate" type="number" class="form-control" name="remaining_estimate">
                                @if ($errors->has('remaining_estimate'))
                                    {{session()->flash('danger',$errors->first('remaining_estimate'))}}
                                @endif
                            </div>
                            <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                 title="An estimate of how much work remains until this issue will be resolved in hours">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop