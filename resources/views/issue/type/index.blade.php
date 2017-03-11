@extends('layouts.app')

@section('content')
    <div class="container">
        <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Types</span> List</span>
        <a  href="/issue/type/add" class="floatRight">Type Create</a>
        <table class="table table-hover">
            <thead>
            <th>Name</th>
            <th></th>
            <th></th>
            </thead>
            <tbody>
            @foreach($issueTypes as $issue)
                <tr>
                    <td>{{$issue->name}}</td>
                    <td><a  href="/issue/type/edit/{{$issue->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                    <td><a  href="/issue/type/delete/{{$issue->id}}" class="floatRight"><i class="glyphicon glyphicon-remove danger" data-toggle="tooltip" title="Delete"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection