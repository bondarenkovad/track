@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Group Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/user/group/create">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Group Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name">
                            @if ($errors->has('name'))
                                {{session()->flash('danger',$errors->first('name'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-md-4 control-label">Actions</label>

                        <div class="col-md-6">
                            <ul class="list-group">
                                @foreach($actions as $action)
                                    <li class="list-group-item" name="{{$action->name}}">
                                        {{$action->name}}| <input type="checkbox" name="action[{{$action->id}}]">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>

                            <a href="/user/group/index" class="btn btn-success">
                                Back to Group List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop