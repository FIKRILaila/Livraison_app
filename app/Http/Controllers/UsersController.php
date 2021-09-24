<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function livreurs(){
        $users= User::where('role','=','livreur')->get();
        return view('livreurs')->with('users',$users);
    }
    public function clients(){
        $users= User::where('role','=','client')->get();
        return view('clients')->with('users',$users);
    }
    public function admins(){
        $users= User::where('role','=','admin')->get();
        return view('admins')->with('users',$users);
    }
    
}
