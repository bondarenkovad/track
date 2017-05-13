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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use File;

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $issues = Issue::paginate(10);
        return view('issue.index', ['issues' => $issues]);
    }

    public function create($key)
    {
        $statuses = $this->getStatuses();
        $project = $this->getProject($key);
        $types = $this->getTypes();
        $priorities = $this->getPriorities();
        $users = $this->getUsers();

        return view('issue.create', ['statuses' => $statuses,
            'project' => $project, 'types' => $types,
            'priorities' => $priorities, 'users' => $users]);
    }

    public function store($id, Request $request)
    {
        $project = $this->getProjectById($id);

        $this->validate($request, [
            'summary' => 'required|max:50',
            'description' => 'required',
            'status_id' => 'required|not_in:0',
            'type_id' => 'required|not_in:0',
            'priority_id' => 'required|not_in:0',
            'assigned_id' => 'required|not_in:0',
            'original_estimate' => 'required|integer',
            'remaining_estimate' => 'required|integer',
        ]);

        Issue::create([
            'summary' => $request['summary'],
            'description' => $request['description'],
            'status_id' => $request['status_id'],
            'project_id' => $id,
            'type_id' => (int)$request['type_id'],
            'priority_id' => (int)$request['priority_id'],
            'reporter_id' => Auth::user()->id,
            'assigned_id' => (int)$request['assigned_id'],
            'original_estimate' => (int)$request['original_estimate'],
            'remaining_estimate' => (int)$request['remaining_estimate'],
        ]);

        return view('project.view', ['project' => $project]);
    }

    public function modalStore($id, Request $request)
    {
        $this->validate($request, [
            'summary' => 'required|max:50',
            'description' => 'required',
            'status_id' => 'required|not_in:0',
            'type_id' => 'required|not_in:0',
            'priority_id' => 'required|not_in:0',
            'assigned_id' => 'required|not_in:0',
            'original_estimate' => 'required|integer',
            'remaining_estimate' => 'required|integer',
        ]);

        Issue::create([
            'summary' => $request['summary'],
            'description' => $request['description'],
            'status_id' => $request['status_id'],
            'project_id' => $id,
            'type_id' => (int)$request['type_id'],
            'priority_id' => (int)$request['priority_id'],
            'reporter_id' => Auth::user()->id,
            'assigned_id' => (int)$request['assigned_id'],
            'original_estimate' => (int)$request['original_estimate'],
            'remaining_estimate' => (int)$request['remaining_estimate'],
        ]);

        session()->flash('status', 'Issue successfully added!');
        return back();
    }

    public function view($key, $id)
    {
        $issue = $this->getIssueById($id);
        $statuses = $this->getStatuses();
        $projects = $this->getProjects();
        $types = $this->getTypes();
        $priorities = $this->getPriorities();
        $users = $this->getUsers();

        if ($key != null) {
            $project = $this->getProject($key);
        }

        return view('issue.view.view', ['issue' => $issue, 'statuses' => $statuses,
            'project' => $project, 'types' => $types,
            'priorities' => $priorities, 'users' => $users, 'projects' => $projects]);
    }

    public function edit($key, $id)
    {
        $issue = $this->getIssueById($id);
        $statuses = $this->getStatuses();
        $project = $this->getProject($key);
        $types = $this->getTypes();
        $priorities = $this->getPriorities();
        $users = $this->getUsers();

        return view('issue.edit', ['issue' => $issue, 'statuses' => $statuses,
            'project' => $project, 'types' => $types,
            'priorities' => $priorities, 'users' => $users]);
    }

    public function update($id, $key, Request $request)
    {
        $issue = $this->getIssueById($id);
        $project = $this->getProject($key);

        $this->validate($request, [
            'summary' => 'required|max:50',
            'description' => 'required',
            'status_id' => 'required|not_in:0',
            'type_id' => 'required|not_in:0',
            'priority_id' => 'required|not_in:0',
            'assigned_id' => 'required|not_in:0',
            'original_estimate' => 'integer',
            'remaining_estimate' => 'integer',
        ]);

        $issue->update([
            [$issue->summary = $request->summary],
            [$issue->description = $request->description],
            [$issue->status_id = (int)$request->status_id],
            [$issue->project_id = $project->id],
            [$issue->type_id = (int)$request->type_id],
            [$issue->priority_id = (int)$request->priority_id],
            [$issue->reporter_id = Auth::user()->id],
            [$issue->assigned_id = (int)$request->assigned_id],
            [$issue->status_id = (int)$request->status_id],
            [$issue->original_estimate = (int)$request->original_estimate],
            [$issue->remaining_estimate = (int)$request->remaining_estimate],
        ]);

        $issue->save();
        session()->flash('status', 'Issue successfully updated!');

        return back();
    }

    public function addComment($id)
    {
        $issue = $this->getIssueById($id);

        return view('issue.comment.index', ['issue' => $issue]);
    }

    public function saveComment($id, Request $request)
    {
        $date = $this->getDateTimeNow();

        $this->validate($request, [
            'text' => 'required',
        ]);

        DB::table('comments')->insert(
            array('text' => $request->text, 'user_id' => Auth::user()->id, 'issue_id' => $id, 'created_at' => $date)
        );
        session()->flash('status', 'Comment added!');

        return back();
    }

    public function editComment($id)
    {
        $comment = $this->getCommentById($id);

        return view('issue.comment.edit', ['comment' => $comment]);
    }

    public function updateComment($id, Request $request)
    {
        $comment = $this->getCommentById($id);

        $this->validate($request, [
            'text' => 'required',
        ]);

        $comment->update([
            [$comment->text = $request->text]
        ]);


        $comment->save();
        session()->flash('status', 'Comment successfully updated!');

        return back();
    }

    public function deleteComment($id)
    {
        DB::table('comments')->delete($id);

        session()->flash('danger', 'Comment delete!');
        return redirect('issue/index');
    }

    public function editWorkLog($id)
    {
        $log = $this->getLogById($id);
        $statuses = $this->getStatuses();

        return view('issue.workLog.edit', ['log' => $log, 'statuses' => $statuses]);
    }

    public function addWorkLog($id)
    {
        $issue = $this->getIssueById($id);
        $statuses = $this->getStatuses();
        return view('issue.workLog.index', ['issue' => $issue, 'statuses' => $statuses]);
    }

    public function updateWorkLog($id, Request $request)
    {
        $log = WorkLog::find($id);

        $this->validate($request, [
            'time_spent' => 'required|integer',
            'status_id' => 'required|not_in:0',
            'commentLog' => 'required',
        ]);

        $log->update([
            [$log->comment = $request->commentLog],
            [$log->time_spent = (int)$request->time_spent],
            [$log->issue_status_id = (int)$request->status_id]
        ]);

        $log->save();

        $issue = $this->getIssueById($id);

        $newRem = $issue->remaining_estimate - (int)$request->time_spent;

        $issue->update([
            [$issue->remaining_estimate = $newRem],
        ]);

        $issue->save();

        session()->flash('status', 'Work Log successfully updated!');

        return back();
    }

    public function saveWorkLog($id, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'status_id' => 'required|not_in:0',
            'time_spent' => 'required|integer',
        ]);


        DB::table('work_logs')->insert(
            array('comment' => $request->comment, 'user_id' => Auth::user()->id, 'issue_id' => $id, 'issue_status_id' => (int)$request['status_id'], 'time_spent' => (int)$request['time_spent'])
        );
        session()->flash('status', 'Work Log added!');

        return back();
    }

    public function deleteWorkLog($id)
    {
        DB::table('work_logs')->delete($id);

        session()->flash('danger', 'Work Log has been delete!');
        return redirect('issue/index');
    }

    public function addFile($id)
    {
        $issue = $this->getIssueById($id);
        return view('issue.file.index', ['issue' => $issue]);
    }

    public function saveFile($id, Request $request)
    {
        $files = Input::file('file');

        $this->validate($request, [
            'file' => 'required|max:255',
        ]);

        foreach ($files as $file) {
            $destinationPath = 'uploads';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);

            DB::table('attachments')->insert(
                array('path' => '\uploads\\' . $file->getClientOriginalName(), 'issue_id' => $id)
            );
        }

        session()->flash('status', 'File added!');

        return back();
    }

    public function deleteFile(Request $request)
    {
        File::delete($request->filename);
        DB::table('attachments')
            ->where('attachments.path', '=', $request->filename)
            ->delete();

        session()->flash('danger', 'File has been delete!');
        return redirect('issue/index');
    }

    public function getStatuses()
    {
        return IssueStatus::all();
    }

    public function getProjects()
    {
        return Project::all();
    }

    public function getProject($key)
    {
        return Project::where('key', '=', $key)
            ->first();
    }

    public function getProjectById($id)
    {
        return Project::find($id);
    }

    public function getTypes()
    {
        return IssueType::all();
    }

    public function getPriorities()
    {
        return IssuesPriority::all();
    }

    public function getUsers()
    {
        return User::all();
    }

    public function getIssueById($id)
    {
        return Issue::find($id);
    }

    public function getCommentById($id)
    {
        return Comment::find($id);
    }

    public function getLogById($id)
    {
        return WorkLog::find($id);
    }

    public function getDateTimeNow()
    {
        return date("Y-m-d H:i:s", time());
    }
}
