@extends('layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{action('ProjectController@updateSprint', ['key'=> $project->key, 'i'=>$board->id, 'id'=>$sprint->id])}}">
            <input type="hidden" name="_method" value="put"/>
            {{ csrf_field() }}
        <h4 class="text-left text-muted">Sprint -<span class="userName"> {{$sprint->id}}</span></h4>
            <input id="projectKey" type="hidden" name="projectKey" value="{{$project->key}}">
            <input id="sprintId" type="hidden" name="sprintId" value="{{$sprint->id}}">
            <input id="boardId" type="hidden" name="boardId" value="{{$board->id}}">
            <div class="modal fade" id="issueLog" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">WorkLog</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label for="time_spent" class="col-md-4 control-label">Time Spent:</label>
                                    <div class="col-md-6">
                                        <input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Status:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="status_id" name="status_id">
                                            @foreach($statuses as $status)
                                                <option value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="comment" class="col-md-4 control-label">Comment:</label>
                                    <div class="col-md-6">
                                        <textarea id="comment" class="form-control" name="comment"></textarea>
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
            <div class="statusBlock">
                @foreach($board->statuses()->get() as $status)
                    <div class="statusContainer" style="width:{{$board-> widthSizing()}}%;">
                        <h3 class="text-center">{{$status->name}}</h3>
                        <hr>
                        <ul id="issueContainer_{{$status->id}}" class="issueContainer connectedIssueSortable" data-value="{{$status->id}}">
                            @foreach($sprint->getIssueByStatus($status->id) as $issue)
                                <li id="{{$issue->id}}" class="ui-state-default" data-value="{{$issue->id}}">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <span class="sprintSummary">
                                                {{$issue->summary}}
                                            <a  href="/project/{{$project->key}}/issue/{{$issue->id}}/view" class="floatR glyphicon glyphicon-eye-open" style="margin-right: 5px"></a>
                                            </span>
                                            <span class="sprintDescription">{!! strip_tags($issue->description, '<a><b><strong>') !!}</span>
                                        </div>
                                        <div class="row">
                                            <div style="margin-bottom: 5px">
                                                 <span style="margin-left: 5px">
                                                     <span>
                                                    @if($issue->type['name'] === 'task')
                                                             <span class="imgMini glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                                         @elseif($issue->type['name'] === 'story')
                                                             <span class="imgMini glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                                         @elseif($issue->type['name'] === 'bug')
                                                             <span class="imgMini glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                                         @endif
                                                </span>
                                                    <span>
                                                      @if($issue->priority['name'] === 'trivial')
                                                            <span class="imgMini glyphicon glyphicon-triangle-bottom low" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                                        @elseif($issue->priority['name'] === 'minor')
                                                            <span class="imgMini glyphicon glyphicon-menu-down" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                                        @elseif($issue->priority['name'] === 'major')
                                                            <span class="imgMini glyphicon glyphicon-menu-up high" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                                        @elseif($issue->priority['name'] === 'critical')
                                                            <span class="imgMini glyphicon glyphicon-alert danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                                        @elseif($issue->priority['name'] === 'blocker')
                                                            <span class="imgMini glyphicon glyphicon-ban-circle danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                                        @endif
                                                </span>
                                                    <span>
                                                        <span class="badge bWidth">{{$issue->remaining_estimate}}h</span>
                                                    </span>
                                                   <span>
                                                        @if($issue->status['name'] === 'open')
                                                           <span class="baDge" style=" background-color: #f89406">{{$issue->status['name']}}</span>
                                                       @elseif($issue->status['name'] === 'inProgress')
                                                           <span class="baDge" style="background-color: #3a87ad">{{$issue->status['name']}}</span>
                                                       @elseif($issue->status['name'] === 'review')
                                                           <span class="baDge" style="background-color: #1a1a1a">{{$issue->status['name']}}</span>
                                                       @elseif($issue->status['name'] === 'testing')
                                                           <span class="baDge" style="background-color: #953b39">{{$issue->status['name']}}</span>
                                                       @elseif($issue->status['name'] === 'done')
                                                           <span class="baDge" style="background-color: #468847">{{$issue->status['name']}}</span>
                                                       @endif
                                                    </span>
                                               </span>
                                                <span style="margin-left: 10px;">{{$project->key}} - <span class="userName">{{$issue->id}}</span></span>
                                                <span style="margin-left: 15px; float: right; margin-right: 5px">
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
@stop