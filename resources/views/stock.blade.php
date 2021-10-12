@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('style')
<style>
    #article_image {
        border: 2px dashed gray;
        border-radius: 15px;
        background-size: cover;
        overflow: hidden;
    }
    #image {
        opacity: 0;
        object-fit: cover;
        border-radius: 15px;
        background-color: transparent;
        background-position: center center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #articleImage {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    span{
        font-weight: bold;
    }
</style>
@endsection
@section('content')
<div class="m-4">
      @if (Session::get('success'))
      <div class="alert alert-success">
          {{ Session::get('success') }}
      </div>
      @endif
      @if (Session::get('fail'))
          <div class="alert alert-danger">{{ Session::get('fail') }}</div>
      @endif
      <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-info mr-2" type="button" data-toggle="collapse" data-target="#article" aria-expanded="false" aria-controls="collapseExample">
          Nouveau Article <i class="fas fa-angle-down"></i>
        </button>
        <button class="btn btn-info mr-2" type="button" data-toggle="collapse" data-target="#newstock" aria-expanded="false" aria-controls="collapseExample">
          Nouveau Stock <i class="fas fa-angle-down"></i>
        </button>
        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#newcolis" aria-expanded="false" aria-controls="collapseExample">
            Nouveau Colis <i class="fas fa-angle-down"></i>
          </button>
      </div>
    <div class="collapse mt-4" id="article">
      <div class="card card-body">
        <h1 class="ml-4 font-weight-bold text-info">Nouveau Article :</h1>
            <div class="m-4">
            <form action="{{route('storeArticle')}}" method="post" class="col-md-12" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="reference" class="mb-2 col-form-label obligatoire">{{ __('Réference :') }}</label>
                        <div>
                            <input id="reference" type="text" class="form-control" name="reference" value="{{ old('reference') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-2 col-form-label obligatoire">{{ __('Article :') }}</label>
                        <div>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="on">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type" class="col-form-label obligatoire">{{ __('Type d\'Article :') }}</label>
                            <div>
                                <input id="type" type="text" class="form-control" name="type" value="{{ old('type') }}" required autocomplete="on">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="variante1" class="col-form-label">{{ __('Variante 1 :') }}</label>
                                <div>
                                    <input id="variante1" type="text" class="form-control" name="variante1" value="{{ old('variante1') }}" autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valeur1" class="col-form-label">{{ __('Valeur 1 :') }}</label>
                                <div>
                                    <input id="valeur1" type="text" class="form-control" name="valeur1" value="{{ old('valeur1') }}" autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="variante2" class="col-form-label">{{ __('Variante 2 :') }}</label>
                                <div>
                                    <input id="variante2" type="text" class="form-control" name="variante2" value="{{ old('variante2') }}" autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valeur2" class="col-form-label">{{ __('Valeur 2 :') }}</label>
                                <div>
                                    <input id="valeur2" type="text" class="form-control" name="valeur2" value="{{ old('valeur2') }}" autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="variante3" class="col-form-label">{{ __('Variante 3 :') }}</label>
                                <div>
                                    <input id="variante3" type="text" class="form-control" name="variante3" value="{{ old('variante3') }}" autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valeur3" class="col-form-label">{{ __('Valeur 3 :') }}</label>
                                <div>
                                    <input id="valeur3" type="text" class="form-control" name="valeur3" value="{{ old('valeur3') }}" autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="variante4" class="col-form-label">{{ __('Variante 4 :') }}</label>
                                <div>
                                    <input id="variante4" type="text" class="form-control" name="variante4" value="{{ old('variante4') }}" autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valeur4" class="col-form-label">{{ __('Valeur 4 :') }}</label>
                                <div>
                                    <input id="valeur4" type="text" class="form-control" name="valeur4" value="{{ old('valeur4') }}" autocomplete="on">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4 col-md-6 row mt-4">
                        <label for="image" class="col-form-label mt-2 mr-4 obligatoire">{{ __('Choose an Image :') }}</label>
                        <div id="article_image" class="col-md-6 mt-4">
                            <img id="articleImage" src="{{asset('images/noImage.svg')}}" alt="l'image de l'article " >
                            <input id="image" type="file" class="col-md-12 h-100" onchange="addImage(this)" name="image" value="{{ old('image') }}" required autocomplete="image" autofocus >
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                    <div class="mr-2">
                        <a href="{{route('stock')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-info">{{ __('Enregistrer') }}</button>
                    </div>
                </div>
            </form>
            </div>
      </div>
    </div>




    <div class="collapse mt-4" id="newstock">
      <div class="card card-body">
        <h1 class="ml-4 font-weight-bold text-info">Nouveau Stock</h1>
            <div class="m-4">
                <form action="{{route('storeStock')}}" method="post" class="col-md-12">
                    @csrf
                    <div class="form-group">
                        <label for="article_id" class="mb-2 col-form-label">{{ __('Article') }}</label>
                        <div>
                            <select name="article_id" id="article_id" class="form-control @error('article_id') is-invalid @enderror" value="{{ old('article_id') }}" required  autofocus autocomplete="on">
                                <option value="">article</option>
                              @foreach ($articles as $art)     
                                    <option value="{{$art->id}}">{{$art->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantite" class="mb-2 col-form-label">{{ __('Quantité') }}</label>
                        <div>
                            <input id="quantite" type="number" min="1" class="form-control @error('quantite') is-invalid @enderror" name="quantite" value="{{ old('quantite') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                        <div class="mr-2">
                            <a href="{{route('stock')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info">{{ __('Enregistrer') }}</button>
                        </div>
                    </div>
                </form>
            </div>
      </div>
    </div>

    <div class="collapse mt-4" id="newcolis">
        <div class="card card-body">
          <h1 class="ml-4 font-weight-bold text-info">Nouveau Colis</h1>
              <div class="m-4">
                <form method="POST" action="{{route('storeColisStock')}}">
                    @csrf
                    <input type="hidden" name="ville_id" id="ville_id" value="">
                    <div class="row">
                        <div class="form-group col-md-6 row">
                            <label for="ville" class="col-md-4 col-form-label">{{ __('Ville:') }}</label>
                            <div class="col-md-8">
                                <select onchange="Tarif(value)" name="ville" id="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}" required  autofocus autocomplete="on">
                                    <option value="">Ville</option>
                                    @foreach ($villes as $ville)
                                        <option value="{{$ville->id}}_{{$ville->frais_livraison}}">{{$ville->ville}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label for="article_id" class="col-md-4 col-form-label">{{ __('Article:') }}</label>
                            <div class="col-md-8">
                                <select name="article_id" id="article_id" class="form-control @error('article_id') is-invalid @enderror" value="{{ old('article_id') }}" required  autofocus autocomplete="on">
                                    <option value="">article</option>
                                  @foreach ($articles as $art)     
                                        <option value="{{$art->id}}">{{$art->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row col-md-6">
                            <label for="destinataire" class="col-md-4 col-form-label">{{ __('Destinataire :') }}</label>
                            <div class="col-md-8">
                                <input id="destinataire" type="text" class="form-control @error('destinataire') is-invalid @enderror" name="destinataire" value="{{ old('destinataire') }}" required autocomplete="on">
                            </div>
                        </div>
                        <div class="form-group row col-md-6">
                            <label for="telephone" class="col-md-4 col-form-label">{{ __('Téléphone :') }}</label>
                            <div class="col-md-8">
                                <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="on">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 row">
                            <label for="prix" class="col-md-4 col-form-label">{{ __('Prix :') }}</label>
                            <div class="col-md-8">
                                <input id="prix" type="number" min="1" class="form-control @error('prix') is-invalid @enderror" name="prix" value="{{ old('prix') }}" required autocomplete="on">
                            </div>
                        </div>
                        <div class="form-group row col-md-6">
                            <label for="quartier" class="col-md-4 col-form-label">{{ __('Quartier :') }}</label>
                            <div class="col-md-8">
                                <input id="quartier" type="text" class="form-control @error('quartier') is-invalid @enderror" name="quartier" value="{{ old('quartier') }}" required autocomplete="on">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row col-md-6">
                            <label for="code" class="col-md-4 col-form-label">{{ __('Code :') }}</label>
                            <div class="col-md-8">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="on">
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <div class="col-md-12">
                                <input type="checkbox" id="ouvrir" name="ouvrir" value="oui">
                                <label for="ouvrir">Ne pas Ouvrir le colis?</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 row">
                            <label for="fragile" class="col-md-4 mr-2 col-form-label">{{ __('Fragile :') }}</label>
                            <div class="col-md-8 row">
                                <div class="col-md-6 row">
                                    <input type="radio" id="oui" name="fragile" value="oui" class="col-md-2">
                                    <label for="oui" class="form-control col-md-10">oui</label>
                                </div>
                                <div class="col-md-6 row">
                                    <input type="radio" id="non" name="fragile" value="non" class="col-md-2" checked>
                                    <label for="non" class="form-control col-md-10">non</label>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6 form-group">
                                <label for="remplacer" class="col-md-4 mr-2 col-form-label">{{ __('A Remplacer :') }}</label>
                                <div class="col-md-8 row">
                                    <div class="col-md-6 row">
                                        <input type="radio" id="Aremplacer" name="remplacer" value="oui" class="col-md-2">
                                        <label for="Aremplacer" class="form-control col-md-10">oui</label>
                                    </div>
                                    <div class="col-md-6 row">
                                        <input type="radio" id="remplacePas" name="remplacer" value="non" checked class="col-md-2">
                                        <label for="remplacePas" class="form-control col-md-10">non</label>
                                    </div>
                                </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group col-md-12 row">
                            <label for="adresse" class="col-md-2 col-form-label">{{ __('Adresse :') }}</label>
                            <div class="col-md-10">
                                <textarea id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" autocomplete="on" autofocus>{{ old('adresse') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 row">
                            <label for="commentaire" class="col-md-2 col-form-label">{{ __('Commentaire :') }}</label>
                            <div class="col-md-10">
                                <textarea id="commentaire" name="commentaire" class="form-control @error('commentaire') is-invalid @enderror" autocomplete="on" autofocus>{{ old('commentaire') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end col-md-12">
                        <label class="col-form-label">{{ __('Tarif de Livraison :') }}
                            <span class="" id="tarif"></span> DH
                        </label>
                    </div>
                    <div class="form-group row justify-content-end m-2">
                        <div class="mr-2">
                            <a href="{{route('stock')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info">{{ __('Enregistrer') }}</button>
                        </div>
                    </div>
                </form>
              </div>
        </div>
      </div>

    <h2 class="mt-4 text-info font-weight-bold"><i class="mr-2 fas fa-angle-right"></i>Stock Actuel :</h2>
    <div class="col-md-12 mt-4 card">
        <div class="m-4">
        <table id="stock" class="display">
          <thead>
              <tr>
                  <th>Image</th>
                  <th>Article</th>
                  <th>Type d'Article</th>
                  <th>Variantes</th>
                  <th>Quantité</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($stock as $s)   
              <tr>
                <td  class="col-md-2"><img src="/images/{{$s->image}}" alt="image"  class="col-md-6"></td>
                <td>{{$s->name}}</td>
                <td>{{$s->type}}</td>
                <td>
                    @php
                    echo '<p><span>'.$s->variante1.' : </span>'. $s->valeur1.' <br>
                        <span>'. $s->variante2 .' : </span>'. $s->valeur2.' <br>
                        <span>'.$s->variante3.' : </span> '. $s->valeur3.' <br>
                        <span>'.$s->variante4.' : </span> '. $s->valeur4.' 
                        </p>';
                    @endphp
                </td>
                <td>{{$s->quantite}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready( function () {
          $('#stock').DataTable();
        });

        function addImage(input){
        var file=$("input[type=file]").get(0).files[0];
            if(file){
            var reader = new FileReader();
                reader.onload = function(){
                    $('#articleImage').attr("src",reader.result);
                    $('#image').attr("value",reader.result);
                }
            reader.readAsDataURL(file);
            }
        }
        function Tarif(value){
            let id = value.split('_')[0];
            let frais = value.split('_')[1];
            let tarif = document.querySelector("#tarif")
            document.querySelector("#ville_id").value = id
            tarif.innerHTML=`${frais}`;           
        }
    </script>
@endsection





    
