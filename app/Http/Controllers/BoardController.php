<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\Board;
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
        return view('board.create', ['projects'=>$projects]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'project_id' => 'required|not_in:0',
        ]);

        Board::create([
            'name' => $request['name'],
            'project_id' =>(int)$request['project_id'],
        ]);

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
