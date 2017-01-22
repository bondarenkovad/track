@extends('layouts.app')

@section('content')
    <div class="container">
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
                        <td><a  href="/group/show/{{$group->id}}" class="btn btn-default" >Show</a> </td>
                        <td><a  href="/group/edit/{{$group->id}}" class="btn btn-success" >Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection