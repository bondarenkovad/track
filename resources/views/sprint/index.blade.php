@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Sprints List</h1></div>
        </div>
        <div class="row">
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
                        <td><a  href="/sprint/edit/{{$sprint->id}}" class="btn btn-success" >Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection