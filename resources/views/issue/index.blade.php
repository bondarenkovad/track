@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Issues List</h1></div>
            <div class="col-md-10 col-md-offset-10"><a  href="/issue/add" class="btn btn-success">Issue Create</a></div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Summary</th>
                <th>Description</th>
                <th>Status</th>
                <th>Project</th>
                <th>Type</th>
                <th>Priority</th>
                <th>Reporter</th>
                <th>Assigned</th>
                <th>Original estimate</th>
                <th>Remaining estimate</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($issues as $issue)
                    <tr>
                        <td>{{$issue->summary}}</td>
                        <td>{{$issue->description}}</td>
                        <td>{{$issue->status['name']}}</td>
                        <td>{{$issue->project['name']}}</td>
                        <td>{{$issue->type['name']}}</td>
                        <td>{{$issue->priority['name']}}</td>
                        <td>{{$issue->reporter['name']}}</td>
                        <td>{{$issue->assigned['name']}}</td>
                        <td>{{$issue->original_estimate}}</td>
                        <td>{{$issue->remaining_estimate}}</td>
                        <td><a  href="/issue/edit/{{$issue->id}}" class="btn btn-success" >Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection