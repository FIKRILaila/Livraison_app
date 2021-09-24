<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $articles = Article::where('client_id', '=', Auth::id())->get();
        $stock =Stock::join('articles','articles.id','=','stocks.article_id')->select('articles.*','stocks.*')->orderBy('stocks.created_at', 'DESC')->get(); ;
        return view('stock')->with(['stock'=>$stock,'articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::where('client_id', '=', Auth::id())->get();
        return view('nouveauStock')->with('articles',$articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock =Stock::create([
            'client_id'=>Auth::id(),
            'article_id'=>$request->input('article_id'),
            'quantite' => $request->input('quantite')
        ]);
        if($stock){
            return back()->with('success','Votre Stock a été ajouté avec succès et en cours de traitement');
        }
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
