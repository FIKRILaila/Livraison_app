<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Line_bon;
use App\Models\Historique;

class EnvoiController extends Controller
{
    public static $number=0;
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

    public function newEnvoi(){
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('villes.*','colis.*','users.nomMagasin','line_bons.id as bon','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();

        $date = date('d-m-Y', time());
        $number=0;
        $select = Bon::where('type','=','Envoi')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != null){
            $number = explode('-',$number)[4];
            $number++;
            $num_padded = sprintf("%04d",$number);
        }
        $num_padded = sprintf("%03d",self::$number);
        $ref ='BE-'.$date."-".$num_padded; 

        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Envoi',
            'etat'=>"Nouveau"
        ]);       
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }


    public function editEnvoi(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }


    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis = Coli::where('code','=', $request->input('code_suivi'))->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','Envoi')
        ->get();
        foreach($colis as $col){
            foreach($existed as $ex){
                if($ex->colis_id == $col->id){
                    $exist = true;
                }
            }
            if($exist == false){
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
                            'etat' => 'Ramasse'
                        ]);
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
        ->select('villes.*','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::where('id',"=",$id)->update([
            'etat'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
       return redirect()->route('Envoi')->with('success', 'Votre bon est valide avec Succès');
    }
}
