@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted"><span class="title">{{$project->name}}</span> Board</h1>
        <div class="row">
            <div class="panel-body">
                <div class="form-group">
                    <label for="active" class="col-md-4 control-label">Issues:</label>
                    <div class="col-md-12">
                        <div class="row">
                            {{--<div id="left" class="form-control">--}}
                                {{--<ul id="sortable1" class="connectedSortable"  name="message">--}}
                                    {{--@foreach($board->statuses()->get() as $status)--}}
                                        {{--<li class="ui-state-default" data-value="{{$status->id}}">{{$status->name}}</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            <div>
                                <ul id="sortable3" class="connectedSortable">
                                    @foreach($project->issues()->get() as $issue)
                                        <li class="ui-state-default" data-value="{{$issue->id}}">{{$issue->summary}}</li>
                                    @endforeach
                                </ul>
                            </div>
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