<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('users.name', '=', Auth::user()->name)
            ->first();

        return view('home.home', ['user'=>$user]);
    }

    public function presentation()
    {
        return view('presentation');
    }

    public function store(Request $request)
    {
        $user = User::all()->where('email', $request->email)->first();

        if($request->group_user)
        {
            echo $user->name." У нас присвоены права юзера!";
        }

        if($request->group_pm)
        {
            echo $user->name."...и Прожект Менеджера!";
        }

        if($request->group_admin)
        {
            echo $user->name."...и админа! Надо что-то с этим делать!";
        }
    }
}
