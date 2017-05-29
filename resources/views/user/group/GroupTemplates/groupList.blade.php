<div class="row ui-state-default">
    <div class="col-lg-4 col-sm-4 col-xs-12">
        <strong>{{$group->name}}</strong>
    </div>
    <div class="col-lg-6 col-sm-6 col-xs-12">
        @foreach($group->actions()->get() as $action)
            <span class="badge">{{$action->name}}</span>
        @endforeach
    </div>
    <div class="col-lg-2 col-sm-2 col-xs-12">
        <div class="pull-right">
            <a  href="/user/group/show/{{$group->id}}" class="floatRight">
                <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" title="Show"></i>
            </a>
            <a  href="/user/group/edit/{{$group->id}}" class="floatRight">
                <i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i>
            </a>
        </div>
    </div>
</div>
