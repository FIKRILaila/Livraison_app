<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Historique;
use App\Models\Reception;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Region;
use App\Models\User;
use App\Models\Line_bon;

class RetourClientController extends Controller
{
    public function index(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('villes.ville','colis.*','users.nomMagasin','line_bons.valide as valide','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();
        $bons =Bon::join('users','users.id','=','bons.magasin_retour')
        ->where('bons.type', '=','RetourClient')
        ->select('bons.*','users.nomMagasin')->get();
        // dd($bons);
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        // ->join('regions','regions.id','=','villes.region_id')
        ->where('colis.retourner','=',false)
        ->where('colis.etat','=','Retourné')
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $clients = User::where('role','=','Client')->get();
        return view('RetourClient')->with(['bons'=>$bons,'colis'=>$colis,'clients'=>$clients,'Attente'=>$Attente]);
    }
    public function newRetourClient(Request $request){
        $date = date('d-m-Y', time());
        $number=1;
        $select = Bon::where('type','=','RetourClient')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='BRC-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'RetourClient',
            'etat'=>"Nouveau",
            'magasin_retour'=>$request->input('magasin_retour')
        ]);      
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where('colis.client_id','=',$bon->magasin_retour)
        ->where('colis.retourner','=',false)
        ->where('colis.etat','=','Retourné')
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get(); 

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newRetourClient')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function editRetourClient(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where('colis.client_id','=',$bon->magasin_retour)
        ->where('colis.retourner','=',false)
        ->where('colis.etat','=','Retourné')
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get(); 

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        
        return view('newRetourClient')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis =  Coli::where('code','=', $request->input('code_suivi'))
        ->join('villes','villes.id','=','colis.ville_id')->select('villes.ville','colis.*')->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','RetourClient')
        ->get();
        foreach($colis as $col){
            foreach($existed as $ex){
                if($ex->colis_id == $col->id){
                    $exist = true;
                }
            }
            if($exist == false){
                    foreach($colis as $coli){
                            Line_bon::create([
                                'colis_id' => $col->id,
                                'bon_id' => $bon->id
                            ]);
                            Coli::where('id','=',$col->id)->update([
                                'retourner' => true
                            ]);
                    }
            }
        }
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where('colis.client_id','=',$bon->magasin_retour)
        ->where('colis.retourner','=',false)
        ->where('colis.etat','=','Retourné')
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get(); 

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newRetourClient')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        $bon = Bon::where('id',"=",$request->input('bon_id'))->update([
            'etat'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
        $colis = Coli::join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('colis.*')
        ->get();
        foreach($colis as $col){
            Historique::create([
                'etat_h' => 'Reçu Par Client',
                'colis_id' => $col->id,
                'par'=>Auth::id()
            ]);
            Coli::where('id','=',$col->id)->update([
                'etat' => 'Reçu Par Client'
            ]);
        }
        return back()->with('success', 'Votre bon est valide avec Succès');

    }
}
