<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Region;
use App\Models\Ville;
use App\Models\Line_bon;
use Illuminate\Support\Facades\auth;
use App\Models\Historique;
use PDF;

class BonsController extends Controller
{
    public static $number=0;
    public function index(){
        $bons =Bon::where('type', '=','Livraison')->get();
        // $bons =Bon::where('client_id', '=', Auth::id())->get();
        // $bons =Bon::where('client_id', '=', Auth::id())->join('users','users.id','=','bons.client_id')->select('bons.*','users.nomComplet')->get();
        // $lines =Line_bon::get();
        $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.bon_id as bon_id','colis.*')->get();
        return view('bons_livraison')->with(['bons'=>$bons,'colis'=>$colis]);
    }
    public function store(Request $request){
        $table =explode('_' ,$request->input('colis'));
        $date = date('d-m-Y', time());
        self::$number++;
        $num_padded = sprintf("%03d",self::$number);
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
                'etat_h' => 'En Ramassage',
                'colis_id' => $coli->id,
                'par' =>Auth::id()
            ]);
            Line_bon::create([
                'colis_id' => $coli->id,
                'bon_id' => $bon->id
            ]);
            Coli::where('id','=',$coli->id)->update([
                'etat' => 'En Ramassage'
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
                        <span>Colis :</span>'.$colis.'<br>
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
    public function valider(Request $request){
        $query = Line_bon::where('id','=',$request->input('line_id'))->update([
            'valide' => true
        ]);

        $coli = Coli::where('id','=',$request->input('coli_id'))->update(['etat'=>'ramasse']);

        $Historique = Historique::where('colis_id','=',$request->input('coli_id'))->update(['etat'=>'ramasse']);

        if($query and $coli and $Historique){
            return back()->with('success','Coli valide');
        }
    }
    public function new_denvoie(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('regions.*','colis.*')
        ->where('line_bons.valide','=',true)
        ->orderBy('colis.created_at', 'DESC')
        ->get();
        $regions = Region::get();
        // $colis =Coli::join('line_bons','colis.id',"=","line_bons.colis_id")->select('line_bons.id as bon','line_bons.valide as val','line_bons.bon_id as bon_id','colis.*')->get();
        return view('new_denvoie')->with(['colis'=>$colis, 'regions'=>$regions]);
    }
    public function bon_envoie(){
        $bons =Bon::where('type', '=','envoie')->get();
        return view('bons_envoie');
    }
}
