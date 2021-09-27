<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function livreurs(){
        $users= User::where('role','=','livreur')->get();
        $villes= Ville::get();
        return view('livreurs')->with(['users'=>$users,'villes'=>$villes]);
    }

    public function clients(){
        $users= User::where('role','=','client')->get();
        return view('clients')->with('users',$users);
    }

    public function admins(){
        $users= User::where('role','=','admin')->get();
        return view('admins')->with('users',$users);
    }
    
    public function newLivreur(Request $request){
        User::create([
            'nomComplet' =>$request->input('nomComplet'),
            'email' =>$request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone'=>$request->input('phone'),
            'ville'=>$request->input('ville'),
            'role' => 'livreur'
        ]);
        return redirect()->route('livreurs')->with('success','Compte Crée avec succès');
    }
}
