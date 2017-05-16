@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h4 class="text-left text-muted"><a href="/user/show/{{$user->id}}" style="text-decoration: none"><span class="userName">{{$user->name}}</span></a> Issues:</h4>
        <hr>
        @if($user->hasAnyProject())
            @foreach($user->getUserProjects() as $project)
                @if(count($project->getIssueForUserById($user->id)) > 0)
                    @include('home.homeTemplates.projectForeach')
                @endif
            @endforeach
        @endif
    </div>
@endsection
