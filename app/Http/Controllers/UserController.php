<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Project;
use App\Issue;
use Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
//        $user = $request->user();
        if($request->user() != null) {

            $users = User::all();
            return view('user.index', ['users' => $users]);
        }
        else
        {
            return view('auth.login');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        $issues = Issue::where('assigned_id', '=', $user->id)->paginate(10);
        return view('user.show', ['user'=>$user, 'issues'=> $issues]);
    }

    public function create()
    {
        $projects = Project::all();
        return view('user.create', ['projects'=>$projects]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'active' => 'required|integer|between:0,1',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        $allProjects = Project::all();
        $projects = $request->project;

        $this->validate($request, [
            'name' => 'required|max:255',
            'active' => 'required|integer|between:0,1',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        if($request->hasFile('image_path'))
        {
            $file = $request->file('image_path');
            $destinationPath = '/img/userPhoto';
            $path = 'C:\wamp\www\track\public\img\userPhoto';
            $extention = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999).'.'.$extention;
            $file->move($path, $fileName);

            $userPhoto = $destinationPath.'/'.$fileName;
        }
        else
        {
            $userPhoto = 'img/userPhoto/defaultPhoto.png';
        }

        $id = DB::table('users')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'active'=>(int)$request['active'],
            'image_path'=>$userPhoto,
        ]);

        $user = User::find($id);

        $user->addDefaultUserGroup();

        if($projects != null)
        {
            foreach($allProjects as $project)
            {
                if(in_array($project->id, $projects))
                {
                    if(!$user->hasProject($project->name))
                    {
                        $user->addInProject($project->id);
                    }
                }
            }
        }

        return redirect('user/index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user'=>$user]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $u = User::where('name', 'like', "%$search%")->get();

        if(count($u) == 0 || $search === "")
        {
            $users = User::all();
            session()->flash('danger', 'No search in database!');
            return view('/user/index', ['users' => $users]);
        }
        else
        {
            return view('/user/index', ['users' => $u]);
        }

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $allGroup = Group::all();
        $user=User::find($id);
        $groups = $request->group;
        $projects = $request->project;
        $allProjects = Project::all();

        if($groups === null)
        {
           foreach($user->groups()->get() as $group)
           {
               if($user->hasGroup($group->name))
               {

                   $user->deleteGroupToUser($group->id);
               }
           }
        }
        else
        {
            foreach($allGroup as $group)
                {
                    if(array_key_exists($group->id, $groups))
                    {
                        if(!$user->hasGroup($group->name))
                        {
                            $user->addGroupToUser($group->id);
                        }
                    }
                    else
                    {

                        if($user->hasGroup($group->name))
                        {
                            $user->deleteGroupToUser($group->id);
                        }
                    }
                }
        }

        if($projects === null)
        {
            foreach($user->projects()->get() as $project)
            {
                if($user->hasProject($project->name))
                {

                    $user->deleteOfProject($project->id);
                }
            }
        }
        else
        {
            foreach($allProjects as $project)
            {
                if(in_array($project->id, $projects))
                {
                    if(!$user->hasProject($project->name))
                    {
                        $user->addInProject($project->id);
                    }
                }
                else
                {
                    if($user->hasProject($project->name))
                    {
                        $user->deleteOfProject($project->id);
                    }
                }
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'active' => 'required|integer|between:0,1',
            'email' => 'required|email|max:255',
            'password' => 'sometimes|min:6|confirmed',
        ]);

        if($request->hasFile('image_path'))
        {
            $file = $request->file('image_path');
            $path = 'C:\wamp\www\track\public\img\userPhoto';
            $destinationPath = '/img/userPhoto';
            $extention = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999).'.'.$extention;
            $file->move($path, $fileName);

            $userPhoto = $destinationPath.'/'.$fileName;
        }
        else
        {
            $userPhoto = '/img/userPhoto/defaultPhoto.png';
        }


        if($request->password === "")
        {
            $user->update([
                [$user->name = $request->name],
                [$user->active = $request->active],
                [$user->email = $request->email],
                [$user->active = (int)$request->active],
                [$user->image_path = $userPhoto],
            ]);
        }
        else
        {
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'active'=>(int)$request['active'],
                'image_path'=>$userPhoto,
            ]);
        }

        $user->save();
        session()->flash('status', 'User successfully updated!');

        return redirect('user/index');
    }


}
