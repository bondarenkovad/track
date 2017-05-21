<div class="container-fluid">
    <div class="row ui-state-default" data-value="{{$issue->id}}">
        <div class="col-lg-2 col-sm-2 col-xs-12">
            @if($issue->type['name'] === 'task')
                <span class="img glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
            @elseif($issue->type['name'] === 'story')
                <span class="img glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
            @elseif($issue->type['name'] === 'bug')
                <span class="img glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
            @endif
            <span class="badge">{{$project->key}} - {{$issue->id}}</span>
        </div>
        <div class="col-lg-2 col-sm-10 col-xs-12">
            <div class="summary"><strong>{{$issue->summary}}</strong></div>
        </div>
        <div class="col-lg-4 col-sm-12 col-xs-12">
            <div class="description">{!! strip_tags($issue->description, '<a><b><strong>') !!}</div>
        </div>
        <div class="col-lg-2 col-sm-6 col-xs-12">
            <span class="assign">
                R:
                @if($issue->reporter['image_path'] != null)
                    <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none"><img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}"></a>
                @else
                    <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none"><img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}"></a>
                @endif
                A:
                @if($issue->assigned['image_path'] != null)
                    <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
                @else
                    <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
                @endif
            </span>
            <span>
                @if($issue->priority['name'] === 'trivial')
                    <span class="img glyphicon glyphicon-triangle-bottom low" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                @elseif($issue->priority['name'] === 'minor')
                    <span class="img glyphicon glyphicon-menu-down" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                @elseif($issue->priority['name'] === 'major')
                    <span class="img glyphicon glyphicon-menu-up high" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                @elseif($issue->priority['name'] === 'critical')
                    <span class="img glyphicon glyphicon-alert danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                @elseif($issue->priority['name'] === 'blocker')
                    <span class="img glyphicon glyphicon-ban-circle danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
                @endif
            </span>
        </div>
        <div class="col-lg-2 col-sm-6 col-xs-12">
            <span class="pull-left">
                <span class="badge">{{$issue->calcRE()}}h</span>
                <span>
                    @if($issue->status['name'] === 'open')
                        <span class="baDge baDge-warning">{{$issue->status['name']}}</span>
                    @elseif($issue->status['name'] === 'inProgress')
                        <span class="baDge baDge-info">{{$issue->status['name']}}</span>
                    @elseif($issue->status['name'] === 'review')
                        <span class="baDge baDge-inverse">{{$issue->status['name']}}</span>
                    @elseif($issue->status['name'] === 'testing')
                        <span class="baDge baDge-error">{{$issue->status['name']}}</span>
                    @elseif($issue->status['name'] === 'done')
                        <span class="baDge baDge-success">{{$issue->status['name']}}</span>
                    @endif
                </span>
            </span>
            <span class="pull-right">
                <a href="/project/{{$project->key}}/issue/{{$issue->id}}/view">View</a>
            </span>
        </div>
    </div>
</div>
