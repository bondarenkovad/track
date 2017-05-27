<div>
    <div class="strike">
        <span class="bolder">People</span>
    </div>
        <dl class="dl-horizontal">
            <dt>Assignee:</dt>
            <dd>
                <span class="marginLeft">
                    <a href="/user/show/{{$issue->assigned['id']}}" style="text-decoration: none">
                        @if($issue->assigned['image_path'] != null)
                            <img src="{{$issue->assigned['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                        @else
                            <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->assigned['name']}}">
                        @endif
                        {{$issue->assigned['name']}}
                    </a>
                </span>
            </dd>
            <dt>Reporter:</dt>
            <dd>
                <span class="marginLeft">
                    <a href="/user/show/{{$issue->reporter['id']}}" style="text-decoration: none">
                        @if($issue->reporter['image_path'] != null)
                            <img src="{{$issue->reporter['image_path']}}" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                        @else
                            <img src="/img/userPhoto/defaultPhoto.png" class="img img-circle" data-toggle="tooltip" title="{{$issue->reporter['name']}}">
                        @endif
                        {{$issue->reporter['name']}}
                    </a>
                </span>
            </dd>
            <dt>&nbsp;</dt>
            <dd>&nbsp;</dd>
        </dl>
    <div class="strike">
        <span class="bolder">Dates</span>
    </div>
        <dl class="dl-horizontal">
            <dt>Created:</dt>
            <dd>
                <span class="marginLeft">
                    {{date("M j, Y, g:i a",strtotime($issue->created_at))}}
                </span>
            </dd>
            <dt>Updated:</dt>
            <dd>
                 <span class="marginLeft">
                    {{date("M j, Y, g:i a",strtotime($issue->updated_at))}}
                </span>
            </dd>
            <dt>Original Estimate:</dt>
            <dd>
                <span class="marginLeft">
                    {{$issue->original_estimate}}h
                </span>
            </dd>
            <dt>Remaining Estimate:</dt>
            <dd>
                 <span class="marginLeft">
                     @if($issue->calcRE() < 0)
                         <span class="danger">{{$issue->calcRE()}}h</span>
                     @else
                         <span class="low">{{$issue->calcRE()}}h</span>
                     @endif
                </span>
            </dd>
            <dt>Time Spent:</dt>
            <dd>
                @if($issue->TimeSpentSum()!= null)
                    <span class="marginLeft">
                        {{$issue->TimeSpentSum()}}h
                    </span>
                @else
                    <span class="marginLeft">
                        0
                    </span>
                @endif
            </dd>
        </dl>
</div>