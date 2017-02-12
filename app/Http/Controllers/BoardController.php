<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\Board;
use App\IssueStatus;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $boards = Board::all();
        return view('board.index', ['boards' => $boards]);
    }

    public function create()
    {
        $projects = Project::all();
        $statuses = IssueStatus::all();
        return view('board.create', ['projects'=>$projects, 'statuses'=>$statuses]);
    }

    public function store(Request $request)
    {

        $statuses = explode(',',$request->input('statusesId'));
        $allStatuses = IssueStatus::all();

        $this->validate($request, [
            'name' => 'required|max:50',
            'project_id' => 'required|not_in:0',
        ]);

        $id = DB::table('boards')->insertGetId([
            'name' => $request['name'],
            'project_id' =>(int)$request['project_id'],
        ]);

        $board = Board::find($id);
        $key = 0;

        if($statuses === null)
        {

        }
        else
        {
            foreach($allStatuses as $status)
            {
                if(in_array($status->id, $statuses))
                {
                    if(!$board->hasStatus($status->name))
                    {
                        $key++;
                        $board->addStatusToBoard($status->id, $key);
                    }
                }
            }
        }
        return redirect('/board/index');
    }

    public function edit($id)
    {
        $board = Board::find($id);
        $projects = Project::all();
        return view('board.edit', ['board'=>$board, 'projects'=>$projects]);
    }

    public function update($id, Request $request)
    {
        $board = Board::find($id);

        $this->validate($request, [
            'name' => 'required|max:50',
            'project_id' => 'required|not_in:0',
        ]);

        $board->update([
            [$board->name = $request->name],
            [$board->project_id = (int)$request->project_id],
        ]);


        $board->save();
        session()->flash('status', 'Board successfully updated!');

        return redirect('/board/index');
    }

    public function destroy($id)
    {
        DB::table('boards')->delete($id);

        return redirect('/board/index');
    }

}
