<?php

namespace App\Http\Controllers;

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

        if($request->user() != null)
        {
            if($request->user()->hasRole())
            {
//                return $request->user()->group()->get();
               return view('home');
            }
            else{
                return view('welcome');
//                return "Походу нет роли у юзера!";
            }
        }
        else
        {
            return view('auth.login');
        }

//        return view('home');
    }
}
