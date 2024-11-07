<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class User_Email_Controller extends Controller
{
    public function users_email(){
        $users=User::get();
        return view('users.send_email',compact('users'));
    }
    public function create_user(){
        return view('users.add_user');
    }

    public function store_user(Request $request){
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        session()->flash('success', 'تم اضافة المستخدم بنجاح');
        return redirect()->route('users_email');
    }
}
