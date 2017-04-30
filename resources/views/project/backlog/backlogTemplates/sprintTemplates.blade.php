<div>
    @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
        <span class="floatR" style="margin-left: 5px">
                                    <div class="dropdown pull-right">
                                        <span class="dropdown-toggle colorShade" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="glyphicon glyphicon-option-horizontal"></i>
                                            <span class="caret"></span>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            {{--<li><a href="/sprint/edit/{{$sprint->id}}/board/{{$board->id}}"><span class="colorShade">Edit Sprint</span></a></li>--}}
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
    <label>
        @if($sprint->isActive())
            <a href="/project/{{$project->key}}/board/{{$board->id}}/sprint/{{$sprint->id}}"  style="text-decoration: none">
                <span class="glyphicon glyphicon-hand-left"></span> Sprint - <span class="userName">{{$sprint->id}}</span>
            </a>
        @else
            Sprint - <span class="userName">{{$sprint->id}}</span>
        @endif
        <span>
                                         <strong>issues:{{count($sprint->getIssueForSprint())}}</strong>
                                     </span>
    </label>
    @if($project->getSprintTime($sprint->id) < 0)
        <span class="badge baDge-error floatR bWidth marginL">{{$project->getSprintTime($sprint->id)}}h</span>
    @else
        <span class="badge baDge-success floatR bWidth marginL">{{$project->getSprintTime($sprint->id)}}h</span>
    @endif
    <span class="badge baDge-warning floatR bWidth marginL">{{$project->getSprintOE($sprint->id)}}h</span>
                                    <span class="colorShade" style="font-size: 1em">
                                        <span>{{date("M j, Y, g:i a",strtotime($sprint->date_start))}} &#149</span>
                                        <span>{{date("M j, Y, g:i a",strtotime($sprint->date_finish))}}</span>
                                    </span>
    @if($sprint->order != null)
        <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]" value="{{implode(',',json_decode($sprint->order))}}">
    @else
        <input id="issueData-{{$sprint->id}}" type="hidden" name="issueData[{{$sprint->id}}]">
    @endif
    <ul id="sprint-{{$sprint->id}}" class="connectedSortable sprintContainer" data-value="{{$sprint->id}}">
        @foreach($sprint->getIssueForSprint() as $issue)
            @include('list.issueView')
        @endforeach
    </ul>
</div>