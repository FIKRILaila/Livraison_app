<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Line_bon;
use App\Models\Historique;
use App\Models\User;
use App\Models\Ville;

class BonPaimentController extends Controller
{
    public function index(){
        if(Auth::user()->role == 'admin'){
            $Attente = Coli::join('users', 'users.id','=','colis.client_id')
            ->join('villes','villes.id','=','colis.ville_id')
            ->join('line_bons','colis.id','=','line_bons.colis_id')
            ->join('bons','bons.id','=','line_bons.bon_id')
            ->where([
                ['bons.type','=','Distribution'],
                ['colis.bonPaiment','=',false],
                ['colis.etat','=','Livré']
            ])
            ->select('villes.ville','colis.*','bons.livreur_id','users.nomMagasin')
            ->get();
            $livreurs = User::where('role','=','livreur')->get();
            $bons = Bon::join('users','users.id','=','bons.livreur_id')->where('bons.type','=','Paiment')->select('bons.*','users.nomComplet')->get();
            $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")
            ->select('line_bons.bon_id','colis.*')->get();
            return view('BonPaiment',['Attente'=>$Attente,'livreurs'=>$livreurs,'bons'=>$bons,'colis'=>$colis]);
        }else{
            $bons = Bon::join('users','users.id','=','bons.livreur_id')->where([['bons.type','=','Paiment'],['bons.livreur_id','=',Auth::id()]])->select('bons.*','users.nomComplet')->get();
            $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")
            ->select('line_bons.bon_id','colis.*')->get();
            return view('BonPaiment',['bons'=>$bons,'colis'=>$colis]);
        }
    }
    public function filtrer(Request $request){
        $Attente = Coli::join('users', 'users.id','=','colis.client_id')
        ->join('villes','villes.id','=','colis.ville_id')
        ->join('line_bons','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['bons.type','=','Distribution'],
            ['bons.livreur_id','=',$request->input('livreur_id')],
            ['colis.etat','=','Livré'],
            ['colis.bonPaiment','=',false]
        ])
        ->select('villes.ville','colis.*','bons.livreur_id','users.nomMagasin')
        ->get();
        $livreurs = User::where('role','=','livreur')->get();
        $bons = Bon::join('users','users.id','=','bons.livreur_id')->where('bons.type','=','Paiment')->select('bons.*','users.nomComplet')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('line_bons.bon_id','colis.*')->get();
        return view('BonPaiment',['Attente'=>$Attente,'livreurs'=>$livreurs,'bons'=>$bons,'colis'=>$colis]);
    }
    public function store(Request $request){
        $colis =explode('_' ,$request->input('colis'));
        $livreur =explode('_' ,$request->input('livreur'));
        array_pop($livreur);
        array_pop($colis);
        $ids_livreurs = array();
        array_push( $ids_livreurs, $livreur[0]);
        foreach($livreur as $liv){
            $exist = false;
            foreach ($ids_livreurs as $id){
                if($id == $liv){
                    $exist = true;
                }
            }
            if($exist == false){
                array_push( $ids_livreurs, $liv);
            }
        }
        foreach($ids_livreurs as $liv_id){
            $date = date('d-m-Y', time());
            $number=1;
            $select = Bon::where('type','=','Paiment')->get();
            foreach($select as $sel){
                $number = $sel->ref;
            }
            if($number != 1){
                $number = explode('-',$number)[4];
                $number++;
            }
            $num_padded = sprintf("%04d",$number);
            $ref ='BP-'.$date."-".$num_padded; 
            $bon = Bon::create([
                'ref' => $ref,
                'livreur_id'=>$liv_id,
                'type'=>'Paiment'
            ]);
            foreach ($colis as $coli){
                $info_coli = Coli::join('line_bons','colis.id','=','line_bons.colis_id')
                ->join('bons','bons.id','=','line_bons.bon_id')
                ->where('bons.type','=','Distribution')
                ->select('colis.*','bons.livreur_id')
                ->findOrFail($coli);
                if($info_coli->livreur_id == $liv_id){
                    Line_bon::create([
                        'bon_id' =>$bon->id,
                        'colis_id'=>$info_coli->id
                    ]);
                    Coli::where('id','=',$info_coli->id)->update(['bonPaiment'=>true]);
                    Historique::create([
                        'etat_h' => 'Bon_Paiment',
                        'colis_id' =>$info_coli->id,
                        'par' => Auth::id()
                        ]);
                }
            }
        }
        return back()->with('success','Bons de Paiment ont générés  avec succès');
    }
    public function imprimer(Request $request){
        $bon = Bon::join('users','users.id','=','bons.livreur_id')->select('bons.*','users.nomComplet','users.phone','users.commission')->findOrFail($request->input('bon'));
        $bon_info =Line_bon::join('colis', 'colis.id', '=', 'line_bons.colis_id')
        ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
        ->where('bons.id',"=",$bon->id)
        ->select('colis.*')
        ->get();
        $total = 0;
        foreach ($bon_info as $info){
            $total += $info->prix - $bon->commission;
        }
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
                <div style="width:50%; display: inline-block;">
                    <img style="margin-top:2%; width:50%; padding-left:2%; " src="./images/Logo_MN.jpeg" alt="Logo">
                </div>
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
                    <span>Livreur : </span>'.$bon->nomComplet.'<br>
                    <span>Téléphone : </span>'.$bon->phone.'<br>
                    <span>Commission : </span>'.$bon->commission.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Bon de Paiment:</span>'.$bon->ref.'<br>
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
                <div style="border: 2px solid black; width:100%; margin-top: 2%;">
                    <h3 style="margin:1% 0 1% 65%;">Montant Versé : '.$total.' DH</h3>
                </div>
        </body>
        </html>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
