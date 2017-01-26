<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\IssueType;
use Illuminate\Support\Facades\DB;

class IssueTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
            $issueTypes = IssueType::all();
            return view('issue.type.index', ['issueTypes' => $issueTypes]);
    }

    public function create()
    {
        return view('issue.type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:issue_types',
        ]);

      IssueType::create([
        'name' => $request['name'],
        ]);

        return redirect('issue/type/index');
    }

    public function destroy($id)
    {
        DB::table('issue_types')->delete($id);
//        $issueType = IssueType::find($id);
////        dd( $issueType);
//        $issueType->delete();

        return redirect('issue/type/index');
    }

    public function edit($id)
    {
        $issueType = IssueType::find($id);
        return view('issue.type.edit', ['issueType'=>$issueType]);
    }

    public function update($id, Request $request)
    {
        $issueType=IssueType::find($id);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $issueType->update([
            [$issueType->name = $request->name],
        ]);


        $issueType->save();
        session()->flash('status', 'Issue Type successfully updated!');

        return redirect('issue/type/index');
    }
}