@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Type Edit</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('IssueTypeController@update', ['issueType'=>$issueType->id])}}">
                    <input type="hidden" name="_method" value="put"/>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Issue Type Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{$issueType->name}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                               Update
                            </button>
                            <a href="/issue/type/index" class="btn btn-success">
                                Back To Issue Type List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection