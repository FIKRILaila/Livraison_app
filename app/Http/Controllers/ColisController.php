<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use App\Models\Coli;
use App\Models\Ville;
use App\Models\Historique;
use Illuminate\Http\Request;
use Picqer;

class ColisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ 
        $colis = Coli::where('client_id', '=',Auth::id())
        ->join('villes','villes.id','=','colis.ville_id')
        ->where('colis.etat','=','Nouveau Colis')
        ->select('villes.ville','colis.*')
        ->orderBy('colis.created_at', 'DESC')
        ->get();
        
        return view('colis')->with('colis',$colis);
    }
    public function toutColis(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->select('villes.frais_livraison','villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        $historique = Historique::join('users','users.id','=','historiques.par')->select('users.nomComplet','historiques.*')->get();
        $villes=Ville::get();
        return view('toutColis')->with(['colis'=>$colis,'historique'=>$historique,'villes'=>$villes]);
    }
    public function ColisLivreur(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')
        ->join('users','users.id','=','colis.client_id')
        ->join('line_bons','line_bons.colis_id','=','colis.id')
        ->join('bons','bons.id','=','line_bons.bon_id')
        ->where([
            ['bons.livreur_id','=',Auth::id()],
            ['bons.type','=','Distribution'],
            ['bons.etat','=','Enregistré'],
            ['colis.etat','=','En Distribution']
        ])
        ->orWhere([
            ['bons.livreur_id','=',Auth::id()],
            ['bons.type','=','Distribution'],
            ['bons.etat','=','Enregistré'],
            ['colis.etat','=','Pas de Réponse']
        ])
        ->select('villes.ville','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();

        $historique = Historique::join('users','users.id','=','historiques.par')->select('users.nomComplet','historiques.*')->get();
        return view('ColisLivreur')->with(['colis'=>$colis,'historique'=>$historique]);
    }
    public function ChangerColis(Request $request){
        $colis = Coli::where('code','=', $request->input('code'))->get();
        foreach ($colis as $col){
            if($col->id){
                return back()->with('fail','Code deja utiliser');
            }
        }
        Coli::where('id','=', $request->input('colis_id'))->update(['etat' => 'Changement de Client']);
        Historique::create([
            'etat_h' => 'Changement de Client',
            'colis_id' => $request->input('colis_id'),
            'par' =>Auth::id()
            ]);
        $input = $request->all();
        if($request->input('code')){
            $input['code'] = $request->input('code');
        }else{
            $input['code'] = uniqid();
        }
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['remplacer'] = $request->input('remplacer') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir') == "oui"?1:0;
        $input['client_id'] = Auth::id();
        $ville = Ville::where('id','=',$request->input('ville_id'))->get();
        foreach ($ville as $v){
            if($v->ville == "Casablanca"){
                $input['etat'] = 'Reçu';
            }else{
                $input['etat'] = 'Ramasse';
            }
        }
        $colis = Coli::create($input);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($colis->id, $generator::TYPE_CODE_128);
        foreach($ville as $v){
            if($v->ville == "Casablanca"){
                $input['etat'] = 'Reçu';
                Historique::create([
                    'etat_h' => 'Reçu',
                    'colis_id' => $colis->id,
                    'par' =>Auth::id()
                    ]);
            }else{
                $input['etat'] = 'Ramasse';
                Historique::create([
                    'etat_h' => 'Ramasse',
                    'colis_id' => $colis->id,
                    'par' =>Auth::id()
                    ]);
            }
        }
        $colis = Coli::where('id','=',$colis->id)->update(['code_bar'=>$barcode]);
            return back()->with('success','Votre colis a été changé avec succès');
    }
    public function storeColisStock(request $request){

        $colis = Coli::where('code','=', $request->input('code'))->get();
        foreach ($colis as $col){
            if($col->id){
                return back()->with('fail','Code deja utiliser');
            }
        }
        $input = $request->all();
        if($request->input('code')){
            $input['code'] = $request->input('code');
        }else{
            $input['code'] = uniqid();
        }
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['remplacer'] = $request->input('remplacer') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir') == "oui"?1:0;
        $input['client_id'] = Auth::id();
        $ville = Ville::where('id','=',$request->input('ville_id'))->get();
        foreach ($ville as $v){
            if($v->ville == "Casablanca"){
                $input['etat'] = 'Reçu';
            }else{
                $input['etat'] = 'Ramasse';
            }
        }
        $colis = Coli::create($input);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($colis->id, $generator::TYPE_CODE_128);
        foreach($ville as $v){
            if($v->ville == "Casablanca"){
                $input['etat'] = 'Reçu';
                Historique::create([
                    'etat_h' => 'Reçu',
                    'colis_id' => $colis->id,
                    'par' =>Auth::id()
                    ]);
            }else{
                $input['etat'] = 'Ramasse';
                Historique::create([
                    'etat_h' => 'Ramasse',
                    'colis_id' => $colis->id,
                    'par' =>Auth::id()
                    ]);
            }
        }
        $colis = Coli::where('id','=',$colis->id)->update(['code_bar'=>$barcode]);
            return back()->with('success','Votre colis a été ajouté avec succès');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){   
        $villes=Ville::all();
        return view('newColis')->with('villes',$villes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $colis = Coli::where('code','=', $request->input('code'))->get();
        foreach ($colis as $col){
            if($col->id){
                return back()->with('fail','Code deja utiliser');
            }
        }
        $input = $request->all();
        if($request->input('code')){
            $input['code'] = $request->input('code');
        }else{
            $input['code'] = uniqid();
        }
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['remplacer'] = $request->input('remplacer') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir') == "oui"?1:0;
        $input['client_id'] = Auth::id();
        $input['etat'] = 'Nouveau Colis';

        $colis = Coli::create($input);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($colis->id, $generator::TYPE_CODE_128);

        $historique =Historique::create([
            'etat_h' => 'Nouveau Colis',
            'colis_id' => $colis->id,
            'par' =>Auth::id()
            ]);

        $colis = Coli::where('id','=',$colis->id)->update(['code_bar'=>$barcode]);
            return back()->with('success','Votre colis a été ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_etat(Request $request){
        if($request->input('etat') == 'Reporté'){
            $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                'reported_at'=>$request->input('reported_at'),
                'etat' => $request->input('etat')
            ]);
            $historique =Historique::create([
                'etat_h' => $request->input('etat'),
                'colis_id' =>$request->input('colis_id'),
                'par' =>Auth::id()
                ]);
        }elseif($request->input('etat') == 'Pas de Réponse'){
            $histo = Historique::where('colis_id' ,'=',$request->input('colis_id'))->where('etat_h','=','Pas de Réponse')->get();
            if(count($histo) == 2 ){
                $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                    'etat' => $request->input('etat')
                ]);
                $historique =Historique::create([
                    'etat_h' => $request->input('etat'),
                    'colis_id' =>$request->input('colis_id'),
                    'par' =>Auth::id()
                    ]);
                $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                    'etat' => 'Annulé'
                ]);
                $historique =Historique::create([
                    'etat_h' => 'Annulé',
                    'colis_id' =>$request->input('colis_id'),
                    'par' =>Auth::id()
                    ]);
            }else{
                $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                    'etat' => $request->input('etat')
                ]);
                $historique =Historique::create([
                    'etat_h' => $request->input('etat'),
                    'colis_id' =>$request->input('colis_id'),
                    'par' =>Auth::id()
                    ]);
            }
            }else{
                $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                    'etat' => $request->input('etat')
                ]);
                $historique =Historique::create([
                    'etat_h' => $request->input('etat'),
                    'colis_id' =>$request->input('colis_id'),
                    'par' =>Auth::id()
                    ]);
                if($request->input('etat') == 'Refusé'){
                    $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                        'refuser' => true
                    ]);
                }
        }
        return back()->with('success','etat modifié avec succès');
    }
    public function update(Request $request)
    {
        $input = $request->all();
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['remplacer'] = $request->input('remplacer') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir')== "oui"?1:0;
        $colis = Coli::findOrFail($request->input('colis_id'))->update($input);     
        $colis = Coli::findOrFail($request->input('colis_id'));
        $historique =Historique::create([
            'etat_h' => $colis->etat,
            'colis_id' => $colis->id,
            'par' =>Auth::id()
            ]);
        if($colis){
            return back()->with('success','Votre colis a été modifié avec succès');
        }else{
            return back()->with('fail','somthing wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
