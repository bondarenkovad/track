@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Group Show</h1>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>E-mail</th>
                <th>Active</th>
                <th>Group</th>
                </thead>
                <tbody>
                    <tr>
                        @if($group->getAllUserWithThisGroup() === [])
                        <td>No User having this Group!</td>
                        @else
                            @foreach($group->getAllUserWithThisGroup() as $user)
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
                        <td>
                            @if($user->active)
                                <img src="/img/status_icon/on.png">
                            @else
                                <img src="/img/status_icon/off.png">
                            @endif
                        </td>
                        <td>
                            {{$group->name}}
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <a href="/user/group/index" class="btn btn-success">Back to Group List</a>
    </div>
@endsection