@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><h1 class="text-center text-muted">Boards List</h1></div>
            <div class="col-md-10 col-md-offset-10"><a  href="/board/add" class="btn btn-success">Board Create</a></div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Project Name</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($boards as $board)
                    <tr>
                        <td>{{$board->name}}</td>
                        <td>{{$board->project['name']}}</td>
                        <td><a  href="/board/edit/{{$board->id}}" class="btn btn-success" >Edit</a></td>
                        <td><a  href="/board/delete/{{$board->id}}" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection