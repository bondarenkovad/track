@extends('layouts.app')

@section('content')
    <div class="container">
             <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Boards</span> List</span>
            <span style="float: right"><a  href="/board/add" class="">Board Create</a></span>
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>Project Name</th>
                <th>Statuses</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($boards as $board)
                    <tr>
                        <td>{{$board->name}}</td>
                        <td>{{$board->project['name']}}</td>
                        <td>
                            <ul>
                                @foreach($board->orderByOrders() as $status)
                                    <li>{{$status->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td><a  href="/board/edit/{{$board->id}}" style="float: right">Edit</a></td>
                        <td><a  href="/board/delete/{{$board->id}}" style="float: right"><span class="danger">Delete</span></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection