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
    public static $number=0;
    public function index(){
        $bons =Bon::where('type', '=','Reception')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        return view('Reception')->with(['bons'=>$bons,'colis'=>$colis]);
    }
    public function newReception(){
        $date = date('d-m-Y', time());
        self::$number++;
        $num_padded = sprintf("%03d",self::$number);
        $ref ='BR-'.$date."-".$num_padded; 

        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Reception',
            'etat_r'=>"Nouveau"
        ]);

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function editReception(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis = Coli::where('code','=', $request->input('code_suivi'))->get();
        foreach($colis as $col){
            $existed = Line_bon::where('colis_id','=',$col->id)->get();
            foreach($existed as $ex){
                if($ex->id == null){
                    foreach($colis as $coli){
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
                            'etat' => 'Ramasse',
                            'valide' => true
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
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function valider(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::where('id',"=",$id)->update([
            'etat_r'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
       return redirect()->route('Reception')->with('success', 'Votre bon est valide avec Succès');
    }
}
