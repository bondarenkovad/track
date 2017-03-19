@extends('layouts.app')
@section('content')
    <div class="container">
            @if($project != null)
                <h5><a href="/project/{{$project->id}}/view" style="text-decoration: none"><span class="userName">{{$project->name}}</span>/<span class="userName">{{$project->key}}</span> - <span class="userName">{{$issue->id}}</span></a></h5>
            <h3 class="text-left text-muted">{{$issue->summary}}
            <a class="btn btn-default floatR" data-toggle="modal" data-target="#issueEdit">Edit</a>
            </h3>
            <hr>
            <div class="modal fade" id="issueEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueEditLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title" id="exampleModalLabel">Edit Issue</label>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@update', ['issue'=>$issue->id, 'project'=>$project->key])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                    <label for="summary" class="col-md-12">Issue Summary</label>
                                    <div class="col-md-12">
                                        <input id="summary" type="text" class="form-control" name="summary" value="{{$issue->summary}}">
                                        @if ($errors->has('summary'))
                                            {{session()->flash('danger',$errors->first('summary'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Description:</label>
                                    <div class="col-md-12">
                                        <textarea id="description" type="text" class="form-control mytextarea" name="description">{{$issue->description}}</textarea>
                                        @if ($errors->has('description'))
                                            {{session()->flash('danger',$errors->first('description'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Status:</label>
                                    <div class="col-md-12">
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
                                    <label for="name" class="col-md-12">Project:</label>
                                    <div class="col-md-12">
                                        <input id="project_id" type="text" class="form-control" name="project_id" readonly value="{{$project->name}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Type:</label>
                                    <div class="col-md-12">
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
                                    <label for="name" class="col-md-12">Priority:</label>
                                    <div class="col-md-12">
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

                                <div class="form-group">
                                    <label for="name" class="col-md-12">Reporter:</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('assigned_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Assigned:</label>
                                    <div class="col-md-12">
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
                                    <label for="name" class="col-md-12">Original Estimate:</label>
                                        <div class="col-md-11">
                                            <input id="original_estimate" type="number" class="form-control" name="original_estimate" value="{{$issue->original_estimate}}" min="0">
                                            @if ($errors->has('original_estimate'))
                                                {{session()->flash('danger',$errors->first('original_estimate'))}}
                                            @endif
                                        </div>
                                        <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                             title="The original estimate in hours of how much work is involved resolving this issue">
                                </div>

                                <div class="form-group{{ $errors->has('remaining_estimate') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Remaining Estimate:</label>
                                        <div class="col-md-11">
                                            <input id="remaining_estimate" type="number" class="form-control" name="remaining_estimate" value="{{$issue->remaining_estimate}}" min="0">
                                            @if ($errors->has('remaining_estimate'))
                                                {{session()->flash('danger',$errors->first('remaining_estimate'))}}
                                            @endif
                                        </div>
                                        <img src="/img/status_icon/help.png" class="img img-circle" data-toggle="tooltip"
                                             title="An estimate of how much work remains until this issue will be resolved in hours">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="issueComment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueCommentLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title" id="exampleModalLabel">Comment Issue</label>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveComment', ['issue'=>$issue->id])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                    <label for="text" class="text-left" style="margin-left: 15px">Text:</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control mytextarea" name="text"></textarea>
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
            <div class="modal fade" id="issueLog" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title" id="exampleModalLabel">WorkLog Issue</label>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveWorkLog', ['issue'=>$issue->id])}}">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                                    <label for="time_spent" class="col-md-12">Time Spent:</label>
                                    <div class="col-md-12">
                                        <input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>
                                        @if ($errors->has('time_spent'))
                                            {{session()->flash('danger',$errors->first('time_spent'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-12">Status:</label>
                                    <div class="col-md-12">
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
                                    <label for="comment" class="col-md-12">Comment:</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control mytextarea" name="comment"></textarea>
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
            <div class="modal fade" id="issueFile" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueFileLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title" id="exampleModalLabel">Add Files</label>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveFile', ['issue'=>$issue->id])}}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="put"/>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                    <label for="file" class="col-md-12">Files:</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file[]" multiple>
                                        @if ($errors->has('file'))
                                            {{session()->flash('danger',$errors->first('file'))}}
                                        @endif
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Files</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="leftDivDetails">
                <div class="strike">
                    <span class="bolder">Details</span>
                </div>
                <div class="row">
                    <dl class="dl-horizontal">
                        <dt>Type:</dt>
                        <dd>
                            <span class="marginLeft">
                                @if($issue->type['name'] === 'task')
                                        <span class="img glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                @elseif($issue->type['name'] === 'story')
                                        <span class="img glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                @elseif($issue->type['name'] === 'bug')
                                        <span class="img glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                                @endif
                            {{$issue->type['name']}}
                            </span>
                        </dd>
                        <dt>Priority:</dt>
                        <dd>
                            <span class="marginLeft">
                            @if($issue->priority['name'] === 'trivial')
                                    <span class="img glyphicon glyphicon-triangle-bottom low" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                @elseif($issue->priority['name'] === 'minor')
                                    <span class="img glyphicon glyphicon-menu-down" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                @elseif($issue->priority['name'] === 'major')
                                    <span class="img glyphicon glyphicon-menu-up high" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                @elseif($issue->priority['name'] === 'critical')
                                    <span class="img glyphicon glyphicon-alert danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                                @elseif($issue->priority['name'] === 'blocker')
                                    <span class="img glyphicon glyphicon-ban-circle danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
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
                    <span class="bolder">Description</span>
                </div>
                <div style="border: 1px solid #ddd; border-radius: 4px; padding: 5px 15px">
                    {!!$issue->description  !!}
                </div>
                <div>
                    <div class="strike">
                        <span class="bolder">Attachment</span>
                    </div>
                    <ul class="list-group list-inline" style="margin-left:0">
                        @if($issue->getThisAttachments() != [])
                            @foreach($issue->getThisAttachments() as $file)
                                <li class="list-group-item">
                                    <a download href="{{$file->path}}">
                                        <span class="glyphicon glyphicon-file" style="font-size: 36px; color:#eee"></span>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item">no files found</li>
                        @endif
                    </ul>
                    <a data-toggle="modal" data-target="#issueFile" data-toggle="tooltip" title="Add Files"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></a>
                </div>
                <div class="strike">
                    <span class="bolder">Activity</span>
                </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Comments</a></li>
                        <li><a data-toggle="tab" href="#menu1">Work Logs</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            @if($issue->getThisComments() != [])
                                @foreach($issue->getThisComments() as $comment)
                                    <div class="modal fade" id="issueCommentEdit" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="issueCommentEditLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <label class="modal-title" id="exampleModalLabel">Edit Comment:</label>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@updateComment', ['comment'=>$comment->id])}}">
                                                        <input type="hidden" name="_method" value="put"/>
                                                        {{ csrf_field() }}
                                                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                                            <label for="text" class="col-md-12">Text:</label>
                                                            <div class="col-md-12">
                                                                <textarea id="text" class="form-control mytextarea" name="text">{!! $comment->text !!}</textarea>
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
                                            <h4 class="media-heading">{{$comment->name}} <span class="dataFormat">{{$comment->created_at}}</span>
                                                @if(Auth::user()->name === $comment->name)
                                                <a data-toggle="modal" data-target="#issueCommentEdit" class="iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
                                                @endif
                                            </h4>
                                            <div>
                                                {!! $comment->text !!}
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                                <br><a class="btn btn-default floatR" style="margin-bottom: 10px" data-toggle="modal" data-target="#issueComment"> Add Comment</a>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            @if($issue->getThisLogs() != [])
                                @foreach($issue->getThisLogs() as $log)
                                    <input id="timeSpent" type="hidden" name="timeSpent" value="{{$log->time_spent}}">
                                    <input id="logComment" type="hidden" name="logComment" value="{{$log->comment}}">
                                    <div class="modal fade" id="issueLogEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogEditLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <label class="modal-title" id="exampleModalLabel">Edit Work Log</label>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@updateWorkLog', ['log'=>$log->id])}}">
                                                        <input type="hidden" name="_method" value="put"/>
                                                        {{ csrf_field() }}

                                                        <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                                                            <label for="time_spent" class="col-md-12">Time Spent:</label>
                                                            <div class="col-md-12">
                                                                <input id="time_spent" type="number" class="form-control" name="time_spent" value="{{$log->time_spent}}" min="0"/>
                                                                @if ($errors->has('time_spent'))
                                                                    {{session()->flash('danger',$errors->first('time_spent'))}}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                                            <label for="name" class="col-md-12">Status:</label>
                                                            <div class="col-md-12">
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

                                                        <div class="form-group{{ $errors->has('commentLog') ? ' has-error' : '' }}">
                                                            <label for="commentLog" class="col-md-12">Comment:</label>
                                                            <div class="col-md-12">
                                                                <textarea id="commentLog" class="form-control mytextarea" name="commentLog">{!! $log->comment !!}</textarea>
                                                                @if ($errors->has('commentLog'))
                                                                    {{session()->flash('danger',$errors->first('commentLog'))}}
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
                                            <span>{{$log->id}}</span>
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
                                                    <a id="LogBtn" data-toggle="modal" data-target="#issueLogEdit" class="btn iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
                                                @endif
                                            </h4>
                                            <p><b>Time spent: {{$log->time_spent}}</b></p>
                                            <div>
                                                {!! $log->comment !!}
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                            <br>
                                <a class="btn btn-default floatR" style="margin-bottom: 10px" data-toggle="modal" data-target="#issueLog">Create Log</a>
                        </div>
                    </div>
            </div>
            <div class="rightDivPeople">
                <div class="strike">
                    <span class="bolder">People</span>
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
                        <dt>&nbsp;</dt>
                        <dd>&nbsp;</dd>
                    </dl>
                </div>
                <div class="strike">
                    <span class="bolder">Dates</span>
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
                        <dt>Original Estimate:</dt>
                        <dd>
                            <span class="marginLeft">
                                {{$issue->original_estimate}}
                            </span>
                        </dd>
                        <dt>Remaining Estimate:</dt>
                        <dd>
                             <span class="marginLeft">
                                {{$issue->remaining_estimate}}
                            </span>
                        </dd>
                        <dt>Time Spent:</dt>
                        <dd>
                            @if($issue->TimeSpentSum()!= null)
                             <span class="marginLeft">
                                {{$issue->TimeSpentSum()}}
                            </span>
                            @else
                            <span class="marginLeft">
                                0
                            </span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        @endif
    </div>
@stop