<div>
    @if(Auth::user()->ifAdmin() || Auth::user()->ifPM())
        <a class="pull-right marginL" style="text-decoration: none; cursor: hand" data-toggle="modal" data-target="#sprintCreate"><span class="glyphicon glyphicon-plus-sign"></span>Sprint</a>
    @endif
    <span>
        <b>Backlog</b>
        <span class="colorShade">
            <b>issues: {{count($project->SortIssueByOrder())}}</b>
        </span>
    </span>
    @if($project->getBacklogTime() < 0)
        <span class="badge baDge-error pull-right marginL">{{$project->getBacklogTime()}}h</span>
    @else
        <span class="badge baDge-success pull-right marginL">{{$project->getBacklogTime()}}h</span>
    @endif
    <span class="badge baDge-warning pull-right marginL">{{$project->getBacklogOE()}}h</span>
    @if($project->order != null)
        <input id="issueData-backlog" type="hidden" name="issueData[backlog]" value="{{implode(',',json_decode($project->order))}}">
    @else
        <input id="issueData-backlog" type="hidden" name="issueData[backlog]">
    @endif
    <div id="backlog" class="connectedSortable sprintContainer" data-value="backlog">
        @foreach($project->SortIssueByOrder() as $issue)
            @include('list.issueView')
        @endforeach
    </div>
    <a class="pull-right" style="text-decoration: none; cursor: hand" data-toggle="modal" data-target="#projectIssueCreate"><span class="glyphicon glyphicon-plus-sign"></span>Issue</a>
</div>