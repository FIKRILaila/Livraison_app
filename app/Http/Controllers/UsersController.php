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
            'commission'=>$request->input('commission'),
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
        if($request->input('admin') == "non"){
            if(!Hash::check($request->input('ancien'),(Auth::user()->password))){
                return back()->with('fail','Mot de passe incorrect');
            }
        }
        if($request->input('role') =='client'){
                $request->validate([
                    'RIB' => ['required', 'string', 'min:14', 'max:255'],
                ]);
                if ($image = $request->file('logo')) {
                    $destinationPath = 'images/';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $input['logo'] = "$profileImage";
                }else{
                    $user = User::where("id","=",$request->input('user_id'))->get();
                    foreach($user as $u){
                        $input['logo'] = $u->logo;
                    }
                }
            $user = User::where("id","=",$request->input('user_id'))->update([
                'logo' => $input['logo'],
                'nomComplet' =>$request->input('nomComplet'),
                'cin' =>$request->input('cin'),
                'adresse' =>$request->input('adresse'),
                'phone' =>$request->input('phone'),
                'email' =>$request->input('email'),
                'ville_id' =>$request->input('ville_id'),
                'RIB' =>$request->input('RIB'),
                'typeBanque' =>$request->input('typeBanque'),
                'nomMagasin' =>$request->input('nomMagasin'),
                'password' => Hash::make($request->input('password'))
            ]);
        }
        if($request->input('role') =='livreur'){
            $user = User::where("id","=",$request->input('user_id'))->update([
                'nomComplet' =>$request->input('nomComplet'),
                'cin' =>$request->input('cin'),
                'adresse' =>$request->input('adresse'),
                'phone' =>$request->input('phone'),
                'email' =>$request->input('email'),
                'RIB' =>$request->input('RIB'),
                'ville_id' =>$request->input('ville_id'),
                'password' => Hash::make($request->input('password'))
            ]);
        }
        if($request->input('role') =='admin'){
            $user = User::where("id","=",$request->input('user_id'))->update([
                'nomComplet' =>$request->input('nomComplet'),
                'cin' =>$request->input('cin'),
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
