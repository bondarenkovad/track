@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-hover">
                <thead>
                <th>Name</th>
                <th>E-mail</th>
                <th>Active</th>
                <th>Groups</th>
                <th>Edit</th>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        {{--<form action="" method="post">--}}
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
                            <td>{{$user->active}}</td>
                            <td>
                                <ul> @foreach($user->groups()->get() as $group)</ul>
                                <li>{{$group->name}}</li>
                                @endforeach
                            </td>
                            <td><a  href="/user/edit/{{$user->id}}" class="btn btn-success" >Edit</a> </td>
                            {{--{{csrf_field()}}--}}
                            {{--<td><button type="submit">Assign Roles</button> </td>--}}
                        {{--</form>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection