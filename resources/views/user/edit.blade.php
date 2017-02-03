@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">User Edit</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('UserController@update', ['user'=>$user->id])}}">
                    {{--<form method="POST" action="{{action('CategoriesController@update',['categories'=>$category->id])}}"/>--}}
                    {{--Название категории<br>--}}
                    {{--<input type="text" name="title" value="{{$category->title}}"/><br>--}}
                    <input type="hidden" name="_method" value="put"/>
                    {{--<input type="hidden" name="_token" value="{{csrf_token()}}"/>--}}
                    {{--<input type="submit" value="Сохранить">--}}
                {{--</form>--}}
                {{--@if(Session::has('message'))--}}
                    {{--{{Session::get('message')}}--}}
                {{--@endif--}}
                    {{ csrf_field() }}

                    {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}

                        {{--<div class="col-md-6">--}}
                            {{--<input type="hidden" value="{{ $user->id }}" name="id">--}}

                            {{--@if ($errors->has('name'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('name') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}



                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Active status</label>

                        <div class="col-md-6">
                            <input type="number" class="form-control" name="active" min="0" max="1" value="{{$user->active}}">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Groups</label>

                        <div class="col-md-6">
                            <ul class="list-group">
                                @foreach($user->getAllGroups() as $group)
                                    <li class="list-group-item" name="{{$group->name}}">
                                        {{$group->name}}| <input type="checkbox"  {{ old('type',$user->hasGroup($group->name) )  ? 'checked' : '' }} name="group[{{$group->id}}]">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Projects</label>

                        <div class="col-md-6">
                            <select class="form-control" id="project" name="project[]" multiple="multiple">
                                @foreach($user->getAllProjects() as $project)
                                    <option value="{{$project->id}}" {{ old('type',$user->hasProject($project->name) )  ? 'selected' : '' }}>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" value="">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Update
                            </button>
                            <a href="/user/index" class="btn btn-success">Back to User List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection