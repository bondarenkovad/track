@extends('layouts.app')
@section('content')
    <div class="container">
            <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Issues</span> List</span>
            <table class="table table-hover table-condensed">
                <thead>
                <th>Summary</th>
                <th>Description</th>
                <th>Status</th>
                <th>Project</th>
                <th>Type</th>
                <th>Priority</th>
                <th>Reporter</th>
                <th>Assigned</th>
                <th>Comments</th>
                <th>Work Log</th>
                <th>Files</th>
                <th>Original estimate</th>
                <th>Remaining estimate</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($issues as $issue)
                    <tr>
                        <td>{{$issue->summary}}</td>
                        <td style="width:100px; overflow: hidden;text-overflow:ellipsis">{!! $issue->description !!}</td>
                        <td>{{$issue->status['name']}}</td>
                        <td>{{$issue->project['name']}}</td>
                        <td>{{$issue->type['name']}}</td>
                        <td>{{$issue->priority['name']}}</td>
                        <td>
                            <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none">
                            @if($issue->reporter['image_path'] != null)
                                <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                                @else
                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                            @endif
                            </a>
                        </td>
                        <td>
                            <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none">
                            @if($issue->assigned['image_path'] != null)
                                <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                            @else
                                <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                            @endif
                            </a>
                        </td>
                        <td>{{$issue->CountComments()}}</td>
                        <td>{{$issue->CountLogs()}}</td>
                        <td>{{$issue->CountAttachments()}}</td>
                        <td>{{$issue->original_estimate}}h</td>
                        <td>{{$issue->calcRE()}}h</td>
                        <td><a  href="/project/{{$issue->getProjectInfo($issue->project['name'])->key}}/issue/{{$issue->id}}/edit" class="floatRight"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div class="text-center">
            {{$issues->links()}}
        </div>
    </div>
@stop