<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Bon;
use App\Models\Ville;
use App\Models\Line_bon;
use Illuminate\Support\Facades\auth;
use App\Models\Historique;
use PDF;

class BonsController extends Controller
{
    public function store(Request $request){
        $table =explode('_' ,$request->input('colis'));
        $bon = Bon::create();
        $total = 0;
        for($i=0;$i<count($table)-1;$i++){
            $coli = Coli::findOrFail($table[$i]);
                $total += $coli->prix;
            Historique::create([
                'etat' => 'en_cours',
                'colis_id' => $coli->id
            ]);
            Line_bon::create([
                'colis_id' => $coli->id,
                'bon_id' => $bon->id
            ]);
            Coli::where('id','=',$coli->id)->update([
                'etat' => 'en_cours'
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
        </style>
        </head>
        <body>
            <div>
                <h1>LOGO</h1>
                <div>
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
                <div>
                    <p>
                        <span>Client :</span>'.Auth::user()->nomComplet.'<br>
                        <span>Téléphone :</span>'.Auth::user()->phone.'
                    </p>
                </div>
                <div>
                    <p>
                        <span>Bon de Livraison:</span>'.$bon->id.'<br>
                        <span>Date :</span>'.$bon->created_at.'<br>
                        <span>Colis :</span>'.count($table)-1 .'<br>
                        <span>Total : </span>'.$total.'
                    </p>
                </div>
            </div>
            <table>
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
                <h3>Signature Client :</h3>
                <h3>Signature Ramasseur :</h3>
            </div>
        </body>
        </html>';

        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
