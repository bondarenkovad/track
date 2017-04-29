<div class="row">
    <div class="col-md-12">
        <a href="/project/{{$project->id}}/view" style="text-decoration: none">Project - {{$project->key}}</a>
        <span class="colorShade">issues:{{count($project->getIssueForUserById($user->id))}}</span>
        @if($project->getUserInProjectTime($user->id) < 0)
            <span class="badge baDge-error floatR bWidth marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
        @else
            <span class="badge baDge-success floatR bWidth marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
        @endif
        <span class="badge baDge-warning floatR bWidth marginL">{{$project->getUserInProjectOE($user->id)}}h</span>
        <ul class="issue">
            @foreach($project->getIssueForUserById($user->id) as $issue)
                @include('list.issueView')
            @endforeach
        </ul>
    </div>
</div>