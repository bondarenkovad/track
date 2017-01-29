@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Projects List</h1></div>
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
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td>{{$project->key}}</td>
                        <td>
                            <ul> @foreach($project->users()->get() as $user)</ul>
                            <li>{{$user->name}}</li>
                            @endforeach
                        </td>
                        <td><a  href="/project/edit/{{$project->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/project/delete/{{$project->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection