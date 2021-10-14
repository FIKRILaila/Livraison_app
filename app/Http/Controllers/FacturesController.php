<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Coli;
use App\Models\Historique;
use App\Models\Facture;
use App\Models\User;

class FacturesController extends Controller
{
    public function index(){
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where('colis.etat','=','Refusé')
        ->orWhere('colis.etat','=','Livré')
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $clients = User::where('role', '=','client')->get();
        return view('factures',['Attente'=>$Attente,'clients'=>$clients]);
    }
    public function filtrer(Request $request){
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where([
            ['colis.etat','=','Refusé'],
            ['colis.client_id','=',$request->input('client_id')]
        ])
        ->orWhere([
            ['colis.etat','=','Livré'],
            ['colis.client_id','=',$request->input('client_id')]
        ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $clients = User::where('role', '=','client')->get();
        return view('factures',['Attente'=>$Attente,'clients'=>$clients]);
    }
}
