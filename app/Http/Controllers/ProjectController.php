<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
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
        return view('project.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'key' => 'required|max:5|unique:projects',
        ]);

        Project::create([
            'name' => $request['name'],
            'key' => $request['key'],
        ]);

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

    public function update($id, Request $request)
    {
        $project = Project::find($id);

        $this->validate($request, [
            'name' => 'required|max:50',
            'key' => 'required|max:5|unique:projects',
        ]);

        $project->update([
            [$project->name = $request->name],
            [$project->key = $request->key],
        ]);


        $project->save();
        session()->flash('status', 'Project successfully updated!');

        return redirect('project/index');
    }
}
