<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Historique;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if(Auth::user()->role == 'admin'){
            $colis = Coli::join('villes','villes.id','=','colis.ville_id')
            ->join('users','users.id','=','colis.client_id')
            ->select('villes.*','colis.*','users.nomMagasin')
            ->orderBy('colis.created_at', 'DESC')->get();
            $historique = Historique::get();
            return view('toutColis')->with(['colis'=>$colis,'historique'=>$historique]);
        }else{
            return view('home');
        }
    }
    
    public function store(Request $request){
        dd($request->input('bon'));
        $table = $request->input('bon');
        foreach ($table as $t){
            var_dump($t);
        }
        // var_dump($table);
    }

    public function retour(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')->select('villes.*','colis.*')->orderBy('colis.created_at', 'DESC')->get();
        return view('en_retour')->with('colis',$colis);
    }

    public function refuser(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')->select('villes.*','colis.*')->orderBy('colis.created_at', 'DESC')->get();
        return view('refuses')->with('colis',$colis);
    }
}
