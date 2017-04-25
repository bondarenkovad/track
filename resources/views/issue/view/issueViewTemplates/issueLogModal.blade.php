<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <label class="modal-title" id="exampleModalLabel">WorkLog Issue</label>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{action('IssueController@saveWorkLog', ['issue'=>$issue->id])}}">
                <input type="hidden" name="_method" value="put"/>
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('time_spent') ? ' has-error' : '' }}">
                    <label for="time_spent" class="col-md-12">Time Spent:</label>
                    <div class="col-md-12">
                        <input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>
                        @if ($errors->has('time_spent'))
                            {{session()->flash('danger',$errors->first('time_spent'))}}
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-12">Status:</label>
                    <div class="col-md-12">
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
                    <label for="comment" class="col-md-12">Comment:</label>
                    <div class="col-md-12">
                        <textarea class="form-control mytextarea" name="comment"></textarea>
                        @if ($errors->has('comment'))
                            {{session()->flash('danger',$errors->first('comment'))}}
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add WorkLog</button>
                </div>
            </form>

        </div>
    </div>
</div>