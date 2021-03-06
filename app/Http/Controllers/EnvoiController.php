<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use App\Models\Coli;
use App\Models\Region;
use App\Models\Ville;
use App\Models\Bon;
use App\Models\Line_bon;
use App\Models\Historique;

class EnvoiController extends Controller
{
    public function index(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->select('villes.ville','colis.*','users.nomMagasin','line_bons.valide as valide','line_bons.id as bon','line_bons.bon_id as bon_id')
        ->orderBy('colis.created_at', 'DESC')->get();
        $bons =Bon::join('regions','regions.id','=','bons.region_id')
        ->where('bons.type', '=','Envoi')
        ->select('bons.*','regions.region')
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->join('line_bons','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['colis.etat','=','Ramasse'],
            ['bons.type','=','Reception'],
            ['bons.etat','=','EnregistrĂ©']
        ])
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();
        $regions = Region::get();
        return view('bons_envoie')->with(['bons'=>$bons,'colis'=>$colis,'regions'=>$regions, 'Attente'=>$Attente]);
    }
    public function newEnvoi(Request $request){
        $date = date('d-m-Y', time());
        $number=1;
        $select = Bon::where('type','=','Envoi')->get();
        foreach($select as $sel){
            $number = $sel->ref;
        }
        if($number != 1){
            $number = explode('-',$number)[4];
            $number++;
        }
        $num_padded = sprintf("%04d",$number);
        $ref ='BE-'.$date."-".$num_padded; 
        $bon = Bon::create([
            'client_id'=>Auth::id(),
            'ref'=> $ref,
            'type'=>'Envoi',
            'etat'=>"Nouveau",
            'region_id'=>$request->input('region_id')
        ]);      
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->join('line_bons','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['colis.etat','=','Ramasse'],
            ['bons.type','=','Reception'],
            ['bons.etat','=','EnregistrĂ©'],
            ['regions.id','=',$bon->region_id]
        ])
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();

        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','colis.id',"=","line_bons.colis_id")
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($bon->id);
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function editEnvoi(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*')
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->join('line_bons','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['colis.etat','=','Ramasse'],
            ['bons.type','=','Reception'],
            ['bons.etat','=','EnregistrĂ©'],
            ['regions.id','=',$bon->region_id]
        ])
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get();
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($bon->id);
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function store(Request $request){
        $bon = Bon::findOrFail($request->input('bon_id'));
        $colis =  Coli::where('code','=', $request->input('code_suivi'))->get();
        $exist = false;
        $existed = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.type','=','Envoi')
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
                        'etat_h' => 'ExpediĂ©',
                        'colis_id' => $col->id,
                        'par'=>Auth::id()
                    ]);
                    Line_bon::create([
                        'colis_id' => $col->id,
                        'bon_id' => $bon->id
                    ]);
                    Coli::where('id','=',$col->id)->update([
                        'etat' => 'ExpediĂ©'
                    ]);
                }
            }
        }
        $colis =Coli::join('villes','colis.ville_id',"=","villes.id")
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('line_bons.bon_id','=',$bon->id)
        ->select('villes.ville','colis.*')
        ->get();
        $Attente = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('regions','regions.id','=','villes.region_id')
        ->join('line_bons','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['colis.etat','=','Ramasse'],
            ['bons.type','=','Reception'],
            ['bons.etat','=','EnregistrĂ©'],
            ['regions.id','=',$bon->region_id]
        ])
        ->select('villes.*','colis.*','users.nomMagasin','regions.region')
        ->orderBy('colis.created_at', 'DESC')->get(); 
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($bon->id);
        return view('newEnvoi')->with(['bon'=>$bon,'colis'=>$colis,'Attente'=>$Attente]);
    }
    public function valider(Request $request){
        $colis = Coli::join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('villes','villes.id','=','colis.ville_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide','colis.*','users.nomMagasin','villes.ville')
        ->get();
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($request->input('bon_id'));
        return view('Envoi_valider')->with(['colis'=>$colis,'bon'=>$bon]);
    }
    public function ValiderCode(Request $request){
        $line = Line_bon::join('colis','colis.id','=','line_bons.colis_id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where('colis.code','=',$request->input('code_suivi'))
        ->where('bons.id','=',$request->input('bon_id'))
        ->update(['valide'=>true]);
        $colis = Coli::where('code','=', $request->input('code_suivi'))
        ->join('villes','villes.id','=','colis.ville_id')->select('villes.ville','colis.*')->get();
        foreach($colis as $col){
            Coli::where('code','=', $col->code)->update(['etat'=>"ReĂ§u"]);
            Historique::create([
            'etat_h' => 'ReĂ§u',
            'colis_id' => $col->id,
            'par'=>Auth::id()
            ]);
        }
        $toutLines = Line_bon::join('bons','bons.id','=','line_bons.bon_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide')
        ->get();
        $valider = true;
        foreach($toutLines as $lin){
            if($lin->valide == false){
                $valider = false;
            }
        }
        if($valider == true){
            $bon = Bon::where('id',"=",$request->input('bon_id'))->update([
                        'etat'=>'EnregistrĂ©',
                        'updated_at'=> date('Y-m-d H:i:s', time())
                    ]);
            return redirect()->route('Envoi')->with('success', 'Votre bon est valide avec SuccĂ¨s');
        }
        $colis = Coli::join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('villes','villes.id','=','colis.ville_id')
        ->where('bons.id','=',$request->input('bon_id'))
        ->select('line_bons.valide','colis.*','users.nomMagasin','villes.ville')
        ->get();
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('regions.region','bons.*')->findOrFail($request->input('bon_id'));
        return view('Envoi_valider')->with(['colis'=>$colis,'bon'=>$bon]);
    }
    public function Retirer(Request $request){
        $table =explode('_' ,$request->input('colis'));
        for($i=0;$i<count($table)-1;$i++){
            Line_bon::join('bons','bons.id','=','line_bons.bon_id')
            ->where([['bons.type','=','Envoi'],['line_bons.colis_id','=',$table[$i]]])->delete();
            Coli::where('id','=',$table[$i])->update(['etat'=>'Ramasse']);
            Historique::create([
                'etat_h' => 'Ramasse',
                'colis_id' => $table[$i],
                'par'=>Auth::id()
            ]);
        }
        return redirect()->route('Envoi')->with('success','votre colis a Ă©tĂ¨ retirĂ© avec succĂ¨s');
    }
    public function imprimer(Request $request){
        $bon = Bon::join('regions','regions.id','=','bons.region_id')->select('bons.*','regions.region')->findOrFail($request->input('bon'));
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
                <div style="width:50%; display: inline-block;">
                    <img style="margin-top:2%; width:50%; padding-left:2%; " src="./images/Logo_MN.jpeg" alt="Logo">
                </div>
                <div class="info">
                    <p>
                        <span>MN Express Livraison</span> <br>
                        Adresse : ... <br>
                        TĂ©lĂ©phone : ... <br>
                        Email : ... <br>
                        Web Site : ...
                    </p>
                </div>
            </div>
            <hr>
            <div class="border info" style="margin-top:4%; height:10%;">
                <p>
                    <span>RĂ©gion :</span>'.$bon->region.'
                </p>
            </div>
            <div class="border info" style="margin-top:0%; height:10%;">
                <p>
                    <span>Bon d\'Envoie:</span>'.$bon->ref.'<br>
                    <span>Date :</span>'.$bon->created_at.'<br>
                    <span>Colis :</span>'.count($bon_info).'<br>
                    <span>Total : </span>'.$total.'
                </p>
            </div>
            
            <table class="border">
                <tr>
                <th>Code Suivi</th>
                <th>Destinataire</th>
                <th>TĂ©lĂ©phone</th>
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
