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
        $number=1;
        $select = Bon::where('type','=','Livraison')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
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
                'etat_h' => 'En Attente de Ramassage',
                'colis_id' => $coli->id,
                'par' =>Auth::id()
            ]);
            Line_bon::create([
                'colis_id' => $coli->id,
                'bon_id' => $bon->id
            ]);
            Coli::where('id','=',$coli->id)->update([
                'etat' => 'En Attente de Ramassage'
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
            width:47%;
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
        ->select('colis.*')
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
            width:47%;
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
                    <span>Client :</span>'.Auth::user()->nomComplet.'<br>
                    <span>Téléphone :</span>'.Auth::user()->phone.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Bon de Livraison : </span>'.$bon->ref.'<br>
                    <span>Date : </span>'.$bon->created_at.'<br>
                    <span>Colis : </span>'.$colis.'<br>
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
    public function stickers(Request $request){
        $bon = Bon::findOrFail($request->input('bon'));
        $bon_info =Coli::join('line_bons', 'colis.id', '=', 'line_bons.colis_id')
        ->join('bons', 'bons.id', '=', 'line_bons.bon_id')
        ->where('bons.id',"=",$bon->id)
        ->select('colis.*', 'line_bons.*', 'bons.*')
        ->get();
        $html = '
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Stickers</title>
            <style>
                body{
                    font-family: arial, sans-serif;
                    font-size: 10px;
                }
                span{
                    font-weight: bold;
                }
                .border{
                    border: 2px dashed black;
                    display : inline-block;
                    width:45%;
                    margin : 2%;
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
                            <img  style="margin-top:2%; width:50%; padding-left:2%; display: inline-block;"  src="./images/Logo_MN.jpeg" alt="Logo">
                            </div>
                            <div style="display:inline-block; width:40%;">'.
                                $info->code_bar.''.$info->code .'
                            </div>
                            <hr>
                            <p style="width:75%; height:4%; margin-top:0%; display:inline-block;"><span>Vendeur:</span>'.$vendeur->nomMagasin.' <br> ('.$vendeur->phone.') <br> <span>Date:</span>'.$info->created_at.'</p>
                            <img  style="margin-top:1%; margin-bottom:2%; width:25%; display: inline-block;" src="./images/'.$vendeur->logo.'" alt="Logo">
                            <hr>
                            <div style="width:50%;">
                                <p>
                                    <span>Destinataire:</span>'.$info->destinataire.'<br>
                                    <span>Téléphone:</span>'.$info->telephone.'<br>
                                    <span>Ville: '.$ville->ville.'</span><br>
                                    <span>Adresse:</span>'.$info->adresse.'
                                </p>
                            </div>

                            <div style="margin:1% 0;">';
                            if($info->ouvrir){
                                $html .='<h3 style="width:100%; display:inline-block; font-weight:bold;">يسمح بفتح هذه الطلبية</h3>
                                </div>';
                            }else{
                                $html .='<h3 style="width:100%; display:inline-block; font-weight:bold;">لا يسمح بفتح هذه الطلبية إلا بإذن البائع</h3>
                                </div>';
                            }
                            $html.='<div style="margin:1% 0;">';
                            if($info->fragile){
                                $html.= '<div style="padding:1%; margin-top:1%; margin-right:3%; color:rgb(160, 10, 10); width:20%; display:inline-block; border: 2px solid rgb(160, 10, 10);">
                                <h3 style="margin:0 0 1% 2%";>FRAGILE</h3></div>';
                            }else{
                                $html.= '<div style="padding:1%; margin-top:1%; margin-right:3%; color:white; width:20%; display:inline-block; border: 2px solid white;">
                                <h3 style="margin:0 0 1% 2%;">FRAGILE</h3></div>';
                            }
                            if($info->remplacer){
                                $html.= '<div style="padding:1%; margin-top:0%; color:rgb(160, 10, 10); width:30%; display:inline-block; border: 2px solid rgb(160, 10, 10);">
                                <h3 style="margin:0 0 1% 2%";>A Remplacer</h3></div>';
                            }else{
                                $html.= '<div style="padding:1%; margin-top:0%; color:white; width:30%; display:inline-block; border: 2px solid white;">
                                <h3 style="margin:0 0 1% 2%";>A Remplacer</h3></div>';
                            }
                            $html.='</div>';
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
