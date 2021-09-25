<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Bon;

class EnvoiController extends Controller
{
    public function index(){
        $colis = Coli::where('etat','=','Ramasse')
        ->join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('villes.*','colis.*','users.nomMagasin','line_bons.id as bon','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();
        $bons =Bon::where('type', '=','Envoi')->get();
        return view('bons_envoie')->with(['bons'=>$bons,'colis'=>$colis]);
    }
}
