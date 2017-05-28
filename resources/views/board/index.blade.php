@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-xs-6">
                <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Boards</span> List</span>
            </div>
            <div class="col-lg-10 col-sm-6 col-xs-6">
                <a  href="/board/add" class="textDecorNo btn btn-success pull-right">Create</a>
            </div>
        </div>
        <hr>
        <div class="issue">
            @foreach($boards as $board)
               @include('board.BoardTemplates.boardList')
            @endforeach
        </div>
    </div>
@endsection