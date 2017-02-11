@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Board Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/board/create">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Board Name:</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name">
                            @if ($errors->has('name'))
                                {{session()->flash('danger',$errors->first('name'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Project:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="project_id" name="project_id">
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('project_id'))
                                {{session()->flash('danger',$errors->first('project_id'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Statuses:</label>

                        <div class="col-md-6">
                            <div class="row">
                                <div id="left" class="form-control">
                                    <ul id="sortable1" class="connectedSortable">
                                        <li class="ui-state-default"></li>
                                    </ul>
                                </div>
                                <div id="right" class="form-control">
                                    <ul id="sortable2" class="connectedSortable">
                                        @foreach($statuses as $status)
                                            <li class="ui-state-default" value="{{$status->id}}">{{$status->name}}</li>
                                         @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{--<select class="form-control" id="project" name="statuses[]" multiple="multiple">--}}
                                {{--@foreach($statuses as $status)--}}
                                    {{--<option value="{{$status->id}}">{{$status->name}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>

                            <a href="/board/index" class="btn btn-success">
                                Back to Boards List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop