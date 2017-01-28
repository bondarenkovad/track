@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Status List</h1>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                </thead>
                <tbody>
                @foreach($issuesStatuses as $issue)
                    <tr>
                        <td>{{$issue->name}}</td>
                        <td><a  href="/issue/status/edit/{{$issue->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/issue/status/delete/{{$issue->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection