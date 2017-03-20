@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Sprint Create</h1>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{action('SprintController@store', ['project'=>$project->key, 'board'=>$board->id])}}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Sprint Name</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name">
                        @if ($errors->has('name'))
                            {{session()->flash('danger',$errors->first('name'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description" class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <textarea id="description" type="text" class="form-control mytextarea" name="description"></textarea>
                        @if ($errors->has('description'))
                            {{session()->flash('danger',$errors->first('description'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status" class="col-md-4 control-label">Status</label>
                    <div class="col-md-6">
                        <label class="radio-inline"><input type="radio" name="status" value="1">toDo</label>
                        <label class="radio-inline"><input type="radio" name="status" value="2">active</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">finish</label>
                        @if ($errors->has('status'))
                            {{session()->flash('danger',$errors->first('status'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                    <label for="project_id" class="col-md-4 control-label">Project:</label>
                    <div class="col-md-6">
                        <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                        @if ($errors->has('project_id'))
                            {{session()->flash('danger',$errors->first('project_id'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                    <label for="date_start" class="col-md-4 control-label">Date start:</label>
                    <div class="col-md-6">
                        <input id="date_start" type="datetime-local" class="form-control" name="date_start">
                        @if ($errors->has('date_start'))
                            {{session()->flash('danger',$errors->first('date_start'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('date_finish') ? ' has-error' : '' }}">
                    <label for="date_finish" class="col-md-4 control-label">Date finish:</label>
                    <div class="col-md-6">
                        <input id="date_finish" type="datetime-local" class="form-control" name="date_finish">
                        @if ($errors->has('date_finish'))
                            {{session()->flash('danger',$errors->first('date_finish'))}}
                        @endif
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
@stop