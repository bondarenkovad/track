<?php

namespace App\Http\Controllers;

use App\Sprint;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\User;
use App\Board;
use App\Issue;
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

    public function view($id)
    {
        $project = Project::find($id);
        return view('project.view', ['project' => $project]);
    }

    public function showSprint($key, $id)
    {
        $project = Project::where('key', '=', $key)
            ->first();

        $board = $project->board()->first();

        $sprint = $project->sprints()
            ->where('id', '=', $id)
            ->first();

        return view('project.board.sprint.activeSprint', ['project' => $project, 'sprint'=> $sprint, 'board'=>$board]);
    }

    public function updateSprint($id,Request $request)
    {
//        $project = Project::with('issues')
//            ->where('key', '=', $key)
//            ->first();
        $sprint = Sprint::find($id);
        $data = $request->input('Data');

        foreach($data as $key=>$value)
        {
                foreach($value as $id)
                {
                    if($key != null)
                    {
                        $issue = Issue::find($id);

                        $issue->update([
                            [$issue->status_id = json_encode($key)]
                        ]);

                        $issue->save();
                    }
                }


        }

        return redirect('project/index');
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
                if(in_array($user->id, $users))
                {
                    if(!$project->hasUserInProject($user->name))
                    {
                        $project->addUserToProject($user->id);
                    }
                }
            }
        }

//        return redirect('project/index');
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

    public function backlog($key, Request $request)
    {
        $project = Project::where('key', '=', $key)
            ->firstOrFail();
        return view('project.backlog', ['project'=>$project]);
    }

    public function refresh($key, Request $request)
    {
        $project = Project::with('issues')
            ->where('key', '=', $key)
            ->first();

           $data = $request->input('Data');

        foreach($data as $key=>$value)
        {
            if($key === 'backlog')
            {
                $project->update([
                    [$project->order = json_encode($value)],
                ]);

                $project->save();
            }
            elseif(is_numeric($key))
            {
                $sprint = Sprint::find($key);

                if($key === null)
                {
                    $sprint->update([
                        [$sprint->order = json_encode(null)],
                    ]);
                }
                else
                {
                    $sprint->update([
                        [$sprint->order = json_encode($value)],
                    ]);
                }

                $sprint->save();
            }
        }


        return view('project.backlog', ['project'=>$project]);
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
                if(in_array($user->id, $users))
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
