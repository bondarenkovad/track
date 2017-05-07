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
        $boards = $this->getBoards();
        return view('board.index', ['boards' => $boards]);
    }

    public function create()
    {
        $projects = $this->getProjects();
        $statuses = $this->getStatuses();
        return view('board.create', ['projects' => $projects, 'statuses' => $statuses]);
    }

    public function store(Request $request)
    {
        $statuses = explode(',', $request->input('statusesId'));
        $allStatuses = $this->getStatuses();

        $this->validate($request, [
            'name' => 'required|max:50',
            'project_id' => 'required|not_in:0',
        ]);

        $id = DB::table('boards')->insertGetId([
            'name' => $request['name'],
            'project_id' => (int)$request['project_id'],
        ]);

        $board = Board::find($id);
        $key = 0;

        if ($statuses != null) {
            foreach ($allStatuses as $status) {
                if (in_array($status->id, $statuses)) {
                    if (!$board->hasStatus($status->name)) {
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
        $projects = $this->getProjects();
        return view('board.edit', ['board' => $board, 'projects' => $projects]);
    }

    public function update($id, Request $request)
    {
        $statuses = explode(',', $request->input('statusesId'));
        $allStatuses = $this->getStatuses();
        $board = Board::find($id);
        $key = 0;

        if ($statuses[0] === "") {
            foreach ($board->statuses()->get() as $status) {
                if ($board->hasStatus($status->name)) {

                    $board->deleteStatusToBoard($status->id);
                }
            }
        } else {
            foreach ($allStatuses as $status) {
                if (in_array($status->id, $statuses)) {
                    if (!$board->hasStatus($status->name)) {

                        $key++;
                        $board->addStatusToBoard($status->id, $key);
                    }
                } else {
                    if ($board->hasStatus($status->name)) {

                        $board->deleteStatusToBoard($status->id);
                    }
                }
            }
        }

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

    public function getBoards()
    {
        return $boards = Board::all();
    }

    public function getProjects()
    {
        return $projects = Project::all();
    }

    public function getStatuses()
    {
        return $statuses = IssueStatus::all();
    }
}
