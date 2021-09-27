<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\User;
use App\Models\Region;
use App\Models\Ville;
use App\Models\Line_bon;
use Illuminate\Support\Facades\auth;
use App\Models\Historique;
use PDF;

class LivraisonController extends Controller
{
    public function index(){
        $bons =Bon::where('type', '=','Livraison')->get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        return view('bons_livraison')->with(['bons'=>$bons,'colis'=>$colis]);
    }
    public function store(Request $request){
        $table =explode('_' ,$request->input('colis'));
        $date = date('d-m-Y', time());
        $number=0;
        $select = Bon::where('type','=','Livraison')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != null){
            $number = explode('-',$number)[4];
            $number++;
            $num_padded = sprintf("%04d",$number);
        }
        $ref ='BL-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Livraison'
        ]);
        $total = 0;
        for($i=0;$i<count($table)-1;$i++){
            $coli = Coli::findOrFail($table[$i]);
                $total += $coli->prix;
            Historique::create([
                'etat_h' => 'En Attente',
                'colis_id' => $coli->id,
                'par' =>Auth::id()
            ]);
            Line_bon::create([
                'colis_id' => $coli->id,
                'bon_id' => $bon->id
            ]);
            Coli::where('id','=',$coli->id)->update([
                'etat' => 'En Attente'
            ]);
        }
        $bon_info =Line_bon::join('colis', 'colis.id', '=', 'line_bons.colis_id')
            ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
            ->where('bons.id',"=",$bon->id)
            ->select('colis.*', 'line_bons.*', 'bons.*')
            ->get();

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
            <div>
                <div class="border info" style="margin-top:0;">
                    <p>
                        <span>Client :</span>'.Auth::user()->nomComplet.'<br>
                        <span>Téléphone :</span>'.Auth::user()->phone.'
                    </p>
                </div>
                <div class="border info" style="margin-top:2%;">
                    <p>
                        <span>Bon de Livraison:</span>'.$bon->ref.'<br>
                        <span>Date :</span>'.$bon->created_at.'<br>
                        <span>Colis :</span>'.count($table)-1 .'<br>
                        <span>Total : </span>'.$total.'
                    </p>
                </div>
            </div>
            <table class="border">
                <tr>
                  <th>Destinataire</th>
                  <th>Téléphone</th>
                  <th>Ville</th>
                  <th>Prix</th>
                </tr>';
                foreach ($bon_info as $p){
                    $ville = Ville::findOrFail($p->ville_id);
                    $html .= ' <tr>
                    <td>'.$p->destinataire.'</td>
                    <td>'.$p->telephone.'</td>
                    <td>'.$ville->ville.'</td>
                    <td>'.$p->prix.'</td>
                  </tr>';
                }
              $html .= '</table>
            <div>
                <h3 class="info" style="margin-top:1%;">Signature Client :</h3>
                <h3 class="info" style="margin-top:0%;">Signature Ramasseur :</h3>
            </div>
        </body>
        </html>';

        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function imprimer(Request $request){
        $bon = Bon::findOrFail($request->input('bon'));
        $bon_info =Line_bon::join('colis', 'colis.id', '=', 'line_bons.colis_id')
        ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
        ->where('bons.id',"=",$bon->id)
        ->select('colis.*', 'line_bons.*', 'bons.*')
        ->get();
        $colis = 0;
        $total = 0;
        foreach ($bon_info as $info){
            $total += $info->prix;
            $colis++;
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
                <div class="border info" style="margin-top:0;">
                    <p>
                        <span>Client :</span>'.Auth::user()->nomComplet.'<br>
                        <span>Téléphone :</span>'.Auth::user()->phone.'
                    </p>
                </div>
                <div class="border info" style="margin-top:2%;">
                    <p>
                        <span>Bon de Livraison:</span>'.$bon->ref.'<br>
                        <span>Date :</span>'.$bon->created_at.'<br>
                        <span>Colis :</span>'.$colis.'<br>
                        <span>Total : </span>'.$total.'
                    </p>
                </div>
            
            <table class="border">
                <tr>
                <th>Destinataire</th>
                <th>Téléphone</th>
                <th>Ville</th>
                <th>Prix</th>
                </tr>';
                foreach ($bon_info as $p){
                    $ville = Ville::findOrFail($p->ville_id);
                    $html .= ' <tr>
                    <td>'.$p->destinataire.'</td>
                    <td>'.$p->telephone.'</td>
                    <td>'.$ville->name.'</td>
                    <td>'.$p->prix.'</td>
                </tr>';
                }
            $html .= '</table>
            <div>
                <h3 class="info" style="margin-top:1%;">Signature Client :</h3>
                <h3 class="info" style="margin-top:0%;">Signature Ramasseur :</h3>
            </div>
        </body>
        </html>';

        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function stickers(Request $request){
        $bon = Bon::findOrFail($request->input('bon'));
        $bon_info =Coli::join('line_bons', 'colis.id', '=', 'line_bons.colis_id')
        ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
        ->where('bons.id',"=",$bon->id)
        ->select('colis.*', 'line_bons.*', 'bons.*')
        ->get();
        $html = '<!DOCTYPE html>
        <html>
        <head>
        <style>
        span{
            font-weight: bold;
        }
        .border{
            border: 2px dashed black;
            display : inline-block;
            width:45%;
            margin: 2%;
        }
        </style>
        </head>
        <body>';
        foreach ($bon_info as $info){
            $vendeur = User::findOrFail($info->client_id);
            $ville = Ville::findOrFail($info->ville_id);
            $html.='<div class="border ">
                        <div style="width:92%; margin-left:4%">
                            <div style="display:inline-block; width:60%;">
                                <h1>LOGO</h1>
                            </div>
                            <div style="display:inline-block; width:40%;">'.
                                $info->code_bar.''.$info->code .'
                            </div>
                            <hr>
                            <p style="width:70%; margin-top:1%; display:inline-block;"><span>Vendeur:</span>'.$vendeur->nomMagasin.' <br> ('.$vendeur->phone.') <br> <span>Date:</span>'.$info->created_at.'</p>
                            <h2 style="width:30%; margin-top:0%; display:inline-block;">Logo</h2>
                            <hr>
                        <div>
                            <p>
                                <span>Destinataire:</span>'.$info->destinataire.'<br>
                                <span>Téléphone:</span>'.$info->telephone.'<br>
                                <span>Ville:</span>'.$ville->ville.'<br>
                                <span>Adresse:</span>'.$info->adresse.'
                            </p>
                        </div>
                        <div style="margin:1% 0">';
                        if($info->ouvrir){
                            $html .='<p style="width:65%; display:inline-block;">Vous Pouvez ouvrir le colis</p>';
                        }else{
                            $html .='<p <p style="width:65%; display:inline-block;">Avant d\'ouvrir le colis veuillez contacter le vendeur.</p>';
                        }
                        if($info->fragile){
                            $html.= '<div style="padding:1%; margin-top:1%; color:rgb(160, 10, 10);width:30%; display:inline-block; border: 2px solid rgb(160, 10, 10);"><h3 style="margin:0 0 1% 2%">FRAGILE</h3></div></div>';
                        }
                        $html.='
                        <div style="border: 2px solid black; width:100%;">
                            <h3 style="margin:1% 0 1% 60%;">Crbt:'.$info->prix.' DH</h3>
                        </div>
                        </div>
                    </div>';
        }
        $html .='</body>
        </html>';
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
