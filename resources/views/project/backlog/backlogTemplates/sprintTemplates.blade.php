<div>
    <div class="row">
        <div class="col-lg-2 col-sm-3 col-xs-6 ">
            <label>
                @if($sprint->isActive())
                    <a href="/project/{{$project->key}}/board/{{$board->id}}/sprint/{{$sprint->id}}"  style="text-decoration: none">
                        <span class="glyphicon glyphicon-hand-left"></span> Sprint - <span class="userName">{{$sprint->id}}</span>
                    </a>
                @else
                    Sprint - <span class="userName">{{$sprint->id}}</span>
                @endif
                <span class="colorShade">issues:{{count($sprint->getIssueForSprint())}}</span>
            </label>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12 ">
             <span class="colorShade" style="font-size: 1em">
                <span>{{date("M j, Y, g:i a",strtotime($sprint->date_start))}} &#149</span>
                <span>{{date("M j, Y, g:i a",strtotime($sprint->date_finish))}}</span>
            </span>
        </div>
        <div class="col-lg-4 col-sm-3 col-xs-6  pull-right">
            @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
                <span class="pull-right marginL">
            <div class="dropdown pull-right">
                <span class="dropdown-toggle colorShade" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                    <span class="caret"></span>
                </span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a data-toggle="modal" data-target="#sprintEdit" data-content="{{$sprint->id}}" style="cursor: hand" ><span class="colorShade">Edit Sprint</span></a></li>
                    <li><a href="/sprint/delete/{{$sprint->id}}"><span class="colorShade">Delete Sprint</span></a></li>
                    @if($sprint->status == 2)
                        <li><a href="/sprint/{{$sprint->id}}/makeFinish"><span class="colorShade">Finish Sprint</span></a></li>
                    @else
                        <li><a href="/sprint/{{$sprint->id}}/makeActive"><span class="colorShade">Start Sprint</span></a></li>
                    @endif
                </ul>
            </div>
        </span>
            @endif
            @if($project->getSprintTime($sprint->id) < 0)
                <span class="badge baDge-error marginL pull-right">{{$project->getSprintTime($sprint->id)}}h</span>
            @else
                <span class="badge baDge-success marginL pull-right">{{$project->getSprintTime($sprint->id)}}h</span>
            @endif
            <span class="badge baDge-warning  marginL pull-right">{{$project->getSprintOE($sprint->id)}}h</span>
        </div>
        @if($sprint->order != null)
            <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]" value="{{implode(',',json_decode($sprint->order))}}">
        @else
            <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]">
        @endif
    </div>
    <div id="sprint-{{$sprint->id}}" class="connectedSortable sprintContainer" data-value="{{$sprint->id}}">
        @foreach($sprint->getIssueForSprint() as $issue)
            @include('list.issueView')
        @endforeach
    </div>
</div>