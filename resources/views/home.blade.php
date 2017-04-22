@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-left text-muted"><a href="/user/show/{{$user->id}}" style="text-decoration: none"><span class="userName">{{$user->name}}</span></a> Issues:</h4>
        <hr>
        <div class="row">
            @if($user->hasAnyProject())
                @foreach($user->getUserProjects() as $project)
                    @if(count($project->getIssueForUserById($user->id)) > 0)
                        <div class="col-md-12">
                            <a href="/project/{{$project->id}}/view" style="text-decoration: none">Project - {{$project->key}}</a>
                            <span class="colorShade">issues:{{count($project->getIssueForUserById($user->id))}}</span>
                            @if($project->getUserInProjectTime($user->id) < 0)
                                <span class="badge baDge-error floatR bWidth marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
                            @else
                                <span class="badge baDge-success floatR bWidth marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
                            @endif
                            <span class="badge baDge-warning floatR bWidth marginL">{{$project->getUserInProjectOE($user->id)}}h</span>
                            <ul class="issue">
                                @foreach($project->getIssueForUserById($user->id) as $issue)
                                    @include('templates.issueView')
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
