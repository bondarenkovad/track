<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <label class="modal-title" id="exampleModalLabel">Add Files</label>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveFile', ['issue'=>$issue->id])}}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put"/>
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                    <label for="file" class="col-md-12">Files:</label>
                    <div class="col-md-12">
                        <input type="file" name="file[]" multiple>
                        @if ($errors->has('file'))
                            {{session()->flash('danger',$errors->first('file'))}}
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Files</button>
                </div>
            </form>

        </div>
    </div>
</div>