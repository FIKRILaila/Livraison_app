<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\auth;



class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // $input = $request->all();
        if ($image = $request->file('image')){
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        $article = Article::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'client_id'=> Auth::id(),
            'image'=> $input['image'],
            'reference'=>$request->input('reference'),
            'variante1'=>$request->input('variante1'),
            'valeur1'=>$request->input('valeur1'),
            'variante2'=>$request->input('variante2'),
            'valeur2'=>$request->input('valeur2'),
            'variante3'=>$request->input('variante3'),
            'valeur3'=>$request->input('valeur3'),
            'variante4'=>$request->input('variante4'),
            'valeur4'=>$request->input('valeur4')
        ]);
        // $article = Article::create([$input]);
        if($article){
            return back()->with('success','Votre Article a été ajouté avec succès');
        }else{
            return back()->with('fail','Somthing went wrong');
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
