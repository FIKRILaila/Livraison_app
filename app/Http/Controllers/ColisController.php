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
    public function index()
    {   
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')->select('villes.*','colis.*')->orderBy('colis.created_at', 'DESC')->get();
        return view('colis')->with('colis',$colis);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
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
        $input = $request->all();
        $input['fragile'] = $request->input('fragile') == "oui"?1:0;
        $input['ouvrir'] =$request->input('ouvrir')== "on"?1:0;
        $input['client_id'] = Auth::id();
        $input['etat'] = 'en_attente';

        $colis = Coli::create($input);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($colis->id, $generator::TYPE_CODE_128);

        $colis = Coli::where('id','=',$colis->id)->update(['code_bar'=>$barcode]);
       
        // $historique =Historique::create([
        //     'etat' => 'en_attente',
        //     'colis_id' => $colis->id
        // ]) ;
        return back()->with('success','Votre colis a été ajouté avec succès');
        // return redirect()->route('colis');
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
    public function update(Request $request, $id)
    {
        //
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
