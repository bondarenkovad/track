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
            <div class="container-fluid">
                <div class="row ui-state-default">
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <strong>Group Name</strong>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <span class="badge">Actions</span>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-xs-12"></div>
                </div>
                @foreach($groups as $group)
                    @include('user.group.GroupTemplates.groupList')
                @endforeach
            </div>
        </div>
    </div>
@endsection