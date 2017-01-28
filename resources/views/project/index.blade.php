@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Project List</h1>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Short key</th>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td>{{$project->key}}</td>
                        <td><a  href="/project/edit/{{$project->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/project/delete/{{$project->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection