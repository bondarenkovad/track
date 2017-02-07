@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Issue Comment</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveWorkLog', ['issue'=>$issue->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}


                    <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                        <label for="time_spent" class="col-md-4 control-label">Time Spent:</label>
                        <div class="col-md-6">
                            <input id="time_spent" type="number" class="form-control" name="time_spent"/>
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

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Add Comment
                            </button>

                            <a href="/issue/index" class="btn btn-success">
                                Back to Issues List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop