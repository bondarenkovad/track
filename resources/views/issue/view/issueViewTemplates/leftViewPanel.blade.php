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
        <a  href="" data-toggle="modal" data-target="#issueFile" data-toggle="tooltip" title="Add Files"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></a>
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
                    <div class="modal fade" id="issueCommentEdit{{$comment->id}}" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="issueCommentEditLabel" aria-hidden="true">
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
                            <h4 class="media-heading">{{$comment->name}} <span class="dataFormat">{{date("M j, Y, g:i a",strtotime($comment->created_at))}}</span>
                                @if(Auth::user()->name === $comment->name)
                                    <a data-toggle="modal" data-target="#issueCommentEdit{{$comment->id}}" class="iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
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
                    <div class="modal fade" id="issueLogEdit{{$log->id}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogEditLabel" aria-hidden="true">
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
                                    <a id="LogBtn" data-toggle="modal" data-target="#issueLogEdit{{$log->id}}" class="btn iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
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