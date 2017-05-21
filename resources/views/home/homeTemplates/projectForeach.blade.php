<div>
        <a href="/project/{{$project->id}}/view" style="text-decoration: none">Project - {{$project->key}}</a>
        <span class="colorShade">issues:{{count($project->getIssueForUserById($user->id))}}</span>
        @if($project->getUserInProjectTime($user->id) < 0)
            <span class="badge baDge-error pull-right marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
        @else
            <span class="badge baDge-success pull-right marginL">{{$project->getUserInProjectTime($user->id)}}h</span>
        @endif
        <span class="badge baDge-warning pull-right marginL">{{$project->getUserInProjectOE($user->id)}}h</span>
        <div class="issue">
            @foreach($project->getIssueForUserById($user->id) as $issue)
                @include('list.issueView')
            @endforeach
        </div>
</div>