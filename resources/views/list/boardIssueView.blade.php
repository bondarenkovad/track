<li id="{{$issue->id}}" class="ui-state-default" data-value="{{$issue->id}}">
    <div class="container-fluid">
        <div class="row">
        <span class="sprintSummary">
        {{$issue->summary}}
        <a  href="/project/{{$project->key}}/issue/{{$issue->id}}/view" class="floatR glyphicon glyphicon-eye-open" style="margin-right: 5px"></a>
        </span>
        <span class="sprintDescription">{!! strip_tags($issue->description, '<a><b><strong>') !!}</span>
        </div>
        <div class="row">
        <div style="margin-bottom: 5px">
        <span style="margin-left: 5px">
        <span>
        @if($issue->type['name'] === 'task')
        <span class="imgMini glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
        @elseif($issue->type['name'] === 'story')
        <span class="imgMini glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
        @elseif($issue->type['name'] === 'bug')
        <span class="imgMini glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
        @endif
        </span>
        <span>
        @if($issue->priority['name'] === 'trivial')
        <span class="imgMini glyphicon glyphicon-triangle-bottom low" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
        @elseif($issue->priority['name'] === 'minor')
        <span class="imgMini glyphicon glyphicon-menu-down" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
        @elseif($issue->priority['name'] === 'major')
        <span class="imgMini glyphicon glyphicon-menu-up high" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
        @elseif($issue->priority['name'] === 'critical')
        <span class="imgMini glyphicon glyphicon-alert danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
        @elseif($issue->priority['name'] === 'blocker')
        <span class="imgMini glyphicon glyphicon-ban-circle danger" data-toggle="tooltip" title="{{$issue->priority['name']}}"></span>
        @endif
        </span>
        <span>
        <span class="badge bWidth">{{$issue->remaining_estimate}}h</span>
        </span>
        <span>
        @if($issue->status['name'] === 'open')
        <span class="baDge" style=" background-color: #f89406">{{$issue->status['name']}}</span>
        @elseif($issue->status['name'] === 'inProgress')
        <span class="baDge" style="background-color: #3a87ad">{{$issue->status['name']}}</span>
        @elseif($issue->status['name'] === 'review')
        <span class="baDge" style="background-color: #1a1a1a">{{$issue->status['name']}}</span>
        @elseif($issue->status['name'] === 'testing')
        <span class="baDge" style="background-color: #953b39">{{$issue->status['name']}}</span>
        @elseif($issue->status['name'] === 'done')
        <span class="baDge" style="background-color: #468847">{{$issue->status['name']}}</span>
        @endif
        </span>
        </span>
        <span style="margin-left: 10px;">{{$project->key}} - <span class="userName">{{$issue->id}}</span></span>
        <span style="float: right; margin-right: 5px">
        @if($issue->assigned['image_path'] != null)
        <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
        @else
        <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none"><img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}"></a>
        @endif
        </span>
        </div>
        </div>
    </div>
</li>