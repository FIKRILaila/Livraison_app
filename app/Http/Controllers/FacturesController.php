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
            ->where([['colis.refuser','=',true],['colis.enregistre','=',false]])
            ->orWhere([['colis.annuler','=',true],['colis.fragile','=',true],['colis.enregistre','=',false]])
            ->orWhere([['colis.etat','=','Livré'],['colis.enregistre','=',false]])
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
            ['colis.enregistre','=',false],
            ['colis.client_id','=',$request->input('client_id')]
        ])
        ->orWhere([
            ['colis.annuler','=',true],
            ['colis.fragile','=',true],
            ['colis.enregistre','=',false],
            ['colis.client_id','=',$request->input('client_id')]
        ])
        ->orWhere([
            ['colis.etat','=','Livré'],
            ['colis.enregistre','=',false],
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
            $price = 0;
            $frais = 0;
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
                'etat_f' => 'Non Facturé',
                'date' =>  date('Y-m-d', time()),
                'client_id'=>$client_id
            ]);
            $client = User::findOrFail($client_id);
            foreach ($colis as $coli){
                $info_colis = Coli::join('villes','villes.id','=','colis.ville_id')->select('colis.*','villes.frais_livraison')->findOrFail($coli);
                if($info_colis->client_id == $client->id){
                    $colis_facture = Colis_facture::create([
                        'facture_id' => $facture->id,
                        'colis_id' =>$info_colis->id
                    ]);
                    Historique::create([
                        'etat_h' => 'enregistre',
                        'colis_id' =>$info_colis->id,
                        'par' => Auth::id()
                        ]);
                    Coli::where('id','=',$info_colis->id)->update([
                        'enregistre' => true
                    ]);
                    if($info_colis->etat == 'Livré'){
                        $price += $info_colis->prix;
                        
                        if($client->ville_id == $info_colis->ville_id){
                            if($info_colis->frais_change){
                                $frais += 17+ 5;
                            }else{
                                if($info_colis->fragile){
                                    $frais += 17 + 5;
                                }else{
                                    $frais += 17;
                                }
                            }
                        }else{
                            if($info_colis->frais_change){
                                $frais += $info_colis->frais_livraison + 5 ;
                            }else{
                                if($info_colis->fragile){
                                    $frais += $info_colis->frais_livraison + 5 ;
                                }else{
                                    $frais += $info_colis->frais_livraison;
                                }
                            }
                        }
                    }else{
                        $frais += 5 ;
                    }
                }
            }
            $Montant = $price - $frais;
            Facture::where('id', '=', $facture->id)->update(['Montant'=>$Montant]);
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
        $frais = 0;
        $frais_sup = 0;
        $price = 0;
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
            table{
                width : 100%;
            }
            table, th, td {
                border: 2px solid black;
                border-collapse: collapse;
            }
            span{
                font-weight: bold;
            }
            .border{
                border: 2px solid black;
            }
            .info{
                width:47%;
                padding-left:2%;
                display: inline-block;
            }
            </style>
        </head>
        <body>
            <div>
            <img  style="margin-top:2%; width:25%; padding-left:2%; display: inline-block;"  src="./images/Logo_MN.jpeg" alt="Logo">
            <div class="info"  style="margin-top:0%;">
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
                    <span>Magasin :</span>'.$client->nomMagasin.'<br>
                    <span>Client :</span>'.$client->nomComplet.'<br>
                    <span>Téléphone :</span>'.$client->phone.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Facture : </span> '.$facture->reference.'<br>
                    <span>Date :</span>'.$facture->created_at.'<br>
                    <span>Colis :</span>'.count($colis).'<br>
                </p>
            </div>
            <table>
            <tr>
                <th>Code Suivi</th>
                <th>Status</th>
                <th>Ville</th>
                <th>Prix</th>
                <th>Frais</th>
                <th>Total</th>
            </tr>';
            foreach ($colis as $coli){

                $html .= ' <tr>
                <td>'.$coli->code.'</td>
                <td>'.$coli->etat.'</td>
                <td>'.$coli->ville.'</td>';

                if($coli->annuler or $coli->refuser){
                    $html .= '<td> 0 DH</td>';
                }else{
                    $html .= '<td>'.$coli->prix.' DH</td>';
                    $price += $coli->prix;
                }
                if($coli->etat == 'Livré'){
                    if($client->ville_id == $coli->ville_id){
                        if($coli->frais_change){
                            $html .= '<td> 22 DH </td>';
                            $html .= '<td>'. $coli->prix - (17 + 5) .' DH </td>';
                            $frais += 17 + 5;
                            $frais_sup += 5;
                        }else{
                            if($coli->fragile){
                                $html .= '<td> 22 DH </td>';
                                $html .= '<td>'. $coli->prix - 22 .' DH </td>';
                                $frais += 22 ;
                                $frais_sup += 5;
                            }else{
                                $html .= '<td> 17 DH</td>';
                                $html .= '<td>'. $coli->prix - 17 .' DH </td>';
                                $frais += 17 ;
                            }
                        }
                    }else{
                        if($coli->frais_change){
                            $html .= '<td>'.$coli->frais_livraison + 5 .' DH </td>';
                            $html .= '<td>'. $coli->prix - ($coli->frais_livraison + 5) .' DH </td>';
                            $frais += $coli->frais_livraison + 5 ;
                            $frais_sup += 5;
                        }else{
                            if($coli->fragile){
                                $html .= '<td>'.$coli->frais_livraison + 5 .' DH </td>';
                                $html .= '<td>'. $coli->prix - ($coli->frais_livraison + 5) .' DH </td>';
                                $frais += $coli->frais_livraison + 5 ;
                                $frais_sup += 5;
                            }else{
                                $html .= '<td>'.$coli->frais_livraison.' DH </td>';
                                $html .= '<td>'. $coli->prix - $coli->frais_livraison .' DH </td>';
                                $frais += $coli->frais_livraison;
                            }
                        }
                    }
                }else{
                    $html .= '<td>5 DH</td>';
                    $html .= '<td>'. - 5 .' DH </td>';
                    $frais += 5 ;
                    $frais_sup += 5;
                }
            $html .= '</tr>';
            }
        $html .= '<tr>

        <td colspan="4" style="font-weight:bold;"> Total</td>
        <td>'.$frais.' DH</td>
        <td>'.$price - $frais.' DH</td>
        </tr>
        </table>
        <table style="margin-top:2%;">
            <tr>
                <td>Total Colis</td>
                <td>'.$price - $frais.'</td>
            </tr>
            <tr>
                <td>Total Frais Colis</td>
                <td>'.$frais.'</td>
            </tr>
            <tr>
                <td>Total Frais Supplementaire</td>
                <td>'.$frais_sup.'</td>
            </tr>
            <tr>
                <td>Total Net</td>
                <td>'.$price - $frais.'</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight:bold;">Sauf Erreur Ou Ommission</td>
            </tr>
        </table>
        </body>
        </html>
        ';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function update(Request $request){
        $facture = Facture::where('id', '=', $request->input('facture_id'))->update([
            'etat_f' => $request->input('etat')
        ]);
        if($facture){
            return back()->with('success','Etat modifié avec succès');
        }else{
            return back()->with('fail','Vous pouvez pas modifié l\'etat');
        }
    }
}
