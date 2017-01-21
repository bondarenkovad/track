<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Requests;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
//        $user = $request->user();
        if($request->user() != null) {

            $users = User::all();
            return view('user.index', ['users' => $users]);
        }
        else
        {
            return view('auth.login');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', ['user'=>$user]);
    }

    public function create()
    {
        return view('user.create');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'active' => 'required|integer|between:0,1',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {

//        dd((int)$request['active']);
         User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
             'active'=>(int)$request['active'],
        ]);

        return redirect('user/index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user'=>$user]);
    }

    public function update($id, Request $request)
    {

        $user=User::find($id);

        $admin = $request->Administrator;
        $us = $request->User;
        $pm = $request->PM;

//        dd($request->Administrator);

        if(!$admin == null)
        {
            if($user->hasGroup('Administrator'))
            {
//                echo "Админ права уже есть!";
            }
            else
            {
                $user->addGroupToUser('Administrator');
            }

        }
        else
        {
//            echo "Aдмин чекбокс не выбран!";
        }

         if(!$us == null)
         {
             if($user->hasGroup('User'))
             {
//                 echo "Юзер права уже есть!";
             }
             else
             {
                 $user->addGroupToUser('User');
             }
         }
         else
         {
//             echo "Юзер чекбокс не выбран!";
         }

         if(!$pm == null)
         {
            if($user->hasGroup('PM'))
            {
//                echo "PM права уже есть!";
            }
            else
            {
                $user->addGroupToUser('PM');
            }
         }
         else
         {
//             echo "Пм чекбокс не выбран!";
         }

        //dd($admin, $us, $pm);

//        $user->addGroupToUser();


//
        $this->validate($request, [
            'name' => 'required|max:255',
            'active' => 'required|integer|between:0,1',
            'email' => 'required|email|max:255',
        ]);
        $user->update($request->all());
        $user->save();
        session()->flash('status', 'User successfully saved!');
        return redirect('user/index');


//        ==============================
//        dd($request->user());

////
//        $user=User::find($id);
//        $user->update($request->all());
//        $user->save();
////        User::find($id)->update($request->all());
//        session()->flash('status', 'User successfully saved!');
//        return redirect('user/index');
    }


}
