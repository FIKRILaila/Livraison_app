<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;
use App\Models\Coli;
use App\Models\Ville;
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
            return redirect()->route('toutColis');
        }
        if(Auth::user()->role == 'livreur'){
            return redirect()->route('ColisLivreur');
        }else{
            $colis = Coli::where('client_id','=',Auth::id())->get();  
            $parjour = Coli::where('client_id','=',Auth::id())->whereBetween('created_at', [date('Y-m-d 0:0:0',time()),date('Y-m-d 23:59:59',time())])->get();
            $parmois = Coli::where('client_id','=',Auth::id())->whereBetween('created_at', [date('Y-m-1 0:0:0',time()),date('Y-m-30 23:59:59',time())])->get();
            $parannee = Coli::where('client_id','=',Auth::id())->whereBetween('created_at', [date('Y-1-1 0:0:0',time()),date('Y-12-31 23:59:59',time())])->get();
            return view('home',['colis' => $colis,'parmois'=> $parmois,'parjour'=>$parjour,'parannee'=>$parannee]);
        }
    }
}
