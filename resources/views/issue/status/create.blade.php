@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-muted">Status Create</h1>
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/issue/status/create">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Status Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name">
                            @if ($errors->has('name'))
                                {{session()->flash('danger',$errors->first('name'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>

                            <a href="/issue/status/index" class="btn btn-success">
                                Back to Issue Statuses List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop