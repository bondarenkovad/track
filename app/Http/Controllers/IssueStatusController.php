<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\IssueStatus;
use Illuminate\Support\Facades\DB;

class IssueStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $issuesStatuses = $this->getStatuses();
        return view('issue.status.index', ['issuesStatuses' => $issuesStatuses]);
    }

    public function create()
    {
        return view('issue.status.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|unique:issue_statuses',
        ]);

        IssueStatus::create([
            'name' => $request['name'],
        ]);

        return redirect('issue/status/index');
    }

    public function destroy($id)
    {
        DB::table('issue_statuses')->delete($id);

        return redirect('issue/status/index');
    }

    public function edit($id)
    {
        $issueStatus = $this->getStatusById($id);
        return view('issue.status.edit', ['issueStatus' => $issueStatus]);
    }

    public function update($id, Request $request)
    {
        $issueStatus = $this->getStatusById($id);

        $this->validate($request, [
            'name' => 'required|max:50',
        ]);

        $issueStatus->update([
            [$issueStatus->name = $request->name],
        ]);


        $issueStatus->save();
        session()->flash('status', 'Issue Status successfully updated!');

        return redirect('issue/status/index');
    }

    public function getStatuses()
    {
        return IssueStatus::all();
    }

    public function getStatusById($id)
    {
        return IssueStatus::find($id);
    }
}
