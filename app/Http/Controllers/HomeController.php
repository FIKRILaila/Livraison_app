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
            return view('home');
        }
    }
}
