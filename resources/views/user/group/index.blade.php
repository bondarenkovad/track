@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <span class="text-left text-muted" style="font-size: 1.3em"><span class="userName">Groups</span> List</span>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <a  href="/user/group/add" class="textDecorNo btn btn-success pull-right">Group Create</a>
            </div>
        </div>
        <hr>
        <div class="issue">
            @foreach($groups as $group)
                @include('user.group.GroupTemplates.groupList')
            @endforeach
        </div>
    </div>
@endsection