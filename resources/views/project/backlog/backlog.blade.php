@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        @include('modal.sprintCreate')
        @include('modal.issueCreate')
        @include('modal.sprintEdit')

        <h4 class="text-left text-muted"><a href="/project/{{$project->id}}/view" style="text-decoration: none"><span class="userName">{{$project->name}}</span></a> Board</h4>
        <form role="form" method="POST" action="{{action('ProjectController@refresh', ['key'=> $project->key, 'id'=>$board->id])}}">
            <input type="hidden" name="_method" value="put"/>
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
                {{ csrf_field() }}
                @if($project->hasSprints())
                    @foreach($project->getSprints() as $sprint)
                        @if($sprint->status != 0)
                            @include('project.backlog.backlogTemplates.sprintTemplates')
                        @endif
                    @endforeach
                @endif
                @include('project.backlog.backlogTemplates.backlogTemplate')
        </form>
    </div>
@endsection