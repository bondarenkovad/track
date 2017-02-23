@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Users List</h1></div>
            <div class="col-md-3">
                <form action="/user/index" method="post">
                    {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for..." name="search">
                     <span class="input-group-btn">
                     <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
                </form>
            </div>
            <div class="col-md-10 col-md-offset-10"><a  href="/user/add" class="btn btn-success">User Create</a></div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Photo</th>
                <th>E-mail</th>
                <th>Active</th>
                <th>Groups</th>
                <th>Projects</th>
                <th>Show</th>
                <th>Edit</th>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                            <td>{{$user->name}}</td>
                            <td>
                                @if($user->image_path != null)
                                <img class="img" src="/{{$user->image_path}}">
                                    @else
                                    <img class="img" src="/img/userPhoto/defaultPhoto.png">
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
                                <ul> @foreach($user->groups()->get() as $group)</ul>
                                <li>{{$group->name}}</li>
                                @endforeach
                            </td>
                            <td>
                                <ul> @foreach($user->projects()->get() as $project)</ul>
                                <li>{{$project->name}}</li>
                                @endforeach
                            </td>
                            <td><a  href="/user/show/{{$user->id}}" class="btn btn-default" >Show</a> </td>
                            <td><a  href="/user/edit/{{$user->id}}" class="btn btn-success" >Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection