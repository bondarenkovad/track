@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@updateSprint', ['key'=> $project->key, 'id'=>$sprint->id])}}">
            <input type="hidden" name="_method" value="put"/>
            {{ csrf_field() }}
        <h3 class="text-left text-muted">Sprint <span class="title">{{$sprint->id}}</span></h3>
        <div class="row">
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="sprintId" type="hidden" name="sprintId" value="{{$sprint->id}}">
            @foreach($board->statuses()->get() as $status)
            <div class="statusContainer" style="width: {{$board-> widthSizing()}}">
                <h3 class="text-center">{{$status->name}}</h3>
                <hr>
                <ul id="issueContainer_{{$status->id}}" class="issueContainer connectedIssueSortable" data-value="{{$status->id}}">
                @foreach($sprint->getIssueByStatus($status->id) as $issue)
                                <li class="ui-state-default" data-value="{{$issue->id}}">
                                    <div class="container">
                                        <div class="row">
                                            <span>{{$issue->summary}}</span>
                                            <span class="col-md-offset-2">{{$issue->description}}</span>
                                        </div>
                                        <div class="row">
                                            <div>
                                                 <span>
                                                @if($issue->type['name'] === 'task')
                                                         <img src="/img/status_icon/task.png" class="imgMini" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                     @elseif($issue->type['name'] === 'story')
                                                         <img src="/img/status_icon/story.png" class="imgMini" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                     @elseif($issue->type['name'] === 'bug')
                                                         <img src="/img/status_icon/bug.png" class="imgMini" data-toggle="tooltip" title="{{$issue->type['name']}}">
                                                     @endif
                                            </span>
                                            <span>
                                                  @if($issue->priority['name'] === 'trivial')
                                                    <img src="/img/status_icon/trivial.png" class="imgMini" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                @elseif($issue->priority['name'] === 'minor')
                                                    <img src="/img/status_icon/minor.png" class="imgMini" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                @elseif($issue->priority['name'] === 'major')
                                                    <img src="/img/status_icon/major.png" class="imgMini" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                @elseif($issue->priority['name'] === 'critical')
                                                    <img src="/img/status_icon/critical.png" class="imgMini" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                @elseif($issue->priority['name'] === 'blocker')
                                                    <img src="/img/status_icon/blocker.png" class="imgMini" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                                @endif
                                            </span>
                                                <span class="">
                                                    <span class="badge">{{date("H",$issue->original_estimate)}}</span>
                                                </span>
                                                <span class="col-md-offset-1">{{$project->key}} - {{$issue->id}}</span>
                                                <span class="col-md-offset-1">
                                                      @if($issue->assigned['image_path'] != null)
                                                        <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                                    @else
                                                        <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                @endforeach
                </ul>
            </div>
            @endforeach
            <a href="/project/{{$project->key}}/backlog" class="btn btn-success col-md-2">Back to Backlog</a>
        </div>
        </form>
    </div>
@endsection