<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <label class="modal-title" id="exampleModalLabel">Comment Issue</label>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveComment', ['issue'=>$issue->id])}}">
                <input type="hidden" name="_method" value="put"/>
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                    <label for="text" class="text-left" style="margin-left: 15px">Text:</label>
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