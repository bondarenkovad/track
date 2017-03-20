<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use App\Project;
use App\Sprint;
use App\Issue;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class SprintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sprints = Sprint::all();
        return view('sprint.index', ['sprints' => $sprints]);
    }

    public function makeStatusIsActive($id)
    {
        $sprint = Sprint::find($id);

        $sprint->update([
            [$sprint->status = 2],
        ]);

        $sprint->save();

        return back();
    }

    public function makeStatusIsFinish($id)
    {
        $sprint = Sprint::find($id);
        $issueIdMass = $sprint->getNotDoneIssues();
        $project = Project::find($sprint->project['id']);
        $issueInProject = json_decode($project->order);

        $mergeMass = array_merge($issueInProject, $issueIdMass);

        $project->update([
            [$project->order = json_encode($mergeMass)]
        ]);

        $project->save();

        $sprint->update([
            [$sprint->order = null],
            [$sprint->status = 0]
        ]);

        $sprint->save();

        session()->flash('status', 'Unfinished issue replace to backlog!');
        return back();
    }


    public function create($key, $id)
    {
        $project = Project::where('key', '=', $key)
            ->first();
        $board = Board::find($id);

        return view('sprint.create', ['project'=>$project, 'board'=>$board]);
    }

    public function store($key,$id,Request $request)
    {
        $project = Project::where('key', '=', $key)
            ->first();

        $this->validate($request, [
            'name' => 'required|max:50',
            'description' => 'required',
            'status' => 'required',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        Sprint::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'status' => (int)$request['status'],
            'project_id' => $project->id,
            'date_start' => $request['date_start'],
            'date_finish' =>$request['date_start'],
        ]);

        return redirect('/project/'.$project->key.'/board/'.$id.'/backlog');
    }

    public function destroy($id)
    {
        $sprint = Sprint::find($id);

        if($sprint->order === null || $sprint->order === [])
        {
            $sprint->delete();
        }
        else
        {
            $issueIdMass = $sprint->getNotDoneIssues();
            $project = Project::find($sprint->project['id']);
            $issueInProject = json_decode($project->order);

            $mergeMass = array_merge($issueInProject, $issueIdMass);

            $project->update([
                [$project->order = json_encode($mergeMass)]
            ]);

            $project->save();

            $sprint->delete();
        }

        return back();
    }

    public function edit($id, $i)
    {
        $sprint = Sprint::find($id);
        $projects = Project::all();
        $board = Board::find($i);

        return view('sprint.edit', ['sprint'=>$sprint,'projects'=>$projects, 'board'=>$board]);
    }

    public function update($id, $i, Request $request)
    {
        $sprint = Sprint::find($id);

        $this->validate($request, [
            'name' => 'required|max:50',
            'description' => 'required',
            'status' => 'required',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        $sprint->update([
            [$sprint->name = $request->name],
            [$sprint->description = $request->description],
            [$sprint->status = (int)$request->status],
            [$sprint->project_id = $sprint->project['id']],
            [$sprint->date_start = $request->date_start],
            [$sprint->date_finish = $request->date_finish],
        ]);

        $sprint->save();
        session()->flash('status', 'Sprint successfully updated!');

        return redirect('/project/'.$sprint->project['key'].'/board/'.$i.'/backlog');
    }
}
