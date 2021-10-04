<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Demande;

class DemandesController extends Controller
{
    public function demandesRetour(){
        if(Auth::user()->role == 'client'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Retour')
            ->where('demandes.client_id','=',Auth::id())
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        if(Auth::user()->role == 'admin'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Retour')
            ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('demandesRetour')->with('demandes',$demandes);
    }

    public function ChangementRIB(){
        if(Auth::user()->role == 'client'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','RIB')
            ->where('demandes.client_id','=',Auth::id())
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        if(Auth::user()->role == 'admin'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','RIB')
            ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('changementRIB')->with('demandes',$demandes);
    }

    public function Reclamations(){
        if(Auth::user()->role == 'client'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Reclamation')
            ->where('demandes.client_id','=',Auth::id())
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        if(Auth::user()->role == 'admin'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Reclamation')
            ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('Reclamations')->with('demandes',$demandes);
    }
    public function store(Request $request){
        $demande = Demande::create([
            'type'=>$request->input('type'),
            'message'=>$request->input('message'),
            'client_id'=>Auth::id()
        ]);
        if($demande){
            return back()->with('success','Votre demande a été ajouté avec succès');
        }else{
            return back()->with('fail','somthing wrong');
        }
    }
    public function traiter(Request $request){
        $traiter = Demande::where('id','=',$request->input('demande_id'))->update(['traiter'=>true]);
        if($traiter){
            return back()->with('success','Votre demande a été ajouté avec succès');
        }else{
            return back()->with('fail','somthing wrong');
        }
    }
}
