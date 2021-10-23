<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Historique;
use App\Models\Reception;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Region;
use App\Models\Ville;
use App\Models\User;
use App\Models\Line_bon;

class DistributionController extends Controller
{
    public function index(){
        $bons =Bon::where('type', '=','Distribution')
        ->join('regions','regions.id','=','bons.region_id')
        ->select('bons.*','regions.region')->orderBy('bons.created_at', 'DESC')->get();
        $regions = Region::get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->where('colis.etat','=','Reçu')
        ->orWhere([
            ['colis.etat','=','Reporté'],
            ['colis.reported_at','=',date('Y-m-d',time())]
            ])
        ->select('villes.ville','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.valide as valide','line_bons.bon_id as bon_id','colis.*')->get();
        return view('Distribution')->with(['bons'=>$bons,'colis'=>$colis,'regions'=>$regions,'Attente'=>$Attente]);
    }
    public function DistributionLivreur(){
        $bons =Bon::where('type', '=','Distribution')
        ->where('livreur_id', '=',Auth::id())
        ->where('etat', '=','Enregistré')
        ->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id',"=","line_bons.bon_id")
        ->where('bons.type', '=','Distribution')
        ->select('line_bons.valide as valide','line_bons.bon_id as bon_id','colis.*')
        // ->select('line_bons.id as bon','line_bons.valide as valide','line_bons.bon_id as bon_id','colis.*')
        ->get();
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
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Reçu')
        ->orWhere([
            ['colis.etat','=','Reporté'],
            ['colis.reported_at','=',date('Y-m-d',time())]
            ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();

        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*')
        ->get();
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($bon->id);
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function editDistribution(Request $request){
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
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
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Reçu')
        ->orWhere([
            ['colis.etat','=','Reporté'],
            ['colis.reported_at','=',date('Y-m-d',time())]
            ])
        ->select('villes.*','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        // dd($Attente);
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function Distributeur(Request $request){
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($request->input('bon_id'));
        $livreur =User::findOrFail($request->input('livreur_id'));
        Bon::where('id','=',$bon->id)->update([
            'livreur_id'=>$livreur->id
        ]);
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('colis.*','villes.ville')
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
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Reçu')
        ->orWhere([
            ['colis.etat','=','Reporté'],
            ['colis.reported_at','=',date('Y-m-d',time())]
            ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return redirect()->route('Distribution')->with('success', 'Distributeur a étè bien choisi');
        // return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
        // return back()->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function store(Request $request){
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($request->input('bon_id'));
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
            }else{
                foreach($colis as $coli){
                    if($coli->etat == "Reporté"){
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
                            'etat' => 'En Distribution',
                            'reported_at' => NULL
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

        $livreurs = User::join('villes','villes.id','=','users.ville_id')
        ->where('users.role','=','livreur')
        ->join('regions','regions.id','=','villes.region_id')
        ->select('users.id','users.nomComplet')
        ->where('regions.id','=',$bon->region_id)
        ->get();

        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->where('regions.id','=',$bon->region_id)
        ->where('colis.etat','=','Reçu')
        ->orWhere([
            ['colis.etat','=','Reporté'],
            ['colis.reported_at','=',date('Y-m-d',time())]
            ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('newDistribution')->with(['bon'=>$bon,'colis'=>$colis,'livreurs'=>$livreurs,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        
        $bon = Bon::where('id',"=",$request->input('bon_id'))->update([
            'etat'=>'Enregistré',
            'updated_at'=> date('Y-m-d H:i:s', time())
        ]);
            // return redirect()->route('Distribution');
        return back()->with('success', 'Votre bon est valide avec Succès');
    }
    public function Retirer(Request $request){
        $table =explode('_' ,$request->input('colis'));
        for($i=0;$i<count($table)-1;$i++){
            Line_bon::join('bons','bons.id','=','line_bons.bon_id')
            ->where([['bons.type','=','Distribution'],['line_bons.colis_id','=',$table[$i]]])->delete();
            Coli::where('id','=',$table[$i])->update(['etat'=>'Reçu']);
            Historique::create([
                'etat_h' => 'Reçu',
                'colis_id' => $table[$i],
                'par'=>Auth::id()
            ]);
        }
        return redirect()->route('Distribution')->with('success','votre colis a étè retiré avec succès');
    }
    public function imprimer(Request $request){
        $bon = Bon::join('users','users.id','=','bons.livreur_id')->select('bons.*','users.nomComplet','users.phone')->findOrFail($request->input('bon'));
        $bon_info =Line_bon::join('colis', 'colis.id', '=', 'line_bons.colis_id')
        ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
        ->where('bons.id',"=",$bon->id)
        ->select('colis.*')
        ->get();
        $total = 0;
        foreach ($bon_info as $info){
            $total += $info->prix;
        }
        $pdf = \App::make('dompdf.wrapper');
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
        <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }
        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }
        tr:nth-child(even) {
        background-color: #dddddd;
        }
        span{
            font-weight: bold;
        }
        .border{
            border: 2px solid black;
        }
        .info{
            width:45%;
            padding-left:2%;
            display: inline-block;
        }
        </style>
        </head>
        <body style="width:90%;margin-left:5%;">
            <div>
                <img  style="margin-top:2%; width:25%; padding-left:2%; display: inline-block;"  src="./images/Logo_MN.jpeg" alt="Logo">
                <div class="info">
                    <p>
                        <span>MN Express Livraison</span> <br>
                        Adresse : ... <br>
                        Téléphone : ... <br>
                        Email : ... <br>
                        Web Site : ...
                    </p>
                </div>
            </div>
            <hr>
            <div class="border info" style="margin-top:4%; height:10%;">
                <p>
                    <span>Livreur :</span>'.$bon->nomComplet.'<br>
                    <span>Téléphone :</span>'.$bon->phone.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Bon de Distribution:</span>'.$bon->ref.'<br>
                    <span>Date :</span>'.$bon->created_at.'<br>
                    <span>Colis :</span>'.count($bon_info).'<br>
                    <span>Total : </span>'.$total.'
                </p>
            </div>
            
            <table class="border">
                <tr>
                <th>Code Suivi</th>
                <th>Destinataire</th>
                <th>Téléphone</th>
                <th>Ville</th>
                <th>Prix</th>
                </tr>';
                foreach ($bon_info as $p){
                    $ville = Ville::findOrFail($p->ville_id);
                    $html .= ' <tr>
                    <td>'.$p->code.'</td>
                    <td>'.$p->destinataire.'</td>
                    <td>'.$p->telephone.'</td>
                    <td>'.$ville->ville.'</td>
                    <td>'.$p->prix.'</td>
                </tr>';
                }
            $html .= '</table>
        </body>
        </html>';

        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
