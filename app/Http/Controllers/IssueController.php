<?php

namespace App\Http\Controllers;

use App\Comment;
use App\WorkLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Issue;
use App\IssueStatus;
use App\Project;
use App\IssueType;
use App\IssuesPriority;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $issues = Issue::all();
        return view('issue.index', ['issues' => $issues]);
    }

    public function create()
    {
        $statuses = IssueStatus::all();
        $projects = Project::all();
        $types = IssueType::all();
        $priorities = IssuesPriority::all();
        $users = User::all();
        return view('issue.create', ['statuses'=>$statuses,
            'projects'=>$projects, 'types'=>$types,
            'priorities'=>$priorities, 'users'=>$users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'summary' => 'required|max:50',
            'description' => 'required|max:50',
            'status_id' => 'required|not_in:0',
            'project_id' => 'required|not_in:0',
            'type_id' => 'required|not_in:0',
            'priority_id' => 'required|not_in:0',
            'reporter_id' => 'required|not_in:0',
            'assigned_id' => 'required|not_in:0',
            'original_estimate' => 'required|integer|not_in:0',
            'remaining_estimate' => 'required|integer|not_in:0',
        ]);

        Issue::create([
        'summary' => $request['summary'],
        'description' => $request['description'],
            'status_id' => $request['status_id'],
            'project_id' =>(int)$request['project_id'],
            'type_id' => (int)$request['type_id'],
            'priority_id' => (int)$request['priority_id'],
            'reporter_id' => (int)$request['reporter_id'],
            'assigned_id' => (int)$request['assigned_id'],
            'original_estimate' => (int)$request['original_estimate'],
            'remaining_estimate' =>(int)$request['remaining_estimate'],
    ]);

       return redirect('issue/index');
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
        $issue = Issue::find($id);
        $statuses = IssueStatus::all();
        $projects = Project::all();
        $types = IssueType::all();
        $priorities = IssuesPriority::all();
        $users = User::all();
        return view('issue.edit', ['issue'=>$issue, 'statuses'=>$statuses,
            'projects'=>$projects, 'types'=>$types,
            'priorities'=>$priorities, 'users'=>$users]);
    }

    public function update($id, Request $request)
    {
        $issue =Issue::find($id);

        $this->validate($request, [
            'summary' => 'required|max:50',
            'description' => 'required',
            'status_id' => 'required|not_in:0',
            'project_id' => 'required|not_in:0',
            'type_id' => 'required|not_in:0',
            'priority_id' => 'required|not_in:0',
            'reporter_id' => 'required|not_in:0',
            'assigned_id' => 'required|not_in:0',
            'original_estimate' => 'required|integer|not_in:0',
            'remaining_estimate' => 'required|integer|not_in:0',
        ]);

        $issue->update([
            [$issue->summary = $request->summary],
            [$issue->description = $request->description],
            [$issue->status_id = (int)$request->status_id],
            [$issue->project_id = (int)$request->project_id],
            [$issue->type_id = (int)$request->type_id],
            [$issue->priority_id = (int)$request->priority_id],
            [$issue->reporter_id = (int)$request->reporter_id],
            [$issue->assigned_id = (int)$request->assigned_id],
            [$issue->status_id = (int)$request->status_id],
            [$issue->original_estimate = (int)$request->original_estimate],
            [$issue->remaining_estimate = (int)$request->remaining_estimate],
        ]);


        $issue->save();
        session()->flash('status', 'Issue successfully updated!');

        return redirect('issue/index');
    }


    public function addComment($id)
    {
        $issue = Issue::find($id);

        return view('issue.comment.index', ['issue'=>$issue]);
    }

    public function saveComment($id, Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        DB::table('comments')->insert(
            array('text' => $request->text, 'user_id' =>  Auth::user()->id, 'issue_id' => $id)
        );
        session()->flash('status', 'Comment added!');

        return redirect('issue/index');
    }

    public function editComment($id)
    {
        $comment = Comment::find($id);

        return view('issue.comment.edit', ['comment'=>$comment]);
    }

    public function updateComment($id, Request $request)
    {
        $comment =Comment::find($id);

        $this->validate($request, [
            'text' => 'required',
        ]);

        $comment->update([
            [$comment->text = $request->text]
        ]);


        $comment->save();
        session()->flash('status', 'Comment successfully updated!');

        return redirect('issue/index');
    }

    public function deleteComment($id)
    {
        DB::table('comments')->delete($id);

        session()->flash('danger', 'Comment delete!');
        return redirect('issue/index');
    }

    public function editWorkLog($id)
    {
        $log = WorkLog::find($id);
        $statuses = IssueStatus::all();

        return view('issue.workLog.edit', ['log'=>$log, 'statuses'=>$statuses]);
    }

    public function addWorkLog($id)
    {
        $issue = Issue::find($id);
        $statuses = IssueStatus::all();
        return view('issue.workLog.index', ['issue'=>$issue, 'statuses'=>$statuses]);
    }

    public function updateWorkLog($id, Request $request)
    {
        $log = WorkLog::find($id);

        $this->validate($request, [
            'time_spent' => 'required|not_in:0',
            'status_id' => 'required|not_in:0',
            'comment' => 'required',
        ]);

        $log->update([
            [$log->comment = $request->comment],
            [$log->time_spent = (int)$request->time_spent],
            [$log->issue_status_id = (int)$request->status_id]
        ]);


        $log->save();
        session()->flash('status', 'Work Log successfully updated!');

        return redirect('issue/index');
    }

    public function saveWorkLog($id, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'status_id' => 'required|not_in:0',
            'time_spent' => 'required|not_in:0',
        ]);

        DB::table('work_logs')->insert(
            array('comment' => $request->comment, 'user_id' =>  Auth::user()->id, 'issue_id' => $id,'issue_status_id' => (int)$request['status_id'], 'time_spent'=>(int)$request['time_spent'] )
        );
        session()->flash('status', 'Work Log added!');

        return redirect('issue/index');
    }

    public function deleteWorkLog($id)
    {
        DB::table('work_logs')->delete($id);

        session()->flash('danger', 'Work Log has been delete!');
        return redirect('issue/index');
    }
}
