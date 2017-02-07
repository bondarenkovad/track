@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Edit Comment</h1>
        <div class="row">
            <div class="panel-body">
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

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Edit Comment
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