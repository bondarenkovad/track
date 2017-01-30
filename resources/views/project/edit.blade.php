@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Project Edit</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@update', ['project'=>$project->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Project Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{$project->name}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Short key</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="key" value="{{$project->key}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('key') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Users</label>

                        <div class="col-md-6">
                            <ul class="list-group">
                                @foreach($project->getAllUsers() as $user)
                                    <li class="list-group-item" name="{{$user->name}}">
                                        {{$user->name}}| <input type="checkbox"  {{ old('type',$project->hasUserInProject($user->name) )  ? 'checked' : '' }} name="user[{{$user->id}}]">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                            <a href="/project/index" class="btn btn-success">
                                Back To Project List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection