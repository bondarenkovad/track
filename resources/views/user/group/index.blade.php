@extends('layouts.app')

@section('content')
    <div class="container">
        <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Groups</span> List</span>
        <span class="floatRight"><a  href="/user/group/add">Group Create</a></span>
        <table class="table table-hover">
            <thead>
            <th>Name</th>
            <th>Actions</th>
            <th></th>
            <th></th>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{{$group->name}}</td>
                    <td>
                        <ul> @foreach($group->actions()->get() as $action)</ul>
                        <li>{{$action->name}}</li>
                        @endforeach
                    </td>
                    <td><a  href="/user/group/show/{{$group->id}}" class="floatRight">Show</a></td>
                    <td><a  href="/user/group/edit/{{$group->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection