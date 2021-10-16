<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Coli;
use App\Models\Historique;
use App\Models\Facture;
use App\Models\Colis_facture;
use App\Models\User;

class FacturesController extends Controller
{
    public function index(){
        if(Auth::user()->role == 'admin'){
            $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
            ->join('users','users.id','=','colis.client_id')
            ->where([['colis.refuser','=',true],['colis.paye','=',false]])
            ->orWhere([['colis.etat','=','Livré'],['colis.paye','=',false]])
            ->select('villes.ville','colis.*','users.nomMagasin')
            ->orderBy('colis.created_at', 'DESC')->get();
            $clients = User::where('role', '=','client')->get();
            $factures = Facture::join('users','users.id','=','factures.client_id')->select('factures.*','users.nomComplet','users.nomMagasin')->get();
            $colis = Coli::join('villes','villes.id','=','colis.ville_id')
            ->join('users','users.id','=','colis.client_id')
            ->join('colis_factures','colis.id',"=","colis_factures.colis_id")
            ->select('villes.ville','colis.*','users.nomMagasin','colis_factures.*')
            ->orderBy('colis.created_at', 'DESC')->get();
            return view('factures',['Attente'=>$Attente,'clients'=>$clients,'colis'=>$colis,'factures'=>$factures]);
        }
        if(Auth::user()->role == 'client'){
            $factures = Facture::join('users','users.id','=','factures.client_id')->where('factures.client_id','=',Auth::id())->select('factures.*','users.nomComplet','users.nomMagasin')->get();
            $colis = Coli::join('villes','villes.id','=','colis.ville_id')
            ->join('users','users.id','=','colis.client_id')
            ->join('colis_factures','colis.id',"=","colis_factures.colis_id")
            ->select('villes.ville','colis.*','users.nomMagasin','colis_factures.*')
            ->orderBy('colis.created_at', 'DESC')->get();
            return view('factures',['colis'=>$colis,'factures'=>$factures]);
        }
    }
    public function filtrer(Request $request){
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->where([
            ['colis.refuser','=',true],
            ['colis.paye','=',false],
            ['colis.client_id','=',$request->input('client_id')]
            ])
        ->orWhere([
            ['colis.etat','=','Livré'],
            ['colis.paye','=',false],
            ['colis.client_id','=',$request->input('client_id')]
            ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $factures = Facture::join('users','users.id','=','factures.client_id')->select('factures.*','users.nomComplet','users.nomMagasin')->get();
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('colis_factures','colis.id',"=","colis_factures.colis_id")
        ->select('villes.ville','colis.*','users.nomMagasin','colis_factures.*')
        ->orderBy('colis.created_at', 'DESC')->get();
        $clients = User::where('role', '=','client')->get();
        return view('factures',['Attente'=>$Attente,'clients'=>$clients,'colis'=>$colis,'factures'=>$factures]);
    }
    public function store(Request $request){
        $colis =explode('_' ,$request->input('colis'));
        $client =explode('_' ,$request->input('client'));
        array_pop($client);
        array_pop($colis);
        $ids = array();
        array_push( $ids, $client[0]);
        foreach($client as $c){
            $exist = false;
            foreach ($ids as $id){
                if($id == $c){
                    $exist = true;
                }
            }
            if($exist == false){
                array_push( $ids, $c);
            }
        }
        foreach($ids as $client_id){
            $date = date('d-m-Y', time());
            $number=1;
            $select = Facture::get();
            foreach($select as $sel){
                $number = $sel->reference;
            }
            if($number != 1){
                $number = explode('-',$number)[4];
                $number++;
            }
            $num_padded = sprintf("%04d",$number);
            $ref ='Facture-'.$date."-".$num_padded; 
            $facture = Facture::create([
                'reference' => $ref,
                'client_id'=>$client_id]);
            foreach ($colis as $coli){
                $info_colis = Coli::findOrFail($coli);
                if($info_colis->client_id == $client_id){
                    $colis_facture = Colis_facture::create([
                        'facture_id' => $facture->id,
                        'colis_id' =>$coli
                    ]);
                }
            }
        }
        return back()->with('success','Factures generated successfully');
    }
    public function imprimer(Request $request){
        $facture = Facture::findOrFail($request->input('facture_id'));
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('colis_factures', 'colis_factures.colis_id','=','colis.id')
        ->where('colis_factures.facture_id',$facture->id)
        ->select('colis.*','villes.ville','villes.frais_livraison')
        ->get();
        $client = User::findOrFail($facture->client_id);
        $total = 0;
        $price = 0;
        $nbr_colis = 0;
        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$facture->reference.'</title>
            <style>
            body{
                font-family: arial, sans-serif;
            }
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
        <body>
            <div>
            <h1 class="info">LOGO</h1>
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
                    <span>Client :</span>'.$client->nomComplet.'<br>
                    <span>Téléphone :</span>'.$client->phone.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Facture : </span> '.$facture->reference.'<br>
                    <span>Date :</span>'.$facture->created_at.'<br>
                    <span>Colis :</span>'.$nbr_colis.'<br>
                </p>
            </div>
            <table class="border">
            <tr>
            <th>Code Suivi</th>
            <th>Status</th>
            <th>Ville</th>
            <th>Prix</th>
            <th>Frais</th>
            </tr>';
            foreach ($colis as $coli){

                $html .= ' <tr>
                <td>'.$coli->code.'</td>
                <td>'.$coli->etat.'</td>
                <td>'.$coli->ville.'</td>
                <td>';
                if($coli->etat == 'Refusé'){
                    $html .= 'O DH';
                }else{
                    $html .= $coli->prix;
                    $price += $coli->prix;
                }
                $html .='</td>';
                if($coli->etat == 'Refusé'){
                    $html .= '<td>5 DH</td>';
                    $total += 5 ;
                }elseif($client->ville == $coli->ville){
                    if($coli->fragile){
                        $html .= '<td> 22 DH </td>';
                        $total += 22 ;
                    }else{
                        $html .= '<td> 17 DH</td>';
                        $total += 17 ;
                    }
                }else{
                    if($coli->fragile){
                        $html .= '<td>'.$coli->frais_livraison + 5 .' DH </td>';
                        $total += $coli->frais_livraison + 5 ;
                    }else{
                        $html .= '<td>'.$coli->frais_livraison.' DH </td>';
                        $total += $coli->frais_livraison;
                    }
                }

            $html .= '</tr>';
            }
        $html .= '</table>
        <div style="width:100%; margin-top:2%;" class="border">
            <h3 style="margin:1% 0 1% 65%;">NET A PAYER  : '.$price - $total.' DH</h3>
        </div>
        </body>
        </html>
        ';
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
