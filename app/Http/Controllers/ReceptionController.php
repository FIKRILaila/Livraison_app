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
        // $reception =Coli::where('etat','=','Ramasse')->join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        // $lines =Line_bon::get();
        // $colis =Coli::join('villes','colis.ville_id',"=","villes.id")->get();
        // return view('newReception')->with(['bon'=>$bon,'lines'=>$lines,'colis'=>$colis]);

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
        // $reception = Reception::join('colis','colis.id','=','receptions.colis')
        // ->join('villes','villes.id','=','colis.ville_id')
        // ->get();
        // return view('newReception')->with('reception',$reception);
    }
    public function editReception(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        // $reception =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        // return view('newReception')->with(['bon'=>$bon,'reception'=>$reception]);
        // $lines =Line_bon::get();
        // $colis =Coli::join('villes','colis.ville_id',"=","villes.id")->get();
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
    }
    public function store(Request $request){
        $id = $request->input('bon_id');
        $colis = Coli::where('code','=', $request->input('code_suivi'))->get();
        foreach($colis as $coli){
            Historique::create([
                'etat_h' => 'Ramasse',
                'colis_id' => $coli->id,
                'par'=>Auth::id()
            ]);
            Line_bon::create([
                'colis_id' => $coli->id,
                'bon_id' => $id
            ]);
            Coli::where('id','=',$coli->id)->update([
                'etat' => 'Ramasse',
                'valide' => true
            ]);
        }
        $bon = Bon::findOrFail($id);
            // return redirect()->route('newReception');
            $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newReception')->with(['bon'=>$bon,'colis'=>$colis]);
            // return redirect()->route('newReception')->with('success', 'Votre code est bien saisi');
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
