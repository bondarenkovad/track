@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Projects List</h1></div>
            <div class="col-md-3">
                <form action="/project/index" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for..." name="search">
                     <span class="input-group-btn">
                     <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                    </div>
                </form>
            </div>
            <div class="col-md-10 col-md-offset-10"><a  href="/project/add" class="btn btn-success">Project Create</a></div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Short key</th>
                <th>Users</th>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td>{{$project->key}}</td>
                        <td>
                            <ul> @foreach($project->users()->get() as $user)</ul>
                            <li>
                                @if($user->image_path != null)
                                    <img src="{{$user->image_path}}" class="img img-circle" data-toggle="tooltip" title="{{$user->name}}">
                                @else
                                    <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$user->name}}">
                                @endif
                            </li>
                            @endforeach
                        </td>
                        <td><a  href="/project/{{$project->key}}/backlog" class="btn btn-primary" >Show Backlog</a></td>
                        <td><a  href="/project/edit/{{$project->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/project/delete/{{$project->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection