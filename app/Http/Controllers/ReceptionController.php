<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Historique;
use App\Models\Reception;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Line_bon;

class ReceptionController extends Controller
{
    public function index(){
        $bons =Bon::where('type', '=','Reception')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        return view('Reception')->with(['bons'=>$bons,'colis'=>$colis]);
    }
    public function newReception(){
        $date = date('d-m-Y', time());
        $number= 1;
        $select = Bon::where('type','=','Reception')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='BR-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Reception',
            'etat'=>"Nouveau"
        ]);

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function editReception(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }

    public function Retirer(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
        ->get();
        $table =explode('_' ,$request->input('colis'));
        for($i=0;$i<count($table)-1;$i++){
            Line_bon::join('bons','bons.id','=','line_bons.bon_id')
            ->where([['bons.type','=','Reception'],['line_bons.colis_id','=',$table[$i]]])->delete();
            Coli::where('id','=',$table[$i])->update(['etat'=>'En Attente de Ramassage']);
            Historique::create([
                'etat_h' => 'En Attente de Ramassage',
                'colis_id' => $table[$i],
                'par'=>Auth::id()
            ]);
        }
        return redirect()->route('Reception')->with('success','votre colis a étè retiré avec succès');
    }

    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis = Coli::where('code','=', $request->input('code_suivi'))
        ->join('villes','villes.id','=','colis.ville_id')->select('villes.ville','colis.*')->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','Reception')
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
                                'etat' => 'Reçu'
                            ]);
                        }else{
                            Historique::create([
                                'etat_h' => 'Ramasse',
                                'colis_id' => $col->id,
                                'par'=>Auth::id()
                            ]);
                            Line_bon::create([
                                'colis_id' => $col->id,
                                'bon_id' => $bon->id
                            ]);
                            Coli::where('id','=',$col->id)->update([
                                'etat' => 'Ramasse'
                            ]);
                        }
                    }
            }
        }
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function valider(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::where('id',"=",$id)->update([
            'etat'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
       return redirect()->route('Reception')->with('success', 'Votre bon est valide avec Succès');
    }
}
