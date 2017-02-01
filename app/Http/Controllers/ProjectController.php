<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $projects = Project::all();
        return view('project.index', ['projects' => $projects]);
    }

    public function create()
    {
        $users = User::all();
        return view('project.create', ['users'=>$users]);
    }

    public function store(Request $request)
    {
        $allUsers = User::all();
        $users = $request->user;

        $this->validate($request, [
            'name' => 'required|max:50',
            'key' => 'required|max:5|alpha|unique:projects',
        ]);

        $key = $request->key;
        $key = strtoupper($key);

        $id = DB::table('projects')->insertGetId([
            'name' => $request['name'],
            'key' => $key,
        ]);

        $project = Project::find($id);

        if($users === null)
        {

        }
        else
        {
            foreach($allUsers as $user)
            {
                if(array_key_exists($user->id, $users))
                {
                    if(!$project->hasUserInProject($user->name))
                    {
                        $project->addUserToProject($user->id);
                    }
                }
            }
        }

        return redirect('project/index');
    }

    public function destroy($id)
    {
        DB::table('projects')->delete($id);

        return redirect('project/index');
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('project.edit', ['project'=>$project]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $p = Project::where('name', 'like', "%$search%")->get();

        if(count($p) == 0 || $search === "")
        {
            $projects = Project::all();
            session()->flash('danger', 'No search in database!');
            return view('/project/index', ['projects' => $projects]);
        }
        else
        {
            return view('/project/index', ['projects' => $p]);
        }

    }

    public function update($id, Request $request)
    {
        $allUsers = User::all();
        $project = Project::find($id);
        $users = $request->user;

        if($users === null)
        {
            foreach($project->users()->get() as $user)
            {
                if($project->hasUserInProject($user->name))
                {

                    $project->deleteUserOfProject($user->id);
                }
            }
        }
        else
        {
            foreach($allUsers as $user)
            {
                if(array_key_exists($user->id, $users))
                {
                    if(!$project->hasUserInProject($user->name))
                    {
                        $project->addUserToProject($user->id);
                    }
                }
                else
                {

                    if($project->hasUserInProject($user->name))
                    {
                        $project->deleteUserOfProject($user->id);
                    }
                }
            }
        }

        $this->validate($request, [
            'name' => 'required|max:50',
            'key' => 'required|max:5|alpha',
        ]);

        $key = $request->key;

        $key = strtoupper($key);

        $project->update([
            [$project->name = $request->name],
            [$project->key = $key],
        ]);


        $project->save();
        session()->flash('status', 'Project successfully updated!');

        return redirect('project/index');
    }
}
