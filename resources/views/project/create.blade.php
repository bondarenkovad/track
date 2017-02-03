@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Project Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/project/create">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Project Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name">
                            @if ($errors->has('name'))
                                {{session()->flash('danger',$errors->first('name'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Short key</label>

                        <div class="col-md-6">
                            <input id="key" type="text" class="form-control" name="key">
                            @if ($errors->has('key'))
                                {{session()->flash('danger',$errors->first('key'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Users:</label>

                        <div class="col-md-6">
                                <select class="form-control" id="project" name="user[]" multiple="multiple">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>

                            <a href="/project/index" class="btn btn-success">
                                Back to Projects List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop