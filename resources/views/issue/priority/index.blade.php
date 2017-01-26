@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
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