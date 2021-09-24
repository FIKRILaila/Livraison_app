<?php

namespace App\Http\Controllers;
use App\Models\Region;
use App\Models\Ville;
use Illuminate\Http\Request;

class VillesController extends Controller
{
    public function index(){
        $villes = Ville::orderBy('villes.ville', 'DESC')->get();
        $regions = Region::orderBy('regions.region', 'DESC')->get();
        return view('villes')->with(['regions'=>$regions, 'villes'=>$villes]);
    }
    public function store(Request $request){
        $ville = Ville::create([
            'ville' => $request->input('ville'),
            'region_id' =>$request->input('region_id'),
            'frais_livraison'=>$request->input('frais_livraison')
        ]);
        if($ville){
            return back()->with('success','Votre ville a été ajouté avec succès');
            }

    }
}
