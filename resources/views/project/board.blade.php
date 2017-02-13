@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted"><span class="title">{{$project->name}}</span> Board</h1>
        <div class="row">
            <div class="panel-body">
                <div class="form-group">
                    <label for="active" class="col-md-4 control-label">Backlog</label>
                    <div class="col-md-12">
                        <div class="row">
                            {{--<div id="left" class="form-control">--}}
                                {{--<ul id="sortable1" class="connectedSortable"  name="message">--}}
                                    {{--@foreach($board->statuses()->get() as $status)--}}
                                        {{--<li class="ui-state-default" data-value="{{$status->id}}">{{$status->name}}</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                                <ul id="sortable3" class="connectedSortable">
                                    @foreach($project->issues()->get() as $issue)
                                        <li class="ui-state-default" data-value="{{$issue->id}}">
                                             <span class="imageSpan">
                                                @if($issue->type['name'] === 'task')
                                                    <img src="/img/status_icon/task.png" class="img">
                                                @elseif($issue->type['name'] === 'story')
                                                    <img src="/img/status_icon/story.png" class="img">
                                                @elseif($issue->type['name'] === 'bug')
                                                    <img src="/img/status_icon/bug.png" class="img">
                                                @endif
                                            </span>
                                            <span class="summary">{{$issue->summary}}</span>
                                            <span class="assign">{{$issue->assigned['name']}}</span>
                                            <span class="key">{{$project->key}} - {{$issue->id}}</span>
                                            <span class="prioritySpan">
                                                 @if($issue->priority['name'] === 'trivial')
                                                    <img src="/img/status_icon/trivial.png" class="img">
                                                @elseif($issue->priority['name'] === 'minor')
                                                    <img src="/img/status_icon/minor.png" class="img">
                                                @elseif($issue->priority['name'] === 'major')
                                                    <img src="/img/status_icon/major.png" class="img">
                                                @elseif($issue->priority['name'] === 'critical')
                                                    <img src="/img/status_icon/critical.png" class="img">
                                                @elseif($issue->priority['name'] === 'blocker')
                                                    <img src="/img/status_icon/blocker.png" class="img">
                                                @endif
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                        </div>
                        <input id="statusesId" type="hidden" name="statusesId">
                    </div>
                    <div class="col-md-6 col-md-offset-4">
                        {{--<button type="submit" class="btn btn-primary" id="submitBtn">--}}
                            {{--Update--}}
                        {{--</button>--}}

                        <a href="/project/index" class="btn btn-success">
                            Back to Project List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection