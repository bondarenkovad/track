@extends('layouts.app')
@section('content')
    <div class="container">
            @if($project != null)
                <h5><span class="userName">{{$project->name}}</span>/<span class="userName">{{$project->key}}</span> - <span class="userName">{{$issue->id}}</span></h5>
            <h3 class="text-left text-muted">{{$issue->summary}}</h3>
            <hr>
            <div>
                @if($issue->reporter_id === Auth::user()->id)
                    <a class="btn btn-default" data-toggle="modal" data-target="#issueEdit">Edit</a>
                @endif
            </div>
            <div class="modal fade" id="issueEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueEditLabel" aria-hidden="true">
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
            <div class="modal fade" id="issueComment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueCommentLabel" aria-hidden="true">
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
                                    <label for="text" class="text-left control-label" style="margin-left: 15px">Text:</label>
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
                            <h5 class="modal-title" id="exampleModalLabel">WorkLog Issue</h5>
                        </div>
                        <div class="modal-body">
                            {{--<form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveWorkLog', ['issue'=>$issue->id])}}">--}}
                                {{--<input type="hidden" name="_method" value="put"/>--}}
                                {{--{{ csrf_field() }}--}}

                                {{--<div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">--}}
                                    {{--<label for="time_spent" class="col-md-4 control-label">Time Spent:</label>--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>--}}
                                        {{--@if ($errors->has('time_spent'))--}}
                                            {{--{{session()->flash('danger',$errors->first('time_spent'))}}--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">--}}
                                    {{--<label for="name" class="col-md-4 control-label">Status:</label>--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<select class="form-control" id="status_id" name="status_id">--}}
                                            {{--@foreach($statuses as $status)--}}
                                                {{--<option value="{{$status->id}}">{{$status->name}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--@if ($errors->has('status_id'))--}}
                                            {{--{{session()->flash('danger',$errors->first('status_id'))}}--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">--}}
                                    {{--<label for="comment" class="col-md-4 control-label">Comment:</label>--}}
                                    {{--<div class="col-md-7 col-md-offset-4">--}}
                                        {{--<textarea class="form-control mytextarea" name="comment"></textarea>--}}
                                        {{--@if ($errors->has('comment'))--}}
                                            {{--{{session()->flash('danger',$errors->first('comment'))}}--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="modal-footer">--}}
                                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                    {{--<button type="submit" class="btn btn-primary">Add WorkLog</button>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                            <form class="form-horizontal" role="form" method="POST" action="http://track.you-like.org/issue/workLog/index/40">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="_token" value="9izSz3TjfrHRwV3QUbAK1wgO8eohSjNT21sxMCgQ">

                                <div class="form-group">

                                    <div class="col-md-12">
                                        <label for="time_spent" class="control-label">Time Spent:</label>
                                        <input id="time_spent" type="number" class="form-control" name="time_spent" min="0">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name" class="control-label">Status:</label>
                                        <select class="form-control" id="status_id" name="status_id">
                                            <option value="1">open</option>
                                            <option value="2">inProgress</option>
                                            <option value="3">review</option>
                                            <option value="4">testing</option>
                                            <option value="5">done</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="comment" class="control-label">Comment:</label>
                                        <div id="mceu_39" class="mce-tinymce mce-container mce-panel" hidefocus="1" tabindex="-1" role="application" style="visibility: hidden; border-width: 1px;">
                                            <div id="mceu_39-body" class="mce-container-body mce-stack-layout">
                                                <div id="mceu_40" class="mce-container mce-menubar mce-toolbar mce-stack-layout-item mce-first" role="menubar" style="border-width: 0px 0px 1px;">
                                                    <div id="mceu_40-body" class="mce-container-body mce-flow-layout">
                                                        <div id="mceu_41" class="mce-widget mce-btn mce-menubtn mce-flow-layout-item mce-first mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_41" role="menuitem" aria-haspopup="true">
                                                            <button id="mceu_41-open" role="presentation" type="button" tabindex="-1">
                                                                <span class="mce-txt">File</span>
                                                                <i class="mce-caret"></i>
                                                            </button>
                                                        </div>
                                                        <div id="mceu_42" class="mce-widget mce-btn mce-menubtn mce-flow-layout-item mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_42" role="menuitem" aria-haspopup="true">
                                                            <button id="mceu_42-open" role="presentation" type="button" tabindex="-1">
                                                                <span class="mce-txt">Edit</span>
                                                                <i class="mce-caret"></i>
                                                            </button>
                                                        </div>
                                                        <div id="mceu_43" class="mce-widget mce-btn mce-menubtn mce-flow-layout-item mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_43" role="menuitem" aria-haspopup="true">
                                                            <button id="mceu_43-open" role="presentation" type="button" tabindex="-1">
                                                                <span class="mce-txt">View</span>
                                                                <i class="mce-caret"></i>
                                                            </button></div><div id="mceu_44" class="mce-widget mce-btn mce-menubtn mce-flow-layout-item mce-last mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_44" role="menuitem" aria-haspopup="true">
                                                            <button id="mceu_44-open" role="presentation" type="button" tabindex="-1">
                                                                <span class="mce-txt">Format</span>
                                                                <i class="mce-caret"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="mceu_45" class="mce-toolbar-grp mce-container mce-panel mce-stack-layout-item" hidefocus="1" tabindex="-1" role="group">
                                                    <div id="mceu_45-body" class="mce-container-body mce-stack-layout">
                                                        <div id="mceu_46" class="mce-container mce-toolbar mce-stack-layout-item mce-first mce-last" role="toolbar">
                                                            <div id="mceu_46-body" class="mce-container-body mce-flow-layout">
                                                                <div id="mceu_47" class="mce-container mce-flow-layout-item mce-first mce-btn-group" role="group">
                                                                    <div id="mceu_47-body">
                                                                        <div id="mceu_28" class="mce-widget mce-btn mce-first mce-disabled" tabindex="-1" aria-labelledby="mceu_28" role="button" aria-label="Undo" aria-disabled="true">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-undo"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_29" class="mce-widget mce-btn mce-last mce-disabled" tabindex="-1" aria-labelledby="mceu_29" role="button" aria-label="Redo" aria-disabled="true">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-redo"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="mceu_48" class="mce-container mce-flow-layout-item mce-btn-group" role="group">
                                                                    <div id="mceu_48-body">
                                                                        <div id="mceu_30" class="mce-widget mce-btn mce-menubtn mce-first mce-last mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_30" role="button" aria-haspopup="true">
                                                                            <button id="mceu_30-open" role="presentation" type="button" tabindex="-1">
                                                                                <span class="mce-txt">Formats</span>
                                                                                <i class="mce-caret"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="mceu_49" class="mce-container mce-flow-layout-item mce-btn-group" role="group">
                                                                    <div id="mceu_49-body">
                                                                        <div id="mceu_31" class="mce-widget mce-btn mce-first" tabindex="-1" aria-labelledby="mceu_31" role="button" aria-label="Bold">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-bold"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_32" class="mce-widget mce-btn mce-last" tabindex="-1" aria-labelledby="mceu_32" role="button" aria-label="Italic">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-italic"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="mceu_50" class="mce-container mce-flow-layout-item mce-btn-group" role="group">
                                                                    <div id="mceu_50-body">
                                                                        <div id="mceu_33" class="mce-widget mce-btn mce-first" tabindex="-1" aria-labelledby="mceu_33" role="button" aria-label="Align left">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-alignleft"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_34" class="mce-widget mce-btn" tabindex="-1" aria-labelledby="mceu_34" role="button" aria-label="Align center">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-aligncenter"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_35" class="mce-widget mce-btn" tabindex="-1" aria-labelledby="mceu_35" role="button" aria-label="Align right">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-alignright"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_36" class="mce-widget mce-btn mce-last" tabindex="-1" aria-labelledby="mceu_36" role="button" aria-label="Justify">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-alignjustify"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="mceu_51" class="mce-container mce-flow-layout-item mce-btn-group" role="group">
                                                                    <div id="mceu_51-body">
                                                                        <div id="mceu_37" class="mce-widget mce-btn mce-first" tabindex="-1" aria-labelledby="mceu_37" role="button" aria-label="Decrease indent">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-outdent"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div id="mceu_38" class="mce-widget mce-btn mce-last" tabindex="-1" aria-labelledby="mceu_38" role="button" aria-label="Increase indent">
                                                                            <button role="presentation" type="button" tabindex="-1">
                                                                                <i class="mce-ico mce-i-indent"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="mceu_52" class="mce-container mce-flow-layout-item mce-last mce-btn-group" role="group">
                                                                    <div id="mceu_52-body">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="mceu_53" class="mce-edit-area mce-container mce-panel mce-stack-layout-item" hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;">
                                                    <iframe id="comment_ifr" frameborder="0" allowtransparency="true" title="Rich Text Area. Press ALT-F9 for menu. Press ALT-F10 for toolbar. Press ALT-0 for help" src='javascript:""' style="width: 100%; height: 100px; display: block;"></iframe>
                                                </div>
                                                <div id="mceu_54" class="mce-statusbar mce-container mce-panel mce-stack-layout-item mce-last" hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;">
                                                    <div id="mceu_54-body" class="mce-container-body mce-flow-layout"><div id="mceu_55" class="mce-path mce-flow-layout-item mce-first mce-last">
                                                            <div role="button" class="mce-path-item mce-last" data-index="0" tabindex="-1" id="mceu_55-0" aria-level="1">
                                                                p
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea class=" mytextarea" name="comment" id="comment" aria-hidden="true" style="display: none;"></textarea>
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
                <textarea class="form-control" readonly rows="5" style="resize: none">{{$issue->description}}</textarea>
                <div class="strike">
                    <span class="bolder">Attachment</span>
                </div>
                <ul class="list-group">
                    @if($issue->getThisAttachments() != [])
                        @foreach($issue->getThisAttachments() as $file)
                            <li class="list-group-item"><a download href="{{$file->path}}">{{$file->path}}</a></li>
                        @endforeach
                    @else
                        <li class="list-group-item">no files found</li>
                    @endif
                </ul>
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
                                            <h4 class="media-heading">{{$comment->name}} <span class="dataFormat">{{$comment->created_at}}</span>
                                                @if(Auth::user()->name === $comment->name)
                                                <a data-toggle="modal" data-target="#issueCommentEdit" class="iconBlock"><i class="glyphicon glyphicon-pencil"></i></a>
                                                @endif
                                            </h4>
                                            <p>{{$comment->text}}</p>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                                <a class="btn btn-default floatR" style="margin-bottom: 10px" data-toggle="modal" data-target="#issueComment">Comment</a>
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
                                <a class="btn btn-default floatR" style="margin-bottom: 10px" data-toggle="modal" data-target="#issueLog">Create Log</a>
                            @endif
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
                             <span class="marginLeft">
                                {{$issue->TimeSpentSum()}}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
        @endif
    </div>
@stop