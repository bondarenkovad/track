<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Action;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = Group::all();
        return view('user.group.index', ['groups' => $groups]);
    }

    public function create()
    {
        $actions = Action::all();
        return view('user.group.create', ['actions' => $actions]);
    }

    public function showUser($id)
    {
        $group = Group::find($id);
        return view('user.group.show', ['group' => $group]);
    }

    public function store(Request $request)
    {
        $allActions = Action::all();
        $actions = $request->action;

        $this->validate($request, [
            'name' => 'required|max:255|unique:groups',
        ]);

        $id = DB::table('groups')->insertGetId([
            'name' => $request['name'],
        ]);

        $group = Group::find($id);

        if ($actions != null) {
            foreach ($allActions as $action) {
                if (array_key_exists($action->id, $actions)) {
                    if (!$group->hasAction($action->name)) {
                        $group->addActionToGroup($action->id);
                    }
                }
            }
        }
        return redirect('user/group/index');
    }

    public function edit($id)
    {
        $group = Group::find($id);
        return view('user.group.edit', ['group' => $group]);
    }

    public function update($id, Request $request)
    {
        $allActions = Action::all();
        $group = Group::find($id);
        $actions = $request->action;

        if ($actions === null) {
            foreach ($group->actions()->get() as $action) {
                if ($group->hasAction($action->name)) {
                    $group->deleteActionInGroup($action->id);
                }
            }
        } else {
            foreach ($allActions as $action) {
                if (array_key_exists($action->id, $actions)) {
                    if (!$group->hasAction($action->name)) {
                        $group->addActionToGroup($action->id);
                    }
                } else {

                    if ($group->hasAction($action->name)) {
                        $group->deleteActionInGroup($action->id);
                    }
                }
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $group->update([
            [$group->name = $request->name],
        ]);


        $group->save();
        session()->flash('status', 'Group successfully update!');

        return redirect('user/group/index');
    }

}
