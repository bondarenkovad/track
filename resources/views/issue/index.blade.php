@extends('layouts.app')

@section('content')
    <div class="container">
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
                </thead>
                <tbody>
                @foreach($issues as $issue)
                    <tr>
                        <td>{{$issue->summary}}</td>
                        <td>{{$issue->description}}</td>
                        <td>{{$issue->status['name']}}</td>
                        <td>{{$issue->project_id}}</td>
                        <td>{{$issue->type_id}}</td>
                        <td>{{$issue->priority_id}}</td>
                        <td>{{$issue->reporter_id}}</td>
                        <td>{{$issue->assigned_id}}</td>
                        <td>{{$issue->original_estimate}}</td>
                        <td>{{$issue->remaining_estimate}}</td>
                        {{--<td><a  href="/issue/edit/{{$issue->id}}" class="btn btn-success" >Edit</a></td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection