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
            <div class="container-fluid">
                <div class="row ui-state-default">
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <strong>Board Name</strong>
                    </div>
                    <div class="col-lg-4 col-sm-3 col-xs-12">
                        <span>Project Name</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-xs-12"></div>
                </div>
                @foreach($boards as $board)
                   @include('board.BoardTemplates.boardList')
                @endforeach
            </div>
        </div>
    </div>
@endsection