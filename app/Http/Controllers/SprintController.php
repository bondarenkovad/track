<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Sprint;
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

    public function create()
    {
        $projects = Project::all();
        return view('sprint.create', ['projects'=>$projects]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'description' => 'required',
            'project_id' => 'required|not_in:0',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        Sprint::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'project_id' =>(int)$request['project_id'],
            'date_start' => $request['date_start'],
            'date_finish' =>$request['date_start'],
        ]);

        return redirect('/sprint/index');
    }
//
//    public function destroy($id)
//    {
//        DB::table('projects')->delete($id);
//
//        return redirect('project/index');
//    }
//
    public function edit($id)
    {
        $sprint = Sprint::find($id);
        $projects = Project::all();

        return view('sprint.edit', ['sprint'=>$sprint,'projects'=>$projects]);
    }

    public function update($id, Request $request)
    {
        $sprint =Sprint::find($id);

        $this->validate($request, [
            'name' => 'required|max:50',
            'description' => 'required',
            'project_id' => 'required|not_in:0',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        $sprint->update([
            [$sprint->name = $request->name],
            [$sprint->description = $request->description],
            [$sprint->project_id = (int)$request->project_id],
            [$sprint->date_start = $request->date_start],
            [$sprint->date_finish = $request->date_finish],
        ]);


        $sprint->save();
        session()->flash('status', 'Sprint successfully updated!');

        return redirect('sprint/index');
    }
}