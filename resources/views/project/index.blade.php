@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-left text-muted"><span class="userName">Projects</span> List</h4>
                <form action="/project/index" method="post">
                    {{ csrf_field() }}
                    <div class="input-group col-md-4">
                        <input type="text" class="form-control" placeholder="Search project..." name="search">
                     <span class="input-group-btn">
                     <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                    </div>
                </form>
        <div class="text-right"><a  href="/project/add" class="textDecorNo">Project Create</a></div>
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Short key</th>
                <th>Users</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td>{{$project->key}}</td>
                        <td>
                            <ul>
                                @foreach($project->users()->get() as $user)
                                    <li>
                                        <a href="/user/show/{{$user->id}}" style="text-decoration: none">
                                        @if($user->image_path != null)
                                            <img src="{{$user->image_path}}" class="img img-circle" data-toggle="tooltip" title="{{$user->name}}">
                                        @else
                                            <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$user->name}}">
                                        @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td><a  href="/project/edit/{{$project->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                        <td><a  href="/project/delete/{{$project->id}}" class="floatRight"><i class="glyphicon glyphicon-remove danger" data-toggle="tooltip" title="Delete"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection