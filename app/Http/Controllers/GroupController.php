<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Http\Requests;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
            $groups= Group::all();
            return view('group.index', ['groups' => $groups]);
    }

    public function create()
    {
        return view('group.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255|unique:groups',
        ]);

//        dd((int)$request['active']);
        Group::create([
            'name' => $request['name'],
        ]);

        return redirect('group/index');
    }

}
