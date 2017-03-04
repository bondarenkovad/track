@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@updateSprint', ['key'=> $project->key, 'i'=>$board->id, 'id'=>$sprint->id])}}">
            <input type="hidden" name="_method" value="put"/>
            {{ csrf_field() }}
        <h3 class="text-left text-muted">Sprint <span class="title">{{$sprint->id}}</span></h3>
        <div class="row">
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="sprintId" type="hidden" name="sprintId" value="{{$sprint->id}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
            @foreach($board->statuses()->get() as $status)
            <div class="statusContainer" style="width: {{$board-> widthSizing()}}">
                <h3 class="text-center">{{$status->name}}</h3>
                <hr>
                <ul id="issueContainer_{{$status->id}}" class="issueContainer connectedIssueSortable" data-value="{{$status->id}}">
                @foreach($sprint->getIssueByStatus($status->id) as $issue)
                        <div class="modal fade" id="issueLog" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogLabel" aria-hidden="true">
                            <input id="issueId" type="hidden" name="issueId" value="{{$issue->id}}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">WorkLog</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-horizontal">

                                            <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                                                <label for="time_spent" class="col-md-4 control-label">Time Spent:</label>
                                                <div class="col-md-6">
                                                    <input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>
                                                    @if ($errors->has('time_spent'))
                                                        {{session()->flash('danger',$errors->first('time_spent'))}}
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                                <label for="name" class="col-md-4 control-label">Status:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="status_id" name="status_id">
                                                        @foreach($statuses as $status)
                                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('status_id'))
                                                        {{session()->flash('danger',$errors->first('status_id'))}}
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                                <label for="comment" class="col-md-4 control-label">Comment:</label>
                                                <div class="col-md-6">
                                                    <textarea id="comment" class="form-control" name="comment"></textarea>
                                                    @if ($errors->has('comment'))
                                                        {{session()->flash('danger',$errors->first('comment'))}}
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="closeBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button id="subBtn"   type="button" class="btn btn-primary" data-dismiss="modal">Add WorkLog</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                <li id="{{$issue->id}}" class="ui-state-default" data-value="{{$issue->id}}">
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
        </div>
        </form>
    </div>
@endsection