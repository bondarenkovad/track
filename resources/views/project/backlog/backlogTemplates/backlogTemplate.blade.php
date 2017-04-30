<div>
    @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
        <a class="floatR" style="text-decoration: none; margin-left: 5px; cursor: hand" data-toggle="modal" data-target="#sprintCreate"><span class="glyphicon glyphicon-plus-sign"></span>Sprint</a>
    @endif
    <span class="floatLeft"><b>Backlog</b> <span class="colorShade"><b>issues: {{count($project->SortIssueByOrder())}}</b></span></span>
    @if($project->getBacklogTime() < 0)
        <span class="badge baDge-error floatR bWidth marginL">{{$project->getBacklogTime()}}h</span>
    @else
        <span class="badge baDge-success floatR bWidth marginL">{{$project->getBacklogTime()}}h</span>
    @endif
    <span class="badge baDge-warning floatR bWidth marginL">{{$project->getBacklogOE()}}h</span>
    @if($project->order != null)
        <input id="issueData-backlog" type="hidden" name="issueData[backlog]" value="{{implode(',',json_decode($project->order))}}">
    @else
        <input id="issueData-backlog" type="hidden" name="issueData[backlog]">
    @endif
    <ul id="backlog" class="connectedSortable sprintContainer" data-value="backlog">
        @foreach($project->SortIssueByOrder() as $issue)
            @include('list.issueView')
        @endforeach
    </ul>
                        <span class="floatR">
                            <a style="text-decoration: none; cursor: hand" data-toggle="modal" data-target="#projectIssueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
                        </span>
</div>