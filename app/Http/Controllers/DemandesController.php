<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Demande;
use App\Models\Coli;
use App\Models\Ville;

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
            // ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('demandesRetour')->with('demandes',$demandes);
    }
    public function demandesRamassage(){
        if(Auth::user()->role == 'client'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Ramassage')
            ->where('demandes.client_id','=',Auth::id())
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        if(Auth::user()->role == 'admin'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','Ramassage')
            // ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('demandesRamassage')->with('demandes',$demandes);
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
            // ->where('demandes.traiter','=',false)
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
            // ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
        }
        return view('Reclamations')->with('demandes',$demandes);
    }

    public function store(Request $request){
        if($request->input('type') == "ChangementColis"){
            $colis = Coli::where('code','=', $request->input('message'))->get();
            if(count($colis) == 0){
                return back()->with('fail','Code incorrect');
            }
        }
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
        $demande = Demande::where('id','=',$request->input('demande_id'))->get();
        foreach($demande as $demande){
            if($demande->type == "ChangementColis"){
                $colis = Coli::where('code','=',$demande->message)->update(['change'=>true]);
            }
        }
        $traiter = Demande::where('id','=',$request->input('demande_id'))->update(['traiter'=>true]);
        if($traiter){
            return back()->with('success','la demande a été traité avec succès');
        }else{
            return back()->with('fail','somthing wrong');
        }
    }

    public function ChangementColis(){
        if(Auth::user()->role == 'client'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','ChangementColis')
            ->where('demandes.client_id','=',Auth::id())
            ->select('demandes.*','users.nomComplet')
            ->get();
            $colis = Coli::join('villes','villes.id','=','colis.ville_id')
            ->join('users','users.id','=','colis.client_id')
            ->where([['colis.etat','=','Refusé'],['colis.client_id','=',Auth::id()]])
            ->orWhere([['colis.etat','=','Annulé'],['colis.client_id','=',Auth::id()]])
            ->select('villes.ville','villes.frais_livraison','colis.*')
            ->orderBy('colis.created_at', 'DESC')->get();
            $villes = Ville::get();
            return view('ChangementColis')->with(['colis'=>$colis,'villes'=>$villes,'demandes'=>$demandes]);
        }
        if(Auth::user()->role == 'admin'){
            $demandes = Demande::join('users','users.id','=','demandes.client_id')
            ->where('demandes.type','=','ChangementColis')
            // ->where('demandes.traiter','=',false)
            ->select('demandes.*','users.nomComplet')
            ->get();
            return view('changementColis')->with('demandes',$demandes);
        }
    }
}
