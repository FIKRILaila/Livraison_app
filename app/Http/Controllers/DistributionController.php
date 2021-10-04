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

class DistributionController extends Controller
{
    public function index(){
        $bons =Bon::where('type', '=','Distribution')->orderBy('created_at', 'DESC')->get();
        $regions = Region::get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->where('colis.etat','=','Reçu')
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.valide as valide','line_bons.bon_id as bon_id','colis.*')->get();
        return view('Distribution')->with(['bons'=>$bons,'colis'=>$colis,'regions'=>$regions,'Attente'=>$Attente]);
    }
    public function DistributionLivreur(){
        $bons =Bon::where('type', '=','Distribution')
        ->where('livreur_id', '=',Auth::id())
        ->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.valide as valide','line_bons.bon_id as bon_id','colis.*')->get();
        return view('DistributionLivreur')->with(['bons'=>$bons,'colis'=>$colis]);
    }
    public function newDistribution(request $request){
        $date = date('d-m-Y', time());
        $number=1;
        $select = Bon::where('type','=','Distribution')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='BD-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'region_id'=>$request->input('region_id'),
            'ref'=> $ref,
            'type'=>'Distribution',
            'etat'=>"Nouveau"
        ]);
        $livreurs = User::join('villes','villes.id','=','users.ville_id')
        ->where('users.role','=','livreur')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('users.id','users.nomComplet')
        ->where('regions.id','=',$bon->region_id)
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('colis.etat','=','Ramasse')
        ->where('regions.id','=',$bon->region_id)
        ->orderBy('colis.created_at', 'DESC')->get();

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function editDistribution(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        $livreurs = User::join('villes','villes.id','=','users.ville_id')
        ->where('users.role','=','livreur')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('users.*','villes.*','regions.*')
        ->where('regions.id','=',$bon->region_id)
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('colis.etat','=','Reçu')
        ->where('regions.id','=',$bon->region_id)
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function Distributeur(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $livreur =User::findOrFail($request->input('livreur_id'));
        // dd($request->input('livreur_id'));
        Bon::where('id','=',$bon->id)->update([
            'livreur_id'=>$livreur->id
        ]);
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();
        $livreurs = User::join('villes','villes.id','=','users.ville_id')
        ->where('users.role','=','livreur')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('users.id','users.nomComplet')
        ->where('regions.id','=',$bon->region_id)
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('colis.etat','=','Reçu')
        ->where('regions.id','=',$bon->region_id)
        ->orderBy('colis.created_at', 'DESC')->get();
        // return redirect()->route('editDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function store(Request $request){
        $id = $request->input('bon_id');
        $bon = Bon::findOrFail($id);
        $colis = Coli::where('code','=', $request->input('code_suivi'))->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','Distribution')
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
                            'etat_h' => 'En Distribution',
                            'colis_id' => $col->id,
                            'par'=>Auth::id()
                        ]);
                        Line_bon::create([
                            'colis_id' => $col->id,
                            'bon_id' => $bon->id
                        ]);
                        Coli::where('id','=',$col->id)->update([
                            'etat' => 'En Distribution'
                        ]);
                    }
            }
        }

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->get();

        $livreurs = User::where('role','=','livreur')
        ->join('villes','villes.id','=','users.ville_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('users.*','villes.*','regions.*')
        ->where('regions.id','=',$bon->region_id)
        ->get();

        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('villes.*','colis.*','users.nomMagasin')
        ->where('colis.etat','=','Reçu')
        ->where('regions.id','=',$bon->region_id)
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        $bon = Bon::where('id',"=",$request->input('bon_id'))->update([
            'etat'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
            return redirect()->route('Distribution');
    }
}
