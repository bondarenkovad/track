@extends('layouts.app')

@section('content')
    <div class="container">
             <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Boards</span> List</span>
            <span class="floatRight"><a  href="/board/add" class="textDecorNo">Board Create</a></span>
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
                        <td><a  href="/board/edit/{{$board->id}}" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                        <td><a  href="/board/delete/{{$board->id}}" class="floatRight"><i class="glyphicon glyphicon-remove danger" data-toggle="tooltip" title="Delete"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection