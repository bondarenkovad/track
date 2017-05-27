@extends('layouts.app')
@section('content')
    <div class="container">
        @if($project != null)
        <h4>
            <a href="/project/{{$project->id}}/view" style="text-decoration: none">
                <span class="userName text-capitalize">{{$project->name}}</span>
                /
                <span class="userName">
                    {{$project->key}}
                </span> -
                <span class="userName">
                    {{$issue->id}}
                </span>
            </a>
        </h4>
        <hr>
        <h3 class="text-left text-muted">{{$issue->summary}}
        <a class="btn btn-default pull-right" data-toggle="modal" data-target="#issueEdit">Edit</a>
        </h3>
        <hr>
        @include('modal.issueEdit')
        @include('modal.issueComment')
        @include('modal.issueLog')
        @include('modal.issueFile')
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12">
                @include('issue.view.issueViewTemplates.leftViewPanel')
            </div>
            <div class="col-lg-6 col-sm-12 col-xs-12">
                @include('issue.view.issueViewTemplates.rightViewPanel')
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                @include('issue.view.issueViewTemplates.activityTab')
            </div>
        </div>
    @endif
    </div>
@stop