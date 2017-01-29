@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Priorities List</h1></div>
            <div class="col-md-10 col-md-offset-10"><a  href="/issue/priority/add" class="btn btn-success">Priorities Create</a></div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($issuesPriority as $issue)
                    <tr>
                        <td>{{$issue->name}}</td>
                        <td><a  href="/issue/priority/edit/{{$issue->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/issue/priority/delete/{{$issue->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection