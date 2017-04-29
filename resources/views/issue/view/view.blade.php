@extends('layouts.app')
@section('content')
    <div class="container">
            @if($project != null)
            <h5><a href="/project/{{$project->id}}/view" style="text-decoration: none"><span class="userName">{{$project->name}}</span>/<span class="userName">{{$project->key}}</span> - <span class="userName">{{$issue->id}}</span></a></h5>
            <h3 class="text-left text-muted">{{$issue->summary}}
            <a class="btn btn-default floatR" data-toggle="modal" data-target="#issueEdit">Edit</a>
            </h3>
            <hr>
            @include('modal.issueEdit')
            @include('modal.issueComment')
            @include('modal.issueLog')
            @include('modal.issueFile')
            @include('issue.view.issueViewTemplates.leftViewPanel')
            @include('issue.view.issueViewTemplates.rightViewPanel')
        @endif
    </div>
@stop