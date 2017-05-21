@extends('layouts.app')

@section('content')
    <div class="container">
        @include('modal.issueCreate')

        <h4 class="text-muted ">
            <span class="userName">{{$project->name}}</span>
            /
            <span class="userName">{{$project->key}}
            </span>
        </h4>
        <hr>
        <span class="colorShade">issues:{{$project->countIssues()}}</span>
        <a href="#" class="floatR" style="margin-left: 5px; text-decoration: none;" data-toggle="modal" data-target="#projectIssueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
        @if($project->getProjectTime() < 0)
            <span class="badge baDge-error floatR marginL">{{$project->getProjectTime()}}h</span>
        @else
            <span class="badge baDge-success floatR marginL">{{$project->getProjectTime()}}h</span>
        @endif
        <span class="badge baDge-warning floatR marginL">{{$project->getProjectOE()}}h</span>
        <div class="issue">
            @if( $project->countIssues() > 0)
                @foreach($issues as $issue)
                    @include('list.issueView')
                @endforeach
            @else
                <div class="row ui-state-default">No issue assigned to Project </div>
            @endif
        </div>
        <div class="text-center">
            {{$issues->links()}}
        </div>
    </div>
@endsection