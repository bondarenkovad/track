@extends('layouts.app')

@section('content')
    <div class="container">
        @include('modal.issueCreate')

        <span class="text-left text-muted">
            <span class="userName">{{$project->name}}</span>
            /
            <span class="userName">{{$project->key}}
            </span>
        </span>
        <span class="colorShade">issues:{{$project->countIssues()}}</span>
        <a href="#" class="floatR" style="margin-left: 5px; text-decoration: none;" data-toggle="modal" data-target="#projectIssueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
        @if($project->getProjectTime() < 0)
            <span class="badge baDge-error floatR bWidth marginL">{{$project->getProjectTime()}}h</span>
        @else
            <span class="badge baDge-success floatR bWidth marginL">{{$project->getProjectTime()}}h</span>
        @endif
        <span class="badge baDge-warning floatR bWidth marginL">{{$project->getProjectOE()}}h</span>
        <ul class="issue">
            @if( $project->countIssues() > 0)
                @foreach($issues as $issue)
                    @include('list.issueView')
                @endforeach
            @else
                <li class="ui-state-default">No issue assigned to Project </li>
            @endif
        </ul>
        <div class="text-center">
            {{$issues->links()}}
        </div>
    </div>
@endsection