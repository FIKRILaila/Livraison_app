<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Region;
use App\Models\Bon;
use App\Models\Line_bon;
use App\Models\Historique;

class RetourController extends Controller
{
    public function index(){

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('villes.*','colis.*','users.nomMagasin','line_bons.valide as valide','line_bons.id as bon','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();

        $bons =Bon::join('regions','regions.id','=','bons.region_id')
        ->where('bons.type', '=','Retour')
        ->select('bons.*','regions.region')
        ->get();
        
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->where('colis.etat','=','Refusé')
        ->orWhere('colis.etat','=','Annulé')
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();

        $regions = Region::get();

        return view('Retour')->with(['bons'=>$bons,'colis'=>$colis,'regions'=>$regions,'Attente'=>$Attente]);
    }
    public function newRetour(Request $request){
        $date = date('d-m-Y', time());
        $number=1;
        $select = Bon::where('type','=','Retour')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='BRE-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Retour',
            'etat'=>"Nouveau",
            'region_id'=>$request->input('region_id')
        ]);      

        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Refusé')
        ->orWhere('colis.etat','=','Annulé')
        ->orderBy('colis.created_at', 'DESC')->get(); 

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.*','colis.*','users.nomMagasin','line_bons.id as bon','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();

        return view('newRetour')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function editRetour(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();

        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Refusé')
        ->orWhere('colis.etat','=','Annulé')
        ->orderBy('colis.created_at', 'DESC')->get(); 
        
        return view('newRetour')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis =  Coli::where('code','=', $request->input('code_suivi'))
        ->join('villes','villes.id','=','colis.ville_id')->select('villes.ville','colis.*')->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','Retour')
        ->get();
        foreach($colis as $col){
            foreach($existed as $ex){
                if($ex->colis_id == $col->id){
                    $exist = true;
                }
            }
            if($exist == false){
                    foreach($colis as $coli){
                        if($coli->ville == "Casablanca"){
                            Historique::create([
                                'etat_h' => 'Reçu',
                                'colis_id' => $col->id,
                                'par'=>Auth::id()
                            ]);
                            Line_bon::create([
                                'colis_id' => $col->id,
                                'bon_id' => $bon->id
                            ]);
                            Coli::where('id','=',$col->id)->update([
                                'etat' => 'Reçu',
                                'envoyer' => true
                            ]);
                        }else{
                            Historique::create([
                                'etat_h' => 'Expedié',
                                'colis_id' => $col->id,
                                'par'=>Auth::id()
                            ]);
                            Line_bon::create([
                                'colis_id' => $col->id,
                                'bon_id' => $bon->id
                            ]);
                            Coli::where('id','=',$col->id)->update([
                                'etat' => 'Expedié'
                            ]);
                        }
                        
                    }
            }
        }
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('colis.envoyer','=',false)
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Refusé')
        ->orWhere('colis.etat','=','Annulé')
        ->orderBy('colis.created_at', 'DESC')->get(); 
        return view('newRetour')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        $colis = Coli::join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide','colis.*')
        ->get();
        $bon = Bon::findOrFail($request->input('bon_id'));
        return view('Retour_valider')->with(['colis'=>$colis,'bon'=>$bon]);
    }
    public function ValiderCode(Request $request){
        $line = Line_bon::join('colis','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('colis.code','=',$request->input('code_suivi'))
        ->where('bons.id','=',$request->input('bon_id'))
        ->update(['valide'=>true]);
        $colis = Coli::where('code','=', $request->input('code_suivi'))
        ->join('villes','villes.id','=','colis.ville_id')->select('villes.ville','colis.*')->get();
        foreach($colis as $col){
            // dd($col->ville);
            if($col->ville != "Casablanca"){
               Coli::where('code','=', $request->input('code_suivi'))->update(['etat'=>"Reçu"]);
               Historique::create([
                'etat_h' => 'Reçu',
                'colis_id' => $col->id,
                'par'=>Auth::id()
            ]);
            }
        }
        $toutLines = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide')
        ->get();
        $valider = true;
        foreach($toutLines as $lin){
            if($lin->valide == false){
                $valider = false;
            }
        }
        if($valider == true){
            $bon = Bon::where('id',"=",$request->input('bon_id'))->update([
                        'etat'=>'Enregistré',
                        'updated_at'=> date('Y-m-d H:i:s', time())
                    ]);
            return redirect()->route('Retour');
        }
        $colis = Coli::join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide','colis.*')
        ->get();
        $bon = Bon::findOrFail($request->input('bon_id'));
        return view('Retour_valider')->with(['colis'=>$colis,'bon'=>$bon]);
    }
}
