@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Home page</h1>
    {{--<div class="row">--}}
        {{--And you also may:--}}
        {{--<ul>@foreach($user->getActions() as $action)</ul>--}}
        {{--<li>{{$action->name}}</li>--}}
        {{--@endforeach--}}
    {{--</div>--}}
    {{--<div class="row">--}}
        {{--<table class="table table-hover">--}}
            {{--<thead>--}}
            {{--<th>Name</th>--}}
            {{--<th>E-mail</th>--}}
            {{--<th>Groups</th>--}}
            {{--<th>Administrator</th>--}}
            {{--<th>PM</th>--}}
            {{--<th>User</th>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($users as $user)--}}
                {{--<tr>--}}
                    {{--<form action="store" method="post">--}}
                        {{--<td>{{$user->name}}</td>--}}
                        {{--<td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>--}}
                        {{--<td>--}}
                           {{--<ul> @foreach($user->groups()->get() as $group)</ul>--}}
                            {{--<li>{{$group->name}}</li>--}}
                            {{--@endforeach--}}
                        {{--</td>--}}
                        {{--<td><input type="checkbox" {{$user->hasGroup('Administrator') ? 'checked' : ''}} name="group_admin"></td>--}}
                        {{--<td><input type="checkbox" {{$user->hasGroup('PM') ? 'checked' : ''}} name="group_pm"></td>--}}
                        {{--<td><input type="checkbox" {{$user->hasGroup('User') ? 'checked' : ''}} name="group_user"></td>--}}
                        {{--<td></td>--}}
                        {{--<td></td>--}}
                        {{--{{csrf_field()}}--}}
                        {{--<td><button type="submit">Assign Roles</button> </td>--}}
                    {{--</form>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
</div>
@endsection
