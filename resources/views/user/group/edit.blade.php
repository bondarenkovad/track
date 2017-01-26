@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('GroupController@update', ['group'=>$group->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Group Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{$group->name}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Actions</label>

                        <div class="col-md-6">
                            <ul class="list-group">
                                @foreach($group->getAllActions() as $action)
                                    <li class="list-group-item" name="{{$group->name}}">
                                        {{$action->name}}| <input type="checkbox"  {{ old('type',$group->hasAction($action->name) )  ? 'checked' : '' }} name="action[{{$action->id}}]">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Update
                            </button>
                            <a href="/user/group/index" class="btn btn-success">
                                Back To Group List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection