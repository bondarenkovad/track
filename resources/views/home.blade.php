@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        And you also may:
        <ul>@foreach($user->getActions() as $action)</ul>
        <li>{{$action->name}}</li>
        @endforeach
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
            <th>Name</th>
            <th>E-mail</th>
            <th>Group</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <form action="" method="post">
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
                        <td>
                            <ul>
                                @foreach($user->groups()->get() as $group)
                            </ul>

                            <li>{{$group->name}}</li>
                            @endforeach
                        </td>
                        {{--<td><input type="checkbox" {{$user->hasRole('User') ? 'checked' : ''}} name="role_user"></td>--}}
                        {{--<td><input type="checkbox" {{$user->hasRole('Author') ? 'checked' : ''}} name="role_author"></td>--}}
                        {{--<td><input type="checkbox" {{$user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"></td>--}}
                        {{--<td></td>--}}
                        {{--<td></td>--}}
                        {{csrf_field()}}
                        <td><button type="submit">Assign Roles</button> </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
