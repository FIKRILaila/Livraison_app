<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coli;


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
        return view('home');
    }
    public function store(Request $request){
        dd($request->input('bon'));
    }
    public function retour(){
        $colis = Coli::join('villes','villes.id','=','colis.ville_id')->select('villes.*','colis.*')->orderBy('colis.created_at', 'DESC')->get();
        return view('en_retour')->with('colis',$colis);
    }
}
