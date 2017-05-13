<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\IssuesPriority;
use Illuminate\Support\Facades\DB;

class IssuesPriorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $issuesPriority = $this->getPriorities();
        return view('issue.priority.index', ['issuesPriority' => $issuesPriority]);
    }

    public function create()
    {
        return view('issue.priority.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:issues_priorities',
        ]);

        IssuesPriority::create([
            'name' => $request['name'],
        ]);

        return redirect('issue/priority/index');
    }

    public function destroy($id)
    {
        DB::table('issues_priorities')->delete($id);

        return redirect('issue/priority/index');
    }

    public function edit($id)
    {
        $issuesPriority = $this->getPriorityById($id);
        return view('issue.priority.edit', ['issuesPriority' => $issuesPriority]);
    }

    public function update($id, Request $request)
    {
        $issuesPriority = $this->getPriorityById($id);

        $this->validate($request, [
            'name' => 'required|max:50',
        ]);

        $issuesPriority->update([
            [$issuesPriority->name = $request->name],
        ]);


        $issuesPriority->save();
        session()->flash('status', 'Issue Priority successfully updated!');

        return redirect('issue/priority/index');
    }

    public function getPriorities()
    {
        return IssuesPriority::all();
    }

    public function getPriorityById($id)
    {
        return IssuesPriority::find($id);
    }
}
