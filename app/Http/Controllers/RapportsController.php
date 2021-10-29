<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facture;
use App\Models\Colis_facture;
use App\Models\Coli;
use App\Models\Rapport_bancaire;
use App\Models\Facture_rapport;
use PDF;

class RapportsController extends Controller
{
    public function index(){
        $rapports = Rapport_bancaire::get();
        $lines = Facture_rapport::join('factures','factures.id','=','facture_rapports.facture_id')->join('users','users.id','=','factures.client_id')->select('users.nomMagasin','factures.*','facture_rapports.rapport_id')->get();
        return view('rapports',['rapports' => $rapports,'lines' => $lines]);
    }
    public function Nouveau(Request $request){
        $date = $request->input('date');
        $factures = Facture::where('date','=',$date)->where('etat_f','=','Non Facturé')->get();
        if(count($factures) == 0){
            return back()->with('fail','something wrong');
        }
        $colis = Colis_facture::join('colis','colis.id','=','colis_factures.colis_id')->join('factures','factures.id','=','colis_factures.facture_id')->where('factures.date', $date)->where('factures.etat_f','=','Non Facturé')->select('colis.*')->get();
        $date = date('d-m-Y', time());
        $number=1;
        $select = Rapport_bancaire::get();
        foreach($select as $sel){
            $number = $sel->reference;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='Rapport-'.$date."-".$num_padded; 
        $rapport = Rapport_bancaire::create(['reference' => $ref]);
        foreach ($factures as $facture){
            Facture_rapport::create([
                'facture_id'=>$facture->id,
                'rapport_id'=>$rapport->id
            ]);
            Facture::where('id','=',$facture->id)->update(['etat_f' => 'Enregistré']);
        }
        foreach ($colis as $coli){
            Coli::where('id','=',$coli->id)->update(['paye'=>true]);
        }
        $total = 0;
        $lines =  Facture_rapport::join('factures','factures.id','=','facture_rapports.facture_id')->join('users','users.id','=','factures.client_id')->where('facture_rapports.rapport_id','=',$rapport->id)->select('factures.*','users.nomComplet','users.typeBanque','users.RIB')->get();
        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$rapport->reference.'</title>
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
            </style>
        </head>
        <body>
        <table class="border">
        <tr>
        <th>Client</th>
        <th>Type de Banque</th>
        <th>RIB</th>
        <th>Montant</th>
        </tr>';
        foreach($lines as $line){
            $html .='<tr>
            <td>'.$line->nomComplet.'</td>
            <td>'.$line->typeBanque.'</td>
            <td>'.$line->RIB.'</td>
            <td>'.$line->Montant.'</td>';
            $total += $line->Montant;
            $html .= '</tr>'; 
        }
        $html .= '</table>
        <div style="width:100%; margin-top:2%;" class="border">
            <h3 style="margin:1% 0 1% 65%;"> Total: '.$total.' DH</h3>
        </div>
        </body>
        </html>
        ';
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function imprimer(Request $request){
        $rapport = Rapport_bancaire::findOrFail($request->input('rapport_id'));
        $total = 0;
        $lines =  Facture_rapport::join('factures','factures.id','=','facture_rapports.facture_id')->join('users','users.id','=','factures.client_id')->where('facture_rapports.rapport_id','=',$rapport->id)->select('factures.*','users.nomComplet','users.typeBanque','users.RIB')->get();
        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$rapport->reference.'</title>
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
            </style>
        </head>
        <body>
        <div>
            <div style="width:38%; display: inline-block; margin-top:2%;">
                <img style="width:40%;" src="./images/Logo_MN.jpeg" alt="Logo">
            </div>
            <div style="width:60%; display: inline-block; margin-top:0%; height:10%;">
            <p>
                <span>Rapport bancaire : </span> '.$rapport->reference.'<br>
                <span>Date :</span>'.$rapport->created_at.'<br>
                <span>Facture :</span>'.count($lines).'<br>
            </p>
        </div>
        </div> 
        <hr>
        <table class="border" style="margin-top:2%;">
        <tr>
        <th>Client</th>
        <th>Type de Banque</th>
        <th>RIB</th>
        <th>Montant</th>
        </tr>';
        foreach($lines as $line){
            $html .='<tr>
            <td>'.$line->nomComplet.'</td>
            <td>'.$line->typeBanque.'</td>
            <td>'.$line->RIB.'</td>
            <td>'.$line->Montant.'</td>';
            $total += $line->Montant;
            $html .= '</tr>'; 
        }
        $html .= '</table>
        <div style="width:100%; margin-top:2%;" class="border">
            <h3 style="margin:1% 0 1% 65%;"> Total: '.$total.' DH</h3>
        </div>
        </body>
        </html>
        ';
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
