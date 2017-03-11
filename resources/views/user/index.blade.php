@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-left text-muted"><span class="userName">Users</span> List</h4>
        <form action="/user/index" method="post">
        {{ csrf_field() }}
            <div class="input-group col-md-4">
            <input type="text" class="form-control span2" placeholder="Search user..." name="search">
            <span class="input-group-btn">
            <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </span>
            </div>
        </form>
        <div class="text-right" style="margin-right: 20px"><a  href="/user/add">User Create</a></div>
        <table class="table table-hover">
            <thead>
                <th>Name</th>
                <th>Photo</th>
                <th>E-mail</th>
                <th>Active</th>
                <th>Groups</th>
                <th>Projects</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                <td>{{$user->name}}</td>
                <td>
                    @if($user->image_path != null)
                    <img class="img img-circle" src="{{$user->image_path}}" data-toggle="tooltip" title="{{$user->name}}">
                    @else
                    <img class="img" src="/img/userPhoto/defaultPhoto.png" data-toggle="tooltip" title="{{$user->name}}">
                    @endif
                </td>
                <td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
                <td>
                    @if($user->active)
                    <img src="/img/status_icon/on.png">
                    @else
                    <img src="/img/status_icon/off.png">
                    @endif
                </td>
                <td>
                    <ul>
                        @foreach($user->groups()->get() as $group)
                            <li>{{$group->name}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                        @foreach($user->projects()->get() as $project)
                            <li>{{$project->name}}</li>
                        @endforeach
                    </ul>
                </td>
                <td><a  href="/user/show/{{$user->id}}" class="floatRight"><i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" title="Show"></i></a></td>
                <td><a  href="/user/edit/{{$user->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection