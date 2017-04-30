<div class="modal fade" id="issueLog" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="issueLogLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">WorkLog</h5>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="time_spent" class="col-md-4 control-label">Time Spent:</label>
                        <div class="col-md-6">
                            <input id="time_spent" type="number" class="form-control" name="time_spent" min="0"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Status:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="status_id" name="status_id">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment" class="col-md-4 control-label">Comment:</label>
                        <div class="col-md-6">
                            <textarea id="comment" class="form-control" name="comment"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="closeBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="subBtn"   type="button" class="btn btn-primary" data-dismiss="modal">Add WorkLog</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>