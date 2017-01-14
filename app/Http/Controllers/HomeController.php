<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

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
//        $request->user()->hasRole();
        $user = $request->user();

        if($request->user() != null)
        {
            if($request->user()->ifAdmin())
            {
                $users = User::all();
               return view('home', ['users'=>$users, 'user'=>$user]);
            }
//            else if(!$request->user()->hasRole())
//            {
//                return "У вас не назначены роли, обратитесь к администратору!";
//            }
            else{
                return view('welcome', ['user'=>$user]);
            }
        }
        else
        {
            return view('auth.login');
        }

//        return view('home');
    }
}
