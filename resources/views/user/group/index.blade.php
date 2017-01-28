@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Groups List</h1>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Actions</th>
                <th>Show</th>
                <th>Edit</th>
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
                        <td><a  href="/user/group/show/{{$group->id}}" class="btn btn-default" >Show</a> </td>
                        <td><a  href="/user/group/edit/{{$group->id}}" class="btn btn-success" >Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection