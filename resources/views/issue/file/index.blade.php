@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Add Files:</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveFile', ['issue'=>$issue->id])}}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                        <label for="file" class="col-md-4 control-label">File:</label>
                        <div class="col-md-6">
                            <input type="file" name="file[]" multiple>
                            @if ($errors->has('file'))
                                {{session()->flash('danger',$errors->first('file'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Add File
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