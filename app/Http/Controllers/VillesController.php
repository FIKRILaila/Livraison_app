<?php

namespace App\Http\Controllers;
use App\Models\Region;
use App\Models\Ville;
use Illuminate\Http\Request;

class VillesController extends Controller
{
    public function index(){
        $villes = Ville::orderBy('villes.name', 'DESC')->get();
        $regions = Region::orderBy('regions.name', 'DESC')->get();
        return view('villes')->with(['regions'=>$regions, 'villes'=>$villes]);
    }
    public function store(Request $request){
        $ville = Ville::create([
            'name' => $request->input('name'),
            'region_id' =>$request->input('region_id'),
            'frais_livraison'=>$request->input('frais_livraison')
        ]);
        if($ville){
            return back()->with('success','Votre ville a été ajouté avec succès');
            }

    }
}
