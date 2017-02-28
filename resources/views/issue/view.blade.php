@extends('layouts.app')

@section('content')
    <div class="container">
        @if($project != null)
            <h5>{{$project->name}}/{{$project->key}} - {{$issue->id}}</h5>
        @endif
        <h2 class="text-left text-muted">{{$issue->summary}}</h2>
            <div>
                @if($issue->reporter_id === Auth::user()->id)
                <a class="btn btn-default">Edit</a>
                @endif
                <a class="btn btn-default">Comment</a>
                <a class="btn btn-default">WorkLog</a>
            </div>
        <div class="row">
            <div class="leftDivDetails">
                <span>Details___________________________________________________________________________________</span>
                <div class="row">
                    <dl class="dl-horizontal">
                        <dt>Type:</dt>
                        <dd>
                            <span class="marginLeft">
                            @if($issue->type['name'] === 'task')
                                <img src="/img/status_icon/task.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                            @elseif($issue->type['name'] === 'story')
                                <img src="/img/status_icon/story.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                            @elseif($issue->type['name'] === 'bug')
                                <img src="/img/status_icon/bug.png" class="img" data-toggle="tooltip" title="{{$issue->type['name']}}">
                            @endif
                            {{$issue->type['name']}}
                            </span>
                        </dd>
                        <dt>Priority:</dt>
                        <dd>
                            <span class="marginLeft">
                            @if($issue->priority['name'] === 'trivial')
                                    <img src="/img/status_icon/trivial.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                @elseif($issue->priority['name'] === 'minor')
                                    <img src="/img/status_icon/minor.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                @elseif($issue->priority['name'] === 'major')
                                    <img src="/img/status_icon/major.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                @elseif($issue->priority['name'] === 'critical')
                                    <img src="/img/status_icon/critical.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                @elseif($issue->priority['name'] === 'blocker')
                                    <img src="/img/status_icon/blocker.png" class="img" data-toggle="tooltip" title="{{$issue->priority['name']}}">
                                @endif
                                {{$issue->priority['name']}}
                            </span>
                        </dd>
                        <dt>Status:</dt>
                        <dd>
                            <span class="marginLeft">
                                {{$issue->status["name"]}}
                            </span>
                        </dd>
                    </dl>
                </div>
                <span>Description________________________________________________________________________________</span>
                <textarea class="form-control" readonly rows="5" style="width: 300px; resize: none">{{$issue->description}}</textarea>
                <span>Attachment________________________________________________________________________________</span>
                <ul class="list-group">
                    @if($issue->getThisAttachments() != [])
                        @foreach($issue->getThisAttachments() as $file)
                            <li class="list-group-item">{{$file->path}}</li>
                        @endforeach
                    @else
                        <li class="list-group-item">no files found</li>
                    @endif
                </ul>
            </div>
            <div class="rightDivPeople">
                <span>People_________________________________________________________</span>
                <div class="row">
                    <dl class="dl-horizontal">
                        <dt>Assignee:</dt>
                        <dd>
                            <span class="marginLeft">
                            @if($issue->assigned['image_path'] != null)
                                    <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                @else
                                    <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                                @endif
                                {{$issue->assigned['name']}}
                            </span>
                        </dd>
                        <dt>Reporter:</dt>
                        <dd>
                            <span class="marginLeft">
                            @if($issue->reporter['image_path'] != null)
                                     <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                 @else
                                     <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                 @endif
                                 {{$issue->reporter['name']}}
                            </span>
                        </dd>
                    </dl>
                </div>
                <span>Dates_________________________________________________________</span>
                <div class="row">
                    <dl class="dl-horizontal">
                        <dt>Created:</dt>
                        <dd>
                            <span class="marginLeft">
                                {{$issue->created_at}}
                            </span>
                        </dd>
                        <dt>Updated:</dt>
                        <dd>
                             <span class="marginLeft">
                                {{$issue->updated_at}}
                            </span>
                        </dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
@endsection