<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function livreurs(){
        $users= User::where('role','=','livreur')->join('villes','villes.id','=','users.ville_id')->select('users.*','villes.*')->get();
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
            'ville_id'=>$request->input('ville_id'),
            'role' => 'livreur'
        ]);
        return redirect()->route('livreurs')->with('success','Compte Crée avec succès');
    }
    public function editCompte(){
        $villes= Ville::get();
        return view('editCompte')->with('villes',$villes);
    }
    public function updateCompte(Request $request){
        if ($image = $request->file('logo')){
            dd("yes");
        }
        if(Auth::user()->role =='client'){
        //         if ($image = $request->file('logo')){
        //             $destinationPath = 'image/';
        //             $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //             $image->move($destinationPath, $profileImage);
        //             $input['logo'] = "$profileImage";
        //         }
                // else{
                //     $user = User::where("id","=",Auth::id())->get();
                //     foreach($user as $u){
                //         $input['logo'] = $u->logo;
                //     }
                // }
                // 'logo' =>$input['logo'],
                // if ($image = $request->file('logo')) {
                //     $destinationPath = 'images/';
                //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                //     $image->move($destinationPath, $profileImage);
                //     $input['logo'] = "$profileImage";
                // }else{
                //     unset($input['image']);
                // }
                $user = User::where("id","=",Auth::id())->update([
                    'nomComplet' =>$request->input('nomComplet'),
                    'cin' =>$request->input('cin'),
                    'adresse' =>$request->input('adresse'),
                    'phone' =>$request->input('phone'),
                    'email' =>$request->input('email'),
                    'nomMagasin' =>$request->input('nomMagasin'),
                    'password' => Hash::make($request->input('password'))
                ]);
        }
        if(Auth::user()->role =='livreur'){
            $user = User::where("id","=",Auth::id())->update([
                'nomComplet' =>$request->input('nomComplet'),
                'cin' =>$request->input('cin'),
                'adresse' =>$request->input('adresse'),
                'phone' =>$request->input('phone'),
                'email' =>$request->input('email'),
                'RIB' =>$request->input('RIB'),
                'ville_id' =>$request->input('ville_id'),
                'password' => Hash::make($request->input('password'))
            ]);
        }else{
            $user = User::where("id","=",Auth::id())->update([
                'nomComplet' =>$request->input('nomComplet'),
                'cin' =>$request->input('cin'),
                'adresse' =>$request->input('adresse'),
                'phone' =>$request->input('phone'),
                'email' =>$request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
        }
        if($user){
            return back()->with('success','votre compte a ete modifie avec succès');
        }else{
            return back()->with('fail','somthing wrong');
        }
    }
}
