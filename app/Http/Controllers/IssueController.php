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
        $statuses = IssueStatus::all();
        $project = Project::where('key', '=', $key)
            ->firstOrFail();
        $types = IssueType::all();
        $priorities = IssuesPriority::all();
        $users = User::all();
        return view('issue.create', ['statuses'=>$statuses,
            'project'=>$project, 'types'=>$types,
            'priorities'=>$priorities, 'users'=>$users]);
    }

    public function store($id, Request $request)
    {
        $project = Project::find($id);

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
            'project_id' =>$id,
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
        $project = Project::find($id);

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
            'project_id' =>$id,
            'type_id' => (int)$request['type_id'],
            'priority_id' => (int)$request['priority_id'],
            'reporter_id' => Auth::user()->id,
            'assigned_id' => (int)$request['assigned_id'],
            'original_estimate' => (int)$request['original_estimate'],
            'remaining_estimate' => (int)$request['remaining_estimate'],
        ]);

        return back();
    }
//
//    public function destroy($id)
//    {
//        DB::table('projects')->delete($id);
//
//        return redirect('project/index');
//    }
//

    public function view($key,$id)
    {
        $issue = Issue::find($id);
        $statuses = IssueStatus::all();
        if ($key != null) {
            $project = Project::where('key', '=', $key)
                ->first();
        }
        $projects = Project::all();
        $types = IssueType::all();
        $priorities = IssuesPriority::all();
        $users = User::all();
        return view('issue.view', ['issue'=>$issue, 'statuses'=>$statuses,
            'project'=>$project, 'types'=>$types,
            'priorities'=>$priorities, 'users'=>$users, 'projects'=>$projects]);
    }

    public function edit($key,$id)
    {
        $issue = Issue::find($id);
        $statuses = IssueStatus::all();
        $project = Project::where('key', '=', $key)
            ->first();
        $types = IssueType::all();
        $priorities = IssuesPriority::all();
        $users = User::all();
        return view('issue.edit', ['issue'=>$issue, 'statuses'=>$statuses,
            'project'=>$project, 'types'=>$types,
            'priorities'=>$priorities, 'users'=>$users]);
    }

    public function update($id,$key, Request $request)
    {
        $issue = Issue::find($id);
        $project = Project::where('key', '=', $key)
            ->first();

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

//        if(is_numeric($request->original_estimate) && is_numeric($request->remaining_estimate))
//        {
//            $orEst = mktime($request->original_estimate,0,0,0,0,0 );
//            $remEst = mktime($request->remaining_estimate,0,0,0,0,0 );
//        }

        $issue->update([
            [$issue->summary = $request->summary],
            [$issue->description = $request->description],
            [$issue->status_id = (int)$request->status_id],
            [$issue->project_id = $project->id],
            [$issue->type_id = (int)$request->type_id],
            [$issue->priority_id = (int)$request->priority_id],
            [$issue->reporter_id =  Auth::user()->id],
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
        $issue = Issue::find($id);

        return view('issue.comment.index', ['issue'=>$issue]);
    }

    public function saveComment($id, Request $request)
    {
        $date = date("Y-m-d H:i:s",time());

        $this->validate($request, [
            'text' => 'required',
        ]);

        DB::table('comments')->insert(
            array('text' => $request->text, 'user_id' =>  Auth::user()->id, 'issue_id' => $id, 'created_at'=>$date)
        );
        session()->flash('status', 'Comment added!');

        return back();
    }

    public function editComment($id)
    {
        $comment = Comment::find($id);

        return view('issue.comment.edit', ['comment'=>$comment]);
    }

//    public function updateComment($id, Request $request)
//    {
//        $comment =Comment::find($id);
//
//        $this->validate($request, [
//            'text' => 'required',
//        ]);
//
//        $comment->update([
//            [$comment->text = $request->text]
//        ]);
//
//
//        $comment->save();
//        session()->flash('status', 'Comment successfully updated!');
//
//        return redirect('issue/index');
//    }

    public function updateComment($id, Request $request)
    {
        $comment = Comment::find($id);

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

        $issue = Issue::find($id);

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
            array('comment' => $request->comment, 'user_id' =>  Auth::user()->id, 'issue_id' => $id,'issue_status_id' => (int)$request['status_id'], 'time_spent'=>(int)$request['time_spent'] )
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
        $issue = Issue::find($id);
        return view('issue.file.index', ['issue'=>$issue]);
    }

    public function saveFile($id, Request $request)
    {
        $files = Input::file('file');

        $this->validate($request, [
            'file' => 'required|max:255',
        ]);

        foreach($files as $file)
        {
            $destinationPath = 'uploads';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);

            DB::table('attachments')->insert(
                array('path' => '\uploads\\'.$file->getClientOriginalName(), 'issue_id' => $id)
            );
        }

        session()->flash('status', 'File added!');

        return back();
    }

    public function deleteFile(Request $request)
    {
       File::delete($request->filename);
        DB::table('attachments')
            ->where('attachments.path', '=',$request->filename )
            ->delete();

        session()->flash('danger', 'File has been delete!');
        return redirect('issue/index');
    }
}
