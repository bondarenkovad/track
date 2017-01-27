@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="" action="">
                    {{ csrf_field() }}

                    {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                        {{--<label for="name" class="col-md-4 control-label">Project Name</label>--}}

                        {{--<div class="col-md-6">--}}
                            {{--<input id="name" type="text" class="form-control" name="name">--}}
                            {{--@if ($errors->has('name'))--}}
                                {{--{{session()->flash('danger',$errors->first('name'))}}--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                        {{--<label for="name" class="col-md-4 control-label">Short key</label>--}}

                        {{--<div class="col-md-6">--}}
                            {{--<input id="name" type="text" class="form-control" name="key">--}}
                            {{--@if ($errors->has('name'))--}}
                                {{--{{session()->flash('danger',$errors->first('name'))}}--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
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