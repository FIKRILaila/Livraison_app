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
        ->select('villes.*','colis.*')
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
        ->where('bons.type','=','Distribution')
        ->where('colis.etat','=','En Distribution')
        ->where('bons.livreur_id','=',Auth::id())
        ->select('villes.*','colis.*','users.nomMagasin')
        ->orderBy('colis.created_at', 'DESC')->get();
        return view('ColisLivreur')->with('colis',$colis);
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
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir')== "on"?1:0;
        $input['client_id'] = Auth::id();
        $input['etat'] = 'Brouillon';
        $input['change'] = false;
        $input['paye'] = false;
        $input['valide'] = false;

        $colis = Coli::create($input);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($colis->id, $generator::TYPE_CODE_128);
        
        $historique =Historique::create([
            'etat_h' => 'Brouillon',
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
                'reported_at'=>date('Y-m-d H:i:s',time()),
                'etat' => $request->input('etat')
            ]);
        }else{
            $colis = Coli::where('id','=', $request->input('colis_id'))->update([
                'etat' => $request->input('etat')
            ]);
        }
        if($colis){
            return back()->with('success','etat modifié avec succès');
        }
        
    }
    public function update(Request $request)
    {
        // $colis = Coli::where('code','=', $request->input('code'))->get();
        // foreach ($colis as $col){
        //     if($col->id){
        //         return back()->with('fail','Code deja utiliser');
        //     }
        // }
        $input = $request->all();
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir')== "on"?1:0;
        // $input['etat'] = $request->input('etat');
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
