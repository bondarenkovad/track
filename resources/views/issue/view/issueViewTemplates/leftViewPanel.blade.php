<div>
    <div class="strike">
        <span class="bolder">Details</span>
    </div>
        <dl class="dl-horizontal">
            <dt>Type:</dt>
            <dd>
                <span class="marginLeft">
                    @if($issue->type['name'] === 'task')
                        <span class="img glyphicon glyphicon-education low" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                    @elseif($issue->type['name'] === 'story')
                        <span class="img glyphicon glyphicon-file high" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                    @elseif($issue->type['name'] === 'bug')
                        <span class="img glyphicon glyphicon-fire danger" data-toggle="tooltip" title="{{$issue->type['name']}}"></span>
                    @endif
                    {{$issue->type['name']}}
                </span>
            </dd>
            <dt>Priority:</dt>
            <dd>
                <span class="marginLeft">
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
                    {{$issue->priority['name']}}
                </span>
            </dd>
            <dt>Status:</dt>
            <dd>
                <span class="marginLeft">
                    {{$issue->status["name"]}}
                </span>
            </dd>
        </dl>
    <div class="strike">
        <span class="bolder">Description</span>
    </div>
    <div style="border: 1px solid #ddd; border-radius: 4px; padding: 5px 15px">
        {!!$issue->description  !!}
    </div>
    <div>
        <div class="strike">
            <span class="bolder">Attachment</span>
        </div>
        <ul class="list-group list-inline" style="margin-left:0">
            @if($issue->getThisAttachments() != [])
                @foreach($issue->getThisAttachments() as $file)
                    <li class="list-group-item">
                        <a download href="{{$file->path}}">
                            <span class="glyphicon glyphicon-file" style="font-size: 36px; color:#eee"></span>
                        </a>
                    </li>
                @endforeach
            @else
                <li class="list-group-item">no files found</li>
            @endif
        </ul>
        <a  href="" data-toggle="modal" data-target="#issueFile" data-toggle="tooltip" title="Add Files"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></a>
    </div>
</div>