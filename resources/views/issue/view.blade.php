@extends('layouts.app')

@section('content')
    <div class="container">
        @if($project != null)
            <h5>{{$project->name}}/{{$project->key}} - {{$issue->id}}</h5>
        @endif
        <h2 class="text-left text-muted">{{$issue->summary}}</h2>
            <div>
                @if($issue->reporter_id === Auth::user()->id)
                <a class="btn btn-default" data-toggle="modal" data-target="#issueEdit">Edit</a>
                @endif
                <a class="btn btn-default" data-toggle="modal" data-target="#issueComment">Comment</a>
                <a class="btn btn-default" data-toggle="modal" data-target="#issueLog">WorkLog</a>
            </div>
        <div class="row">
            <div class="modal fade" id="issueEdit" tabindex="-1" role="dialog" aria-labelledby="issueEditLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Issue</h5>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@update', ['issue'=>$issue->id, 'project'=>$project->key])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                    <label for="summary" class="col-md-4 control-label">Issue Summary</label>
                                    <div class="col-md-6">
                                        <input id="summary" type="text" class="form-control" name="summary" value="{{$issue->summary}}">
                                        @if ($errors->has('summary'))
                                            {{session()->flash('danger',$errors->first('summary'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Description</label>
                                    <div class="col-md-6">
                                        <textarea id="description" type="text" class="form-control" name="description" style="resize: none">{{$issue->description}}</textarea>
                                        @if ($errors->has('description'))
                                            {{session()->flash('danger',$errors->first('description'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Status:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="status_id" name="status_id" value="{{$issue->status_id}}">
                                            @foreach($statuses as $status)
                                                <option value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('status_id'))
                                            {{session()->flash('danger',$errors->first('status_id'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Project:</label>
                                    <div class="col-md-6">
                                        <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Type:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="type_id">
                                            @foreach($types as $type)
                                                @if($issue->type['name'] === $type->name)
                                                    <option selected value="{{$type->id}}">{{$type->name}}</option>
                                                @else
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type_id'))
                                            {{session()->flash('danger',$errors->first('type_id'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('priority_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Priority:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="priority_id" name="priority_id">
                                            @foreach($priorities as $priority)
                                                @if($issue->priority['name'] === $priority->name)
                                                    <option selected value="{{$priority->id}}">{{$priority->name}}</option>
                                                @else
                                                    <option value="{{$priority->id}}">{{$priority->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('priority_id'))
                                            {{session()->flash('danger',$errors->first('priority_id'))}}
                                        @endif
                                    </div>
                                </div>

                                {{--<div class="form-group{{ $errors->has('reporter_id') ? ' has-error' : '' }}">--}}
                                    {{--<label for="name" class="col-md-4 control-label">Reporter:</label>--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<select class="form-control" id="reporter_id" name="reporter_id">--}}
                                            {{--@foreach($users as $user)--}}
                                                {{--@if($issue->reporter['name'] === $user->name)--}}
                                                    {{--<option selected value="{{$user->id}}">{{$user->name}}</option>--}}
                                                {{--@else--}}
                                                    {{--<option value="{{$user->id}}">{{$user->name}}</option>--}}
                                                {{--@endif--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--@if ($errors->has('reporter_id'))--}}
                                            {{--{{session()->flash('danger',$errors->first('reporter_id'))}}--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Reporter:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('assigned_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Assigned:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="assigned_id" name="assigned_id">
                                            @foreach($users as $user)
                                                @if($issue->assigned['name'] === $user->name)
                                                    <option selected value="{{$user->id}}">{{$user->name}}</option>
                                                @else
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('assigned_id'))
                                            {{session()->flash('danger',$errors->first('assigned_id'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('original_estimate') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Original Estimate:</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input id="original_estimate" type="number" class="form-control" name="original_estimate" value="{{date("H",$issue->original_estimate)}}" min="0">
                                            @if ($errors->has('original_estimate'))
                                                {{session()->flash('danger',$errors->first('original_estimate'))}}
                                            @endif
                                        </div>
                                        <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                             title="The original estimate in hours of how much work is involved resolving this issue">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('remaining_estimate') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Remaining Estimate:</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input id="remaining_estimate" type="number" class="form-control" name="remaining_estimate" value="{{date("H",$issue->remaining_estimate)}}" min="0">
                                            @if ($errors->has('remaining_estimate'))
                                                {{session()->flash('danger',$errors->first('remaining_estimate'))}}
                                            @endif
                                        </div>
                                        <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                             title="An estimate of how much work remains until this issue will be resolved in hours">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<div class="col-md-6 col-md-offset-4">--}}
                                       {{----}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </form>
                            {{--<form>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="recipient-name" class="form-control-label">Recipient:</label>--}}
                                    {{--<input type="text" class="form-control" id="recipient-name">--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="message-text" class="form-control-label">Message:</label>--}}
                                    {{--<textarea class="form-control" id="message-text"></textarea>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="issueComment" tabindex="-1" role="dialog" aria-labelledby="issueCommentLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Comment Issue</h5>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveComment', ['issue'=>$issue->id])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                    <label for="text" class="col-md-4 control-label">Text:</label>
                                    <div class="col-md-6">
                                        <textarea id="text" type="text" class="form-control" name="text"></textarea>
                                        @if ($errors->has('text'))
                                            {{session()->flash('danger',$errors->first('tex'))}}
                                        @endif
                                    </div>
                                </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Comment</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="issueLog" tabindex="-1" role="dialog" aria-labelledby="issueLogLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">WorkLog Issue</h5>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveWorkLog', ['issue'=>$issue->id])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}


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
                                        <textarea id="comment" type="text" class="form-control" name="comment"></textarea>
                                        @if ($errors->has('comment'))
                                            {{session()->flash('danger',$errors->first('comment'))}}
                                        @endif
                                    </div>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add WorkLog</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="leftDivDetails">
                <div class="strike">
                    <span>Details</span>
                </div>
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
                <div class="strike">
                    <span>Description</span>
                </div>
                <textarea class="form-control" readonly rows="5" style="width: 300px; resize: none">{{$issue->description}}</textarea>
                <div class="strike">
                    <span>Attachment</span>
                </div>
                <ul class="list-group">
                    @if($issue->getThisAttachments() != [])
                        @foreach($issue->getThisAttachments() as $file)
                            <li class="list-group-item">{{$file->path}}</li>
                        @endforeach
                    @else
                        <li class="list-group-item">no files found</li>
                    @endif
                </ul>
                <div class="strike">
                    <span>Activity</span>
                </div>
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Comments</a></li>
                        <li><a data-toggle="tab" href="#menu1">Work Logs</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            @if($issue->getThisComments() != [])
                                @foreach($issue->getThisComments() as $comment)
                                    <div class="modal fade" id="issueCommentEdit" tabindex="-1" role="dialog" aria-labelledby="issueCommentEditLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Comment Issue</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@updateComment', ['comment'=>$comment->id])}}">
                                                        <input type="hidden" name="_method" value="put"/>
                                                        {{ csrf_field() }}
                                                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                                            <label for="text" class="col-md-4 control-label">Text:</label>
                                                            <div class="col-md-6">
                                                                <textarea id="text" type="text" class="form-control" name="text">{{$comment->text}}</textarea>
                                                                @if ($errors->has('text'))
                                                                    {{session()->flash('danger',$errors->first('tex'))}}
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Comment</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                                @if($comment->image_path != null)
                                                    <img src="{{$comment->image_path}}" class="img img-circle imgBlock" data-toggle="tooltip" title="{{$comment->name}}">
                                                @else
                                                    <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$comment->name}}">
                                                @endif
                                            </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{$comment->name}}
                                                @if(Auth::user()->name === $comment->name)
                                                <a data-toggle="modal" data-target="#issueCommentEdit" class="btn iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
                                                @endif
                                            </h4>
                                            <p>{{$comment->text}}</p>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            @if($issue->getThisLogs() != [])
                                @foreach($issue->getThisLogs() as $log)
                                    <div class="modal fade" id="issueLogEdit" tabindex="-1" role="dialog" aria-labelledby="issueLogEditLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Work Log</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@updateWorkLog', ['log'=>$log->id])}}">
                                                        <input type="hidden" name="_method" value="put"/>
                                                        {{ csrf_field() }}

                                                        <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                                                            <label for="time_spent" class="col-md-4 control-label">Time Spent:</label>
                                                            <div class="col-md-6">
                                                                <input id="time_spent" type="number" class="form-control" name="time_spent" value="{{$log->time_spent}}" min="0"/>
                                                                @if ($errors->has('time_spent'))
                                                                    {{session()->flash('danger',$errors->first('time_spent'))}}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                                            <label for="name" class="col-md-4 control-label">Status:</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control" name="status_id">
                                                                    @foreach($statuses as $status)
                                                                        @if($log->status === $status->name)
                                                                            <option selected value="{{$status->id}}">{{$status->name}}</option>
                                                                        @else
                                                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                                                        @endif
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
                                                                <textarea id="comment" type="text" class="form-control" name="comment">{{$log->comment}}</textarea>
                                                                @if ($errors->has('comment'))
                                                                    {{session()->flash('danger',$errors->first('comment'))}}
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Work Log</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            @if($log->image_path != null)
                                                <img src="{{$log->image_path}}" class="img img-circle" data-toggle="tooltip" title="{{$log->user}}">
                                            @else
                                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$log->user}}">
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                {{$log->user}}
                                                @if(Auth::user()->name === $log->user)
                                                    <a data-toggle="modal" data-target="#issueLogEdit" class="btn iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
                                                @endif
                                            </h4>
                                            <p><b>Time spent: {{$log->time_spent}}</b></p>
                                            <p>{{$log->comment}}</p>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightDivPeople">
                <div class="strike">
                    <span>People</span>
                </div>
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
                <div class="strike">
                    <span>Dates</span>
                </div>
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