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

    public function index()
    {
        $issueTypes = $this->getTypes();
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
        return redirect('issue/type/index');
    }

    public function edit($id)
    {
        $issueType = $this->getTypeById($id);
        return view('issue.type.edit', ['issueType' => $issueType]);
    }

    public function update($id, Request $request)
    {
        $issueType = $this->getTypeById($id);

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

    public function getTypes()
    {
        return IssueType::all();
    }

    public function getTypeById($id)
    {
        return IssueType::find($id);
    }
}
