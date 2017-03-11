@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-left text-muted"><span class="userName">Sprints</span> List</h4>
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Date start</th>
                <th>Date finish</th>
                <th>Project</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($sprints as $sprint)
                    <tr>
                        <td>{{$sprint->name}}</td>
                        <td>{{$sprint->description}}</td>
                        <td>{{$sprint->date_start}}</td>
                        <td>{{$sprint->date_finish}}</td>
                        <td>{{$sprint->project['name']}}</td>
                        <td><a  href="/sprint/edit/{{$sprint->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection