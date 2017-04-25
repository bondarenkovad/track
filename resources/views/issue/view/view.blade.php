@extends('layouts.app')
@section('content')
    <div class="container">
            @if($project != null)
            <h5><a href="/project/{{$project->id}}/view" style="text-decoration: none"><span class="userName">{{$project->name}}</span>/<span class="userName">{{$project->key}}</span> - <span class="userName">{{$issue->id}}</span></a></h5>
            <h3 class="text-left text-muted">{{$issue->summary}}
            <a class="btn btn-default floatR" data-toggle="modal" data-target="#issueEdit">Edit</a>
            </h3>
            <hr>
            <div class="modal fade" id="issueEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueEditLabel" aria-hidden="true">
                @include('issue.view.issueViewTemplates.issueEditModal')
            </div>
            <div class="modal fade" id="issueComment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueCommentLabel" aria-hidden="true">
                @include('issue.view.issueViewTemplates.issueCommentModal')
            </div>
            <div class="modal fade" id="issueLog" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogLabel" aria-hidden="true">
                @include('issue.view.issueViewTemplates.issueLogModal')
            </div>
            <div class="modal fade" id="issueFile" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueFileLabel" aria-hidden="true">
                @include('issue.view.issueViewTemplates.issueFileModal')
            </div>
            @include('issue.view.issueViewTemplates.leftViewPanel')
            @include('issue.view.issueViewTemplates.rightViewPanel')
        @endif
    </div>
@stop