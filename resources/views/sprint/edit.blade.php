@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Sprint Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('SprintController@update', ['sprint'=>$sprint->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Sprint Name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{$sprint->name}}">
                            @if ($errors->has('name'))
                                {{session()->flash('danger',$errors->first('name'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control mytextarea" name="description">{{$sprint->description}}</textarea>
                            @if ($errors->has('description'))
                                {{session()->flash('danger',$errors->first('description'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status" class="col-md-4 control-label">Status</label>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="status" value="1" {{ $sprint->status == 1  ? 'checked' : '' }} >toDo</label>
                            <label class="radio-inline"><input type="radio" name="status" value="2" {{ $sprint->status ==2  ? 'checked' : '' }}>active</label>
                            <label class="radio-inline"><input type="radio" name="status" value="0" {{ $sprint->status ==0  ? 'checked' : '' }}>finish</label>
                            @if ($errors->has('status'))
                                {{session()->flash('danger',$errors->first('status'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                        <label for="projct_id" class="col-md-4 control-label">Projects:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="project_id" name="project_id">
                                @foreach($projects as $project)
                                    @if($sprint->project['name'] === $project->name)
                                        <option selected value="{{$project->id}}">{{$project->name}}</option>
                                    @else
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </select>
                            @if ($errors->has('project_id'))
                                {{session()->flash('danger',$errors->first('project_id'))}}
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                        <label for="date_start" class="col-md-4 control-label">Date start:</label>
                        <div class="col-md-6">
                            <input id="date_start" type="datetime" class="form-control" name="date_start" value="{{$sprint->date_start}}">
                            @if ($errors->has('date_start'))
                                {{session()->flash('danger',$errors->first('date_start'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('date_finish') ? ' has-error' : '' }}">
                        <label for="date_finish" class="col-md-4 control-label">Date finish:</label>
                        <div class="col-md-6">
                            <input id="date_finish" type="datetime" class="form-control" name="date_finish" value="{{$sprint->date_finish}}">
                            @if ($errors->has('date_finish'))
                                {{session()->flash('danger',$errors->first('date_finish'))}}
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>

                            <a href="/sprint/index" class="btn btn-success">
                                Back to Sprints List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop