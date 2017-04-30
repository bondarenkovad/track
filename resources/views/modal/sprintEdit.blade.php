<div class="modal fade" id="sprintEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="sprintEdit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Edit Sprint</label>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{action('SprintController@modalEdit', ['id'=>14])}}">
                    <input type="hidden" name="_method" value="put"/>
                    <input id="sprintId" type="hidden" name="sprintId" value="">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('sprintName') ? ' has-error' : '' }}">
                        <label for="sprintName" class="col-md-12">Sprint Name</label>
                        <div class="col-md-12">
                            <input id="sprintName" type="text" class="form-control" name="sprintName" value="">
                            @if ($errors->has('sprintName'))
                                {{session()->flash('danger',$errors->first('sprintName'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-12">Description</label>
                        <div class="col-md-12">
                            <textarea id="description" class="form-control mytextarea" name="description"></textarea>
                            @if ($errors->has('description'))
                                {{session()->flash('danger',$errors->first('description'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status" class="col-md-12">Status</label>
                        <div class="col-md-12">
                            <label id="sprintStatus" class="radio-inline"><input type="radio" name="status" value="1">toDo</label>
                            <label id="sprintStatus" class="radio-inline"><input type="radio" name="status" value="2">active</label>
                            <label id="sprintStatus" class="radio-inline"><input type="radio" name="status" value="3">finish</label>
                            @if ($errors->has('status'))
                                {{session()->flash('danger',$errors->first('status'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project_id" class="col-md-12">Projects:</label>
                        <div class="col-md-12">
                            <input id="sprintProject" type="text" class="form-control" readonly name="project_id" value="">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                        <label for="date_start" class="col-md-12">Date start:</label>
                        <div class="col-md-12">
                            <input id="sprintDate_start" type="datetime" class="form-control" name="date_start">
                            @if ($errors->has('date_start'))
                                {{session()->flash('danger',$errors->first('date_start'))}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('date_finish') ? ' has-error' : '' }}">
                        <label for="date_finish" class="col-md-12">Date finish:</label>
                        <div class="col-md-12">
                            <input id="sprintDate_finish" type="datetime" class="form-control" name="date_finish">
                            @if ($errors->has('date_finish'))
                                {{session()->flash('danger',$errors->first('date_finish'))}}
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Sprint</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>