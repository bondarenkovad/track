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
        $sprints = $this->getSprints();
        return view('sprint.index', ['sprints' => $sprints]);
    }

    public function makeStatusIsActive($id)
    {
        $sprint = $this->getSprintById($id);

        $sprint->update([
            [$sprint->status = 2],
        ]);

        $sprint->save();

        return back();
    }

    public function makeStatusIsFinish($id)
    {
        $sprint = $this->getSprintById($id);
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
        $project = $this->getProjectByKey($key);
        $board = $this->getBoardById($id);

        return view('sprint.create', ['project' => $project, 'board' => $board]);
    }

    public function store($key, $id, Request $request)
    {
        $project = $this->getProjectByKey($key);

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
            'date_finish' => $request['date_start'],
        ]);

        return redirect('/project/' . $project->key . '/board/' . $id . '/backlog');
    }

    public function destroy($id)
    {
        $sprint = $this->getSprintById($id);

        if ($sprint->order === null || $sprint->order === []) {
            $sprint->delete();
        } else {
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
        $sprint = $this->getSprintById($id);
        $projects = $this->getProjects();
        $board = $this->getBoardById($i);

        return view('sprint.edit', ['sprint' => $sprint, 'projects' => $projects, 'board' => $board]);
    }

    public function modalEdit($id)
    {
        $sprint = DB::table('sprints')
            ->join('projects', 'projects.id', '=', 'sprints.project_id')
            ->where('sprints.id', '=', $id)
            ->select('projects.name as project', 'sprints.*')
            ->first();

        return json_encode($sprint);
    }

    public function modalUpdate(Request $request)
    {
        $id = $request['sprintId'];
        $sprint = $this->getSprintById($id);

        $this->validate($request, [
            'sprintName' => 'required|max:50',
            'description' => 'required',
            'status' => 'required',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        $sprint->update([
            [$sprint->name = $request->sprintName],
            [$sprint->description = $request->description],
            [$sprint->status = (int)$request->status],
            [$sprint->project_id = $sprint->project['id']],
            [$sprint->date_start = $request->date_start],
            [$sprint->date_finish = $request->date_finish],
        ]);

        $sprint->save();
        session()->flash('status', 'Sprint successfully updated!');

        return back();
    }

    public function update($id, $i, Request $request)
    {
        $sprint = $this->getSprintById($id);

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

        return redirect('/project/' . $sprint->project['key'] . '/board/' . $i . '/backlog');
    }

    public function getSprints()
    {
        return Sprint::all();
    }

    public function getSprintById($id)
    {
        return Sprint::find($id);
    }

    public function getProjectByKey($key)
    {
        return Project::where('key', '=', $key)
            ->first();
    }

    public function getBoardById($id)
    {
        return Board::find($id);
    }

    public function getProjects()
    {
        return Project::all();
    }
}
