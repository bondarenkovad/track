<div class="container-fluid">
    <div class="row ui-state-default">
        <div class="col-lg-4 col-sm-2 col-xs-12">
            <strong>{{$board->name}}</strong>
        </div>
        <div class="col-lg-4 col-sm-3 col-xs-12">
            <span>{{$board->project['name']}}</span>
        </div>
        <div class="col-lg-3 col-sm-5 col-xs-12">
            @foreach($board->orderByOrders() as $status)
                <span>
            @if($status->name === 'open')
                        <span class="baDge baDge-warning">{{$status->name}}</span>
                    @elseif($status->name === 'inProgress')
                        <span class="baDge baDge-info">{{$status->name}}</span>
                    @elseif($status->name === 'review')
                        <span class="baDge baDge-inverse">{{$status->name}}</span>
                    @elseif($status->name === 'testing')
                        <span class="baDge baDge-error">{{$status->name}}</span>
                    @elseif($status->name === 'done')
                        <span class="baDge baDge-success">{{$status->name}}</span>
                    @endif
            </span>
            @endforeach
        </div>
        <div class="col-lg-1 col-sm-2 col-xs-12">
            <div class="pull-right">
                <a  href="/board/edit/{{$board->id}}">
                    <i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i>
                </a>
                <a  href="/board/delete/{{$board->id}}">
                    <i class="glyphicon glyphicon-remove danger" data-toggle="tooltip" title="Delete"></i>
                </a>
            </div>
        </div>
    </div>
</div>