@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@updateSprint', ['key'=> $project->key, 'i'=>$board->id, 'id'=>$sprint->id])}}">
            <input type="hidden" name="_method" value="put"/>
            {{ csrf_field() }}
        <a href="/project/{{$project->key}}/board/{{$board->id}}/backlog" style="text-decoration: none"><h4 class="text-left text-muted">Sprint -<span class="userName"> {{$sprint->id}}</span></h4></a>
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="sprintId" type="hidden" name="sprintId" value="{{$sprint->id}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
            @include('modal.boardLog')

            <div class="statusBlock">
                @foreach($board->statuses()->get() as $status)
                    <div class="statusContainer" style="width:{{$board-> widthSizing()}}%;">
                        <h3 class="text-center">{{$status->name}}</h3>
                        <hr>
                        <ul id="issueContainer_{{$status->id}}" class="issueContainer connectedIssueSortable" data-value="{{$status->id}}">
                            @foreach($sprint->getIssueByStatus($status->id) as $issue)
                                @include('list.boardIssueView')
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@stop